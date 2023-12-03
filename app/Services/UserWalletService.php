<?php

namespace App\Services;

use App\Enum\ActivationStatusEnum;
use App\Enum\TransactionTypeEnum;
use App\Enum\UserWalletTypeEnum;
use App\Exceptions\BusinessLogicException;
use App\Exceptions\ExceptionCode;
use App\Repositories\Contracts\UserWalletRepositoryContract;
use App\Services\BaseService;
use App\Vendors\Localization\SystemCurrency;
use Illuminate\Support\Facades\DB;

class UserWalletService extends BaseService
{
    public $userWalletRepository;

    public $allowVoidTransfer = false;

    public function __construct(UserWalletRepositoryContract $userWalletRepository)
    {
        $this->userWalletRepository = $userWalletRepository;
    }

    /**
     * Get wallet or create new one if not found
     */
    public function getWalletByCurrency($userId, $currencyCode, $type = UserWalletTypeEnum::SHOPPING, $orderId = null)
    {
        return DB::transaction(function() use($userId, $currencyCode, $type, $orderId) {
            $user = app(UserService::class)->show($userId);

            $currency = SystemCurrency::get($currencyCode);

            if($user->currency_code != $currency->getCurrencyCode()) {
                throw new BusinessLogicException('Invalid user currency.', ExceptionCode::INVALID_USER_CURRENCY);
            }

            $wallet = $this->userWalletRepository->firstOrCreate([
                'user_id'       => $user->getKey(),
                'currency_code' => $currency->getCurrencyCode(),
                'type'          => $type,
                'order_id'      => $orderId,
            ], [
                'status'    => 1,
                'balance'   => 0,
                'activated' => 0,
            ]);

            $wallet->update([
                'status' => ActivationStatusEnum::ACTIVE,
            ]);

            return $wallet;
        });
    }

    public function allowVoidTransfer($bool = true)
    {
        $this->allowVoidTransfer = $bool;

        return $this;
    }

    public function transfer(
        $amount,
        $fromWallet = null,
        $toWallet = null,
        $debitType = TransactionTypeEnum::WITHDRAW,
        $creditType = TransactionTypeEnum::DEPOSIT,
        $meta = []
    ) {

    }
}
