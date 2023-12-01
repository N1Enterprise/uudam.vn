<?php

namespace App\Services;

use App\Enum\DepositStatusEnum;
use App\Models\BaseModel;
use App\Repositories\Contracts\DepositTransactionRepositoryContract;
use App\Services\BaseService;
use App\Vendors\Localization\Money;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\PaymentOption;
use App\Models\User;
use App\Models\Order;
use App\Vendors\Localization\SystemCurrency;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class DepositTransactionService extends BaseService
{
    public $depositTransactionRepository;
    public $paymentOptionService;
    public $orderService;
    public $userService;

    public function __construct(
        DepositTransactionRepositoryContract $depositTransactionRepository,
        PaymentOptionService $paymentOptionService,
        OrderService $orderService,
        UserService $userService
    ) {
        $this->depositTransactionRepository = $depositTransactionRepository;
        $this->paymentOptionService = $paymentOptionService;
        $this->orderService = $orderService;
        $this->userService = $userService;
    }

    public function show($id)
    {
        return $this->depositTransactionRepository->findOrFail($id);
    }

    public function update($attributes, $id)
    {
        return $this->depositTransactionRepository->update($attributes, $id);
    }

    public function searchByAdmin($data = [])
    {
        $where = array_filter([
            'id' => data_get($data, 'id')
        ]);

        $builder = $this->depositTransactionRepository
            ->with(['user', 'paymentOption', 'order'])
            ->whereColumnsLike(data_get($data, 'query'), ['id', 'user.name', 'user.email', 'amount', 'uuid'])
            ->scopeQuery(function($q) use ($data) {

                $statuses = Arr::wrap(data_get($data, 'status', []));

                if (! empty($statuses)) {
                    $q->whereIn('status', $statuses);
                }

                if ($createdAtRange = data_get($data, 'created_at_range', [])) {
                    $q->whereBetween('created_at', $createdAtRange);
                }

                if ($updatedAtRange = data_get($data, 'updated_at_range', [])) {
                    $q->whereBetween('updated_at', $updatedAtRange);
                }

                if ($referenceId = data_get($data, 'reference_id')) {
                    $q->where('reference_id', $referenceId);
                }

                if ($uuid = data_get($data, 'uuid')) {
                    $q->where('uuid', $uuid);
                }

                if ($paymentOption = data_get($data,'payment_option_id')){
                    $q->where('payment_option_id',$paymentOption);
                }

                $q->whereRelation('user', function ($q) use ($data) {
                    if (data_get($data, 'search_exact') && $usernameOrId = data_get($data, 'user_username_or_user_id')) {
                        $q->where('name', $usernameOrId)
                            ->where('username', $usernameOrId)
                            ->orWhere('id', $usernameOrId);
                    }
                });

                $q->whereRelation('order', function($q) use ($data) {
                    $orderCode = data_get($data, 'order_code');

                    if (! empty($orderCode)) {
                        $q->where('order_code', $orderCode);
                    }

                    $orderStatuses = Arr::wrap(data_get($data, 'order_status', []));

                    if (! empty($orderStatuses)) {
                        $q->whereIn('order_status', $orderStatuses);
                    }

                    $orderPaymentStatuses = Arr::wrap(data_get($data, 'order_payment_status', []));

                    if (! empty($orderPaymentStatuses)) {
                        $q->whereIn('payment_status', $orderPaymentStatuses);
                    }
                });
            });

        if (! data_get($data, 'search_exact')) {
            $builder->whereColumnsLike(data_get($data, 'user_username_or_user_id'), ['user.name', 'user.id']);
        }

        return $builder->search($where);
    }

    public function createByUser(
        $user,
        $amount,
        $currencyCode,
        $paymentOptionId,
        $orderId,
        $createdBy,
        $bankTransferInfo = [],
        $meta = []
    ) {
        /** @var PaymentOption */
        $paymentOption = $this->paymentOptionService->show($paymentOptionId);

        /** @var Order */
        $order = $this->orderService->show($orderId);

        /** @var User */
        $user = $this->userService->show($user);

        $amount = Money::make($amount, $currencyCode);

        if (! $createdBy instanceof Model) {
            throw new \Exception('Invalid Created By.');
        }

        $bankTransferInfo = array_filter($bankTransferInfo ?? []);

        $depositTransaction = $this->depositTransactionRepository->create(
            array_merge([
                'user_id' => $user->getKey(),
                'uuid' => (string) Str::uuid(),
                'amount' => (string) $amount,
                'status' => DepositStatusEnum::PENDING,
                'payment_option_id' => $paymentOption->getKey(),
                'order_id' => $order->getKey(),
                'currency_code' => $currencyCode,
            ],
            array_filter(['bank_transfer_info' => $bankTransferInfo]),
            BaseModel::getMorphProperty('created_by', $createdBy),
            BaseModel::getMorphProperty('updated_by', $createdBy),
            $meta
        ));

        return $depositTransaction;
    }

    public function statisticStatus($status, $data = [])
    {
        return $this->depositTransactionRepository
            ->scopeQuery(function ($q) use ($status) {
                $q->where('status', $status);
            })
            ->count();
    }

    public function getDataDeposit($data)
    {
        $data = data_get($data, 'form');
        $status = data_get($data, 'status', []);

        $query = DB::table('deposit_transactions', 'dt')
            ->join('users as user', 'user.id', '=', 'dt.user_id')
            ->join('payment_options as payment_option', 'payment_option.id', '=', 'dt.payment_option_id');

        $select = ['dt.id', 'dt.uuid', 'user.username','user.status as user_status', 'dt.amount', 'user.currency_code', 'payment_option.name as payment_option_name', 'dt.status', 'dt.created_at', 'dt.updated_at','dt.reference_id'];

        $query = $query->select($select);

        if ($id = data_get($data, 'id', [])) {
            $query->where('dt.id', $id);
        }
        if ($userUsername = data_get($data, 'user_name', [])) {
            if (data_get($data, 'search_exact')) {
                $query->where('user.name', $userUsername);
            } else {
                if (! Str::contains($userUsername, '%')) {
                    $userUsername = "%$userUsername%";
                }
                $query->where('user.name', 'like', $userUsername);
            }
        }

        if ($dataQuery = data_get($data, 'query')) {
            $query->where(function ($queryDataTable) use ($dataQuery) {
                foreach (['dt.id', 'user.name', 'dt.amount', 'user.currency_code', 'dt.uuid'] as $col) {
                    if (! Str::contains($dataQuery, '%')) {
                        $dataQuery = "%$dataQuery%";
                    }
                    $queryDataTable->orWhere($col, 'like', $dataQuery);
                }
            });
        }

        if (!blank($status)) {
            $query->whereIn('dt.status', Arr::wrap($status));
        }

        $createdAtRange = array_filter_empty(data_get($data, 'created_at_range', []));

        if (! blank($createdAtRange)) {
            $query->whereBetween('dt.created_at', Arr::wrap($createdAtRange));
        }

        $updatedAtRange = array_filter_empty(data_get($data, 'updated_at_range', []));

        if (! blank($updatedAtRange)) {
            $query->whereBetween('dt.updated_at', Arr::wrap($updatedAtRange));
        }

        if ($referenceId = data_get($data, 'reference_id')) {
            $query->where('dt.reference_id', $referenceId);
        }

        if ($uuid = data_get($data, 'uuid')) {
            $query->where('dt.uuid', $uuid);
        }

        if ($paymentOption = data_get($data,'payment_option_id')){
            $query->where('dt.payment_option_id',$paymentOption);
        }

        $query->orderBy(data_get($data, 'order_by', 'id'), data_get($data, 'sort_by', 'desc'));

        return $query;
    }

    public function getTotalDepositAmount($data = [])
    {
        $query = $this->getDataDeposit(['form' => $data]);

        $currencies = SystemCurrency::all()->pluck('key');

        $totalByCurrencies = $query
            ->reorder()
            ->select(DB::raw('SUM(dt.amount) as total_amount'), 'dt.currency_code')
            ->groupBy('dt.currency_code')
            ->get()
            ->pluck('total_amount', 'currency_code');

        $total = [];

        foreach ($currencies as $currency) {
            $total[$currency] = (string) Money::make($totalByCurrencies[$currency] ?? 0, $currency);
        }

        return $total;
    }
}
