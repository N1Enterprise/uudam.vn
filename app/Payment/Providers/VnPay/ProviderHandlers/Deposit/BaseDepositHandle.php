<?php

namespace App\Payment\Providers\VnPay\ProviderHandlers\Deposit;

use App\Enum\DepositStatusEnum;
use App\Enum\PaymentTypeEnum;
use App\Events\Payment\ProviderTransactionApproved;
use App\Exceptions\BusinessLogicException;
use App\Exceptions\ExceptionCode;
use App\Models\DepositTransaction;
use App\Models\User;
use App\Payment\Providers\VnPay\Constants\IPNResponseCode;
use App\Payment\Providers\VnPay\Constants\StateResponseCode;
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

        $providerStatus = data_get($providerPayload, 'vnp_ResponseCode');

        $transactionStatus = $this->parseStatus($providerStatus);

        $transaction = $this->service->findByTransactionId($this->service->removePrefix(data_get($providerPayload, 'vnp_TxnRef')), false);

        if (! ($transaction instanceof DepositTransaction)) {
            throw new BusinessLogicException('Order Not Found', ExceptionCode::INVALID_TRANSACTION, StateResponseCode::ORDER_NOT_FOUND);
        }

        if (! $transaction->reference_id) {
            $transaction->reference_id = data_get($providerPayload, 'vnp_TransactionNo');
            $transaction->save();
        }

        if ($transactionStatus != DepositStatusEnum::PENDING) {
            $this->processDepositTransaction($transaction, $providerPayload, $transactionStatus);
        }

        return $this->parseSuccessResponse($providerPayload);
    }

    public function processDepositTransaction($transaction, $providerPayload, $transactionStatus)
    {
        $currencyCode = $this->service->getProviderParam('default_currency_code');
        $providerTransactionCurrency = $this->service->parseFromProviderCurrency($currencyCode);

        if ($providerTransactionCurrency != $transaction->currency_code) {
            throw new BusinessLogicException("Inconsistent between transaction provider currency ($providerTransactionCurrency) and transaction currency ($transaction->currency).");
        }

        $transactionAmount = Money::make($transaction->amount, $transaction->currency_code);

        $providerTransactionAmount = $transactionAmount->createFromAmount(data_get($providerPayload, 'vnp_Amount'))->dividedBy(100, Money::ROUND_HALF_UP)->abs();

        $updates = [];

        if ($this->isProviderTransactionFailed($providerPayload)) {
            $updates = array_merge($updates, [
                'note' => implode(PHP_EOL, array_filter_empty([$this->parseProviderTransactionErrorMessage($providerPayload), $transaction->note])),
            ]);
        }

        if (! $transactionAmount->eq($providerTransactionAmount)) {
            throw new BusinessLogicException('Invalid amount', ExceptionCode::INVALID_TRANSACTION, StateResponseCode::INVALID_AMOUNT);
        }

        if ($transaction->reference_id && $transaction->isApproved()) {
            throw new BusinessLogicException('Order already confirmed', ExceptionCode::INVALID_TRANSACTION, StateResponseCode::ORDER_ALREADY_CONFIRMED);
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
            IPNResponseCode::TRANSACTION_SUCCESS => DepositStatusEnum::APPROVED,
            IPNResponseCode::TRANSACTION_SUSPECTED_FRAUD => DepositStatusEnum::FAILED,
            IPNResponseCode::TRANSACTION_FAILED_CUSTOMER_NOT_REGISTERED => DepositStatusEnum::FAILED,
            IPNResponseCode::TRANSACTION_FAILED_INCORRECT_AUTHENTICATION => DepositStatusEnum::FAILED,
            IPNResponseCode::TRANSACTION_FAILED_EXPIRED => DepositStatusEnum::FAILED,
            IPNResponseCode::TRANSACTION_FAILED_CUSTOMER_ACCOUNT_LOCKED => DepositStatusEnum::FAILED,
            IPNResponseCode::TRANSACTION_FAILED_INCORRECT_OTP => DepositStatusEnum::FAILED,
            IPNResponseCode::TRANSACTION_CANCELLED_BY_CUSTOMER => DepositStatusEnum::FAILED,
            IPNResponseCode::TRANSACTION_FAILED_INSUFFICIENT_BALANCE => DepositStatusEnum::FAILED,
            IPNResponseCode::TRANSACTION_FAILED_EXCEED_DAILY_LIMIT => DepositStatusEnum::FAILED,
            IPNResponseCode::BANK_UNDER_MAINTENANCE => DepositStatusEnum::FAILED,
            IPNResponseCode::TRANSACTION_FAILED_EXCEED_PAYMENT_ATTEMPTS => DepositStatusEnum::FAILED,
            IPNResponseCode::OTHER_ERRORS => DepositStatusEnum::FAILED,
        ];

        $status = $mappers[$providerStatus] ?? null;

        if ($status === null && $throwIfNotFound) {
            throw new BusinessLogicException("Invalid provider status $providerStatus.");
        }

        return $status;
    }
}
