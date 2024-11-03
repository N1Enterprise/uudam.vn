<div class="row">
    <div class="col-md-3 col-xl-3 order-lg-1 order-xl-1">
        <div class="k-portlet k-portlet--height-fluid statistic text-light bg-secondary p-4 pb-5 pt-5" style="cursor: pointer;" onclick="reloadTable({{ enum('OrderStatusEnum')::WAITING_FOR_PAYMENT }})">
            <div class="d-flex justify-content-between">
                <div>
                    <h4>{{ __('Chờ thanh toán') }}</h4>
                    <small>{{__('Đang chờ thanh toán')}}</small>
                </div>
                <div>
                    <h1 data-order-status="{{ enum('OrderStatusEnum')::WAITING_FOR_PAYMENT }}" data-api="{{ route('bo.api.orders.statistic.order-status', enum('OrderStatusEnum')::WAITING_FOR_PAYMENT) }}"></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-xl-3 order-lg-1 order-xl-1">
        <div class="k-portlet k-portlet--height-fluid statistic text-light bg-warning p-4 pb-5 pt-5" style="cursor: pointer;" onclick="reloadTable({{ enum('OrderStatusEnum')::PAYMENT_ERROR }})">
            <div class="d-flex justify-content-between">
                <div>
                    <h4>{{ __('Thanh toán lỗi') }}</h4>
                    <small>{{__('Thanh toán lỗi tháng này')}}</small>
                </div>
                <div>
                    <h1 data-order-status="{{ enum('OrderStatusEnum')::PAYMENT_ERROR }}" data-api="{{ route('bo.api.orders.statistic.order-status', enum('OrderStatusEnum')::PAYMENT_ERROR) }}"></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-xl-3 order-lg-1 order-xl-1">
        <div class="k-portlet k-portlet--height-fluid statistic text-light bg-primary p-4 pb-5 pt-5" style="cursor: pointer;" onclick="reloadTable({{ enum('OrderStatusEnum')::PROCESSING }})">
            <div class="d-flex justify-content-between">
                <div>
                    <h4>{{ __('Đang chờ xử lí') }}</h4>
                    <small>{{ __('Đang chờ xử lí trong tháng') }}</small>
                </div>
                <div>
                    <h1 data-order-status="{{ enum('OrderStatusEnum')::PROCESSING }}" data-api="{{ route('bo.api.orders.statistic.order-status', enum('OrderStatusEnum')::PROCESSING) }}"></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-xl-3 order-lg-1 order-xl-1">
        <div class="k-portlet k-portlet--height-fluid statistic text-light bg-primary p-4 pb-5 pt-5" style="cursor: pointer;" onclick="reloadTable({{ enum('OrderStatusEnum')::DELIVERY }})">
            <div class="d-flex justify-content-between">
                <div>
                    <h4>{{ __('Đang vận chuyển') }}</h4>
                    <small>{{ __('Chờ giao hàng trong tháng') }}</small>
                </div>
                <div>
                    <h1 data-order-status="{{ enum('OrderStatusEnum')::DELIVERY }}" data-api="{{ route('bo.api.orders.statistic.order-status', enum('OrderStatusEnum')::DELIVERY) }}"></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-xl-3 order-lg-1 order-xl-1">
        <div class="k-portlet k-portlet--height-fluid statistic text-light bg-success p-4 pb-5 pt-5" style="cursor: pointer;" onclick="reloadTable({{ enum('OrderStatusEnum')::COMPLETED }})">
            <div class="d-flex justify-content-between">
                <div>
                    <h4>{{ __('Đã hoàn thành') }}</h4>
                    <small>{{ __('Đã hoàn thành trong tháng') }}</small>
                </div>
                <div>
                    <h1 data-order-status="{{ enum('OrderStatusEnum')::COMPLETED }}" data-api="{{ route('bo.api.orders.statistic.order-status', enum('OrderStatusEnum')::COMPLETED) }}"></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-xl-3 order-lg-1 order-xl-1">
        <div class="k-portlet k-portlet--height-fluid statistic text-light bg-danger p-4 pb-5 pt-5" style="cursor: pointer;" onclick="reloadTable({{ enum('OrderStatusEnum')::CANCELED }})">
            <div class="d-flex justify-content-between">
                <div>
                    <h4>{{ __('Đã hủy') }}</h4>
                    <small>{{ __('Đã hủy trong tháng') }}</small>
                </div>
                <div>
                    <h1 data-order-status="{{ enum('OrderStatusEnum')::CANCELED }}" data-api="{{ route('bo.api.orders.statistic.order-status', enum('OrderStatusEnum')::CANCELED) }}"></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-xl-3 order-lg-1 order-xl-1">
        <div class="k-portlet k-portlet--height-fluid statistic text-light bg-danger p-4 pb-5 pt-5" style="cursor: pointer;" onclick="reloadTable({{ enum('OrderStatusEnum')::REFUNDED }})">
            <div class="d-flex justify-content-between">
                <div>
                    <h4>{{ __('Đã hoàn tiền') }}</h4>
                    <small>{{ __('Đã hoàn tiền trong tháng') }}</small>
                </div>
                <div>
                    <h1 data-order-status="{{ enum('OrderStatusEnum')::REFUNDED }}" data-api="{{ route('bo.api.orders.statistic.order-status', enum('OrderStatusEnum')::REFUNDED) }}"></h1>
                </div>
            </div>
        </div>
    </div>
</div>
