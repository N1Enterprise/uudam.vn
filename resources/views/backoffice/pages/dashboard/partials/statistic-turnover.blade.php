<div class="col-md-4 col-xl-4 order-lg-1 order-xl-1">
    <div class="k-portlet k-portlet--height-fluid">
        <div class="k-portlet__head k-portlet__head--noborder">
            <div class="k-portlet__head-label">
                <h3 class="k-portlet__head-title">{{ __('Doanh số') }}</h3>
            </div>
            <form method="GET" data-request-url="{{ route('bo.api.dashboard.total-turnover') }}" id="report_total_deposit"></form>
        </div>
        <div class="k-portlet__body k-portlet__body--fluid">
            <div class="k-widget-19">
                <div class="k-widget-19__title">
                    <div id="deposit_metric" class="k-widget-19__label">{{ format_price(0) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
