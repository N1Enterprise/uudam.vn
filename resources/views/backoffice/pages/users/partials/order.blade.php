<div class="k-portlet">
    <div class="k-portlet__head">
        <div class="k-portlet__head-label">
            <h3 class="k-portlet__head-title">{{ __('Danh sách đơn hàng') }}</h3>
        </div>
    </div>

    <div class="k-portlet__body">
        <div class="k-section">
            <form data-datatable="table_orders_index" class="k-form k-form--label-right" id="search_table_orders_index" method="GET">
                <div class="row">
                    <div class="col-md-8 form-group">
                        <div class="input-group">
                            <input
                                data-original-title="{{ __('Ngày đặt hàng') }}"
                                data-toggle="tooltip"
                                start="{{ now()->startOfMonth()->toDateTimeString() }}"
                                end="{{ now()->endOfMonth()->toDateTimeString() }}"
                                type="daterangepicker"
                                id="search_table_orders_index_daterangepicker"
                                class="form-control"
                                value=""
                                readonly
                                placeholder="{{ __('Chọn ngày đặt hàng') }}"
                            >
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="la la-calendar-check-o"></i>
                                </span>
                            </div>
                            <input type="hidden" data-daterangepicker-catch="start" name="created_at_range[]" value="{{ now()->startOfMonth()->toDateTimeString() }}">
                            <input type="hidden" data-daterangepicker-catch="end" name="created_at_range[]" value="{{ now()->endOfMonth()->toDateTimeString() }}">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!--begin::Section-->
        <div class="k-section">
            <div class="k-section__content">
                <table id="table_orders_index" data-defer-loading="true" data-server-side="true" data-searching="true" data-request-url="{{ route('bo.api.orders.index', ['user_id' => $user->id]) }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                    <thead>
                        <tr>
                            <th data-property="id">{{ __('ID') }}</th>
                            <th data-property="order_code">{{ __('Mã đơn hàng') }}</th>
                            <th data-property="fullname">{{ __('Họ và tên') }}</th>
                            <th data-property="email">{{ __('E-mail') }}</th>
                            <th data-property="phone">{{ __('Số điện thoại') }}</th>
                            <th data-property="total_item">{{ __('Tổng sản phẩm') }}</th>
                            <th data-property="total_quantity">{{ __('Tổng số lượng') }}</th>
                            <th data-orderable="false" data-badge data-name="payment_status" data-property="payment_status_name">{{ __('Trạng thái thanh toán') }}</th>
                            <th data-orderable="false" data-badge data-name="order_status" data-property="order_status_name">{{ __('Trạng thái đơn hàng') }}</th>
                            <th data-orderable="false" data-property="created_by.name">{{ __('Người tạo') }}</th>
                            <th data-orderable="false" data-property="updated_by.name">{{ __('Người cập nhật') }}</th>
                            <th data-property="created_at">{{ __('Ngày tạo') }}</th>
                            <th data-property="updated_at">{{ __('Ngày cập nhật') }}</th>
                            <th class="datatable-action" data-property="actions">{{ __('Hành động') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@push('js_pages')
<script>
    initOrderDateRange();

    function initOrderDateRange() {
        $(document).ready(function() {
            $('#search_table_orders_index_daterangepicker').on('apply.daterangepicker cancel.daterangepicker', function(ev, picker) {
                setTimeout(function() {
                    $('#search_table_orders_index').submit();
                }, 100)
            });
        });
    }
</script>
@endpush
