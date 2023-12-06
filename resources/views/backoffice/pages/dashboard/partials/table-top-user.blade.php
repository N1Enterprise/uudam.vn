<div class="col-md-6">
    <div class="k-portlet k-portlet--height-fluid">
        <div class="k-portlet__head ">
            <div class="k-portlet__head-label">
                <h3 class="k-portlet__head-title">{{ __('Top Users') }}</h3>
            </div>
        </div>
        <div class="k-portlet__body">
            <table id="table_top_users" data-form-id="form_dashboard_filter" data-server-side="false" data-default-order="asc" data-page-length="20" data-searching="false"  data-request-url="{{ route('bo.api.dashboard.top-users') }}" date-range-id="dateRangePickerHeader" class="datatable table table-striped table-bordered table-hover table-checkable fs-table-object">
                <thead>
                    <tr>
                        <th data-type="num" data-property="rank">#</th>
                        <th data-property="id">{{ __('id') }}</th>
                        <th data-property="username">{{ __('Username') }}</th>
                        <th data-property="name">{{ __('Name') }}</th>
                        <th data-property="email">{{ __('E-mail') }}</th>
                        <th data-property="phone_number">{{ __('Phone') }}</th>
                        <th data-property="total_turnover">{{ __('Turnover') }}</th>
                        <th class="datatable-action" data-property="actions">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
