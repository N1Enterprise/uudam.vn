<div class="col-md-6">
    <div class="k-portlet k-portlet--height-fluid">
        <div class="k-portlet__head ">
            <div class="k-portlet__head-label">
                <h3 class="k-portlet__head-title">{{ __('Top Orders') }}</h3>
            </div>
        </div>
        <div class="k-portlet__body">
            <table id="table_top_orders" data-form-id="form_dashboard_filter" data-server-side="false" data-default-order="asc" data-page-length="20" data-searching="false"  data-request-url="{{ route('bo.api.dashboard.top-orders') }}" date-range-id="dateRangePickerHeader" class="datatable table table-striped table-bordered table-hover table-checkable fs-table-object">
                <thead>
                    <tr>
                        <th data-type="num" data-property="rank">#</th>
                        <th data-property="id">{{ __('id') }}</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
