<?php

namespace App\Payment\Concerns;

use App\Models\DepositTransaction;

interface DepositByApi
{
    /**
     * Send deposit transaction to payment provider
     *
     * @param DepositTransaction $transaction
     */
    public function sendTransactionToProvider($transaction);   

    /**
     * Get deposit transaction from payment provider
     *
     * @param DepositTransaction $transaction
     * @example - return
     * ```php
     * [
     *    'status' => DepositStatus::PENDING,
     *    'detail_transaction' => [],  // provider api response
     * ]
     * ```
     */
    public function verifyTransactionProactively($transaction);

    /**
     * Verify deposit transaction when receive callback from provider
     *
     * @param mixed $data - Provider params
     * @return mixed
     */
    public function verifyTransactionPassively($data);
}