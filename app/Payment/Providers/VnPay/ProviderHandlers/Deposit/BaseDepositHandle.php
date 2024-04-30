<?php

namespace App\Payment\Providers\VnPay\ProviderHandlers\Deposit;

use App\Enum\DepositStatusEnum;
use App\Enum\PaymentTypeEnum;
use App\Events\Payment\ProviderTransactionApproved;
use App\Exceptions\BusinessLogicException;
use App\Models\DepositTransaction;
use App\Models\User;
use App\Payment\Providers\VnPay\Constants\TransactionState;
use App\Payment\Providers\VnPay\ProviderHandlers\BaseHandler;
use App\Payment\Providers\VnPay\Service;
use App\Vendors\Localization\Money;

abstract class BaseDepositHandle extends BaseHandler
{
    public $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function paymentType()
    {
        return PaymentTypeEnum::DEPOSIT;
    }

    public function getDepositEndpoint()
    {
        return $this->service->getProviderParam('endpoints.deposit');
    }

    public function getTransactionOrderInfo(User $user, DepositTransaction $transaction, $payChannel = 'transfer')
    {
        $orderInfo = vsprintf('%s.%s.%s', [
            $user->username,
            $payChannel,
            $this->service->getTransactionIdWithPrefix($transaction->id),
        ]);

        return $orderInfo;
    }

    public function sendTransactionToProvider($transaction)
    {
        $requestPayload = $this->parseProviderRequestPayload($transaction);

        $queryString = $this->parseQueryString($requestPayload);

        $redirectUrl = $this->service->generateUrl($this->service->getProviderParam('base_api_url') . $this->getDepositEndpoint()). '?' . $queryString;

        $redirectOutput = $this->parseRedirectOutput(['redirect_url' => $redirectUrl]);

        $transaction = $this->appendProviderResponseMeta($transaction, [
            'redirect_output' => $redirectOutput,
        ]);

        $transaction->save();

        return $transaction;
    }

    public function verifyTransactionProactively($transaction)
    {
        return $transaction;
    }

    public function verifyTransactionPassively($data) {
        return [];
    }

    public function parseQueryString($payload)
    {
        ksort($payload);

        $query = '';
        $i = 0;
        $hashdata = '';

        foreach ($payload as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }

            $query .= urlencode($key) . '=' . urlencode($value) . '&';
        }

        $vnpSecureHash = hash_hmac('sha512', $hashdata, $this->service->getProviderParam('credentials.vnp_hash_secret'));

        $query .= 'vnp_SecureHash=' . $vnpSecureHash;

        return $query;
    }

    public function processProviderDeposit($request)
    {
        $providerPayload = $request->all();

        $providerStatus = data_get($providerPayload, 'vnp_TransactionStatus');

        $transactionStatus = $this->parseStatus($providerStatus);

        $transaction = $this->service->findByTransactionId($this->service->removePrefix(data_get($providerPayload, 'vnp_TxnRef')));

        if ($transaction->reference_id) {
            $transaction->reference_id = data_get($providerPayload, 'vnp_TransactionNo');
            $transaction->save();
        }

        if ($transactionStatus != DepositStatusEnum::PENDING) {
            $this->processDepositTransaction($transaction, $providerPayload, $transactionStatus);
        }

        return $this->parseSuccessResponse();
    }

    public function processDepositTransaction($transaction, $providerPayload, $transactionStatus)
    {
        $currencyCode = $this->service->getProviderParam('default_currency_code');
        $providerTransactionCurrency = $this->service->parseFromProviderCurrency($currencyCode);

        if ($providerTransactionCurrency != $transaction->currency_code) {
            throw new BusinessLogicException("Inconsistent between transaction provider currency ($providerTransactionCurrency) and transaction currency ($transaction->currency).");
        }

        $transactionAmount = Money::make($transaction->amount, $transaction->currency_code);

        $providerTransactionAmount = $transactionAmount->createFromAmount(data_get($providerPayload, 'vnp_Amount'))->dividedBy(100)->abs();

        $updates = [];

        if ($this->isProviderTransactionFailed($providerPayload)) {
            $updates = array_merge($updates, [
                'note' => implode(PHP_EOL, array_filter_empty([$this->parseProviderTransactionErrorMessage($providerPayload), $transaction->note])),
            ]);
        }

        if (! $transactionAmount->eq($providerTransactionAmount)) {
            // The providerTransactionAmount is final amount that used to increase/decrease player balance.
            // so we need to update the transaction amount to providerTransactionAmount.
            $transaction->update([
                'amount' => $providerTransactionAmount->__toString(),
                'convert_amount' => $providerTransactionAmount->convertedTo($transaction->convert_currency, $transaction->rate)->__toString()
            ]);
        }

        if (! $transactionAmount->eq($providerTransactionAmount)) {
            // The providerTransactionAmount is final amount that used to increase/decrease player balance.
            // so we need to update the transaction amount to providerTransactionAmount.
            $transaction->update([
                'amount' => $providerTransactionAmount->__toString(),
                'convert_amount' => $providerTransactionAmount->convertedTo($transaction->convert_currency, $transaction->rate)->__toString()
            ]);

            $transaction->save();
        }

        $transaction = $this->service->updateTransactionStatus($transaction, $transactionStatus, $updates, true);

        if ($transactionStatus === DepositStatusEnum::APPROVED) {
            ProviderTransactionApproved::dispatch($transaction, $providerPayload, $this->paymentChannel(), $this->paymentType(), $this->service::providerCode());
        }

        return $transaction;
    }

    /**
     * Parse provider transaction status to internal transaction status.
     * @param mixed $providerStatus
     * @param bool $throwIfNotFound
     * @return array
     */
    public function parseStatus($providerStatus, $throwIfNotFound = true)
    {
        $mappers = [
            TransactionState::PENDING => DepositStatusEnum::PENDING,
            TransactionState::APPROVED => DepositStatusEnum::APPROVED,
            TransactionState::FAILED => DepositStatusEnum::FAILED,
            TransactionState::SUSPECTED_OF_FRAUD => DepositStatusEnum::FAILED,
        ];

        $status = $mappers[$providerStatus] ?? null;

        if ($status === null && $throwIfNotFound) {
            throw new BusinessLogicException("Invalid provider status $providerStatus.");
        }

        return $status;
    }
}
