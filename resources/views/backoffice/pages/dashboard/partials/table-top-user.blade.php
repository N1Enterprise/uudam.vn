<div class="col-md-6">
    <div class="k-portlet k-portlet--height-fluid">
        <div class="k-portlet__head ">
            <div class="k-portlet__head-label">
                <h3 class="k-portlet__head-title">{{ __('Top User') }}</h3>
            </div>
        </div>
        <div class="k-portlet__body" id="top_game_play_metric">
            <table data-form-id="form_dashboard_filter" data-server-side="false" data-default-order="asc" data-page-length="20" data-searching="false"  data-request-url="" date-range-id="dateRangePickerHeader" class="datatable table table-striped table-bordered table-hover table-checkable fs-table-object"  id="top_game_list">
                <thead>
                    <tr>
                        <th data-type="num" data-property="rank">#</th>
                        <th data-property="name">{{ __('Game') }}</th>
                        <th data-property="game_provider.name">{{ __('Game Provider') }}</th>
                        <th data-type="num" data-render-callback="renderTurnoverFormatMoney" data-sort="total_turnover" data-property="total_turnover">{{ __('Turnover') }}</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
