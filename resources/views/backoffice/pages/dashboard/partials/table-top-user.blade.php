<div class="col-md-12">
    <div class="k-portlet k-portlet--height-fluid">
        <div class="k-portlet__head ">
            <div class="k-portlet__head-label">
                <h3 class="k-portlet__head-title">{{ __('Khách hàng nổi bật') }}</h3>
            </div>
        </div>
        <div class="k-portlet__body">
            <table id="table_top_users" data-form-id="form_dashboard_filter" data-server-side="false" data-default-order="asc" data-page-length="20" data-searching="false"  data-request-url="{{ route('bo.api.dashboard.top-users') }}" date-range-id="dateRangePickerHeader" class="datatable table table-striped table-bordered table-hover table-checkable fs-table-object">
                <thead>
                    <tr>
                        <th data-type="num" data-property="rank">#</th>
                        <th data-property="id">{{ __('ID') }}</th>
                        <th data-property="username">{{ __('Tên tài khoản') }}</th>
                        <th data-property="name">{{ __('Tên hiển thị') }}</th>
                        <th data-property="email">{{ __('E mail') }}</th>
                        <th data-property="phone_number">{{ __('SĐT') }}</th>
                        <th data-property="total_turnover">{{ __('Doanh số') }}</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
