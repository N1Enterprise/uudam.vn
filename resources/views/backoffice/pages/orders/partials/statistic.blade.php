<div class="row">
    <div class="col-md-3 col-xl-3 order-lg-1 order-xl-1">
        <div class="k-portlet k-portlet--height-fluid statistic text-light bg-secondary p-4 pb-5 pt-5" style="cursor: pointer;" onclick="reloadTable({{ enum('OrderStatusEnum')::WAITING_FOR_PAYMENT }})">
            <div class="d-flex justify-content-between">
                <div>
                    <h4>{{ __('Waiting Payment') }}</h4>
                    <small>{{__('Waiting for Payment')}}</small>
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
                    <h4>{{ __('Payment Error') }}</h4>
                    <small>{{__('Payment Error This Month')}}</small>
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
                    <h4>{{ __('Processing') }}</h4>
                    <small>{{ __('Processing Order') }}</small>
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
                    <h4>{{ __('Delivery') }}</h4>
                    <small>{{ __('Pending Delivery') }}</small>
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
                    <h4>{{ __('Completed') }}</h4>
                    <small>{{ __('Order Completed') }}</small>
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
                    <h4>{{ __('Canceled') }}</h4>
                    <small>{{ __('Order Canceled') }}</small>
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
                    <h4>{{ __('Refunded') }}</h4>
                    <small>{{ __('Order Refunded') }}</small>
                </div>
                <div>
                    <h1 data-order-status="{{ enum('OrderStatusEnum')::REFUNDED }}" data-api="{{ route('bo.api.orders.statistic.order-status', enum('OrderStatusEnum')::REFUNDED) }}"></h1>
                </div>
            </div>
        </div>
    </div>
</div>
