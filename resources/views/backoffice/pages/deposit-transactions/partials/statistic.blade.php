<div class="row">
    <div class="col-md-3 col-xl-3 order-lg-1 order-xl-1">
        <div onclick="reloadTable({{ enum('DepositStatusEnum')::PENDING }})" class="k-portlet k-portlet--height-fluid statistic text-light bg-primary p-4 pb-5" style="cursor: pointer;">
            <div class="d-flex justify-content-between">
                <div>
                    <h4>{{ __('Đang xử lý') }}</h4>
                    <small>{{__('Đang chờ xử lí')}}</small>
                </div>
                <div>
                    <h1 data-status="{{ enum('DepositStatusEnum')::PENDING }}" data-api="{{ route('bo.api.deposit-transactions.statistic.status', enum('DepositStatusEnum')::PENDING) }}">10</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-xl-3 order-lg-1 order-xl-1">
        <div onclick="reloadTable({{ enum('DepositStatusEnum')::CANCELED }})" class="k-portlet k-portlet--height-fluid statistic bg-warning p-4 pb-5" style="cursor: pointer;">
            <div class="d-flex justify-content-between">
                <div>
                    <h4>{{ __('Đã hủy') }}</h4>
                    <small>{{__('Yêu cầu đã bị huỷ')}}</small>
                </div>
                <div>
                    <h1 data-status="{{ enum('DepositStatusEnum')::CANCELED }}" data-api="{{ route('bo.api.deposit-transactions.statistic.status', enum('DepositStatusEnum')::CANCELED) }}">10</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-xl-3 order-lg-1 order-xl-1">
        <div onclick="reloadTable({{ enum('DepositStatusEnum')::APPROVED }})" class="k-portlet k-portlet--height-fluid text-light statistic bg-success p-4 pb-5" style="cursor: pointer;">
            <div class="d-flex justify-content-between">
                <div>
                    <h4>{{ __('Đã hoàn thành') }}</h4>
                    <small>{{__('Yêu cầu đã được chấp nhận')}}</small>
                </div>
                <div>
                    <h1 data-status="{{ enum('DepositStatusEnum')::APPROVED }}" data-api="{{ route('bo.api.deposit-transactions.statistic.status', enum('DepositStatusEnum')::APPROVED) }}">10</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-xl-3 order-lg-1 order-xl-1">
        <div onclick="reloadTable({{ enum('DepositStatusEnum')::DECLINED }})" class="k-portlet k-portlet--height-fluid text-light statistic bg-danger p-4 pb-5" style="cursor: pointer;">
            <div class="d-flex justify-content-between">
                <div>
                    <h4>{{ __('Bị từ chối') }}</h4>
                    <small>{{__('Yêu cầu bị từ chối')}}</small>
                </div>
                <div>
                    <h1 data-status="{{ enum('DepositStatusEnum')::DECLINED }}" data-api="{{ route('bo.api.deposit-transactions.statistic.status', enum('DepositStatusEnum')::DECLINED) }}">10</h1>
                </div>
            </div>
        </div>
    </div>
</div>
