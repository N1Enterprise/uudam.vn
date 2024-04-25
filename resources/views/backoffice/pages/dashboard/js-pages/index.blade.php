<script>
$(document).ready(function() {
    const utcOffset = 0;

    const STATISTIC = {
        statisticUser: (params) => {
            const route = $('#report_total_user').attr('data-request-url');

            if (! route) {
                return;
            }

            $.ajax({
                url: route,
                method: 'GET',
                data: params,
                dataType: 'json',
                beforeSend: function() {
                    $("#total_user").html('...');
                },
                success: function(response) {
                    $('#total_user').text(response?.total_count || 0);
                },
                error: function() {
                    toastr.error("{{ __('Something when wrong please try to calculate total new user.') }}");
                }
            });
        },
        statisticOrder: (params) => {
            const route = $('#report_total_order').attr('data-request-url');

            if (! route) {
                return;
            }

            $.ajax({
                url: route,
                method: 'GET',
                data: params,
                dataType: 'json',
                beforeSend: function() {
                    $("#total_order").html('...');
                },
                success: function(response) {
                    $('#total_order').text(response?.total_count || 0);
                },
                error: function() {
                    toastr.error("{{ __('Something when wrong please try to calculate total new order.') }}");
                }
            });
        },
        statisticDeposit: (params) => {
            const route = $('#report_total_deposit').attr('data-request-url');

            if (! route) {
                return;
            }

            $.ajax({
                url: route,
                method: 'GET',
                data: params,
                dataType: 'json',
                beforeSend: function() {
                    $("#deposit_metric").html('...');
                },
                success: function(response) {
                    $('#deposit_metric').text(response?.total_count || 0);
                },
                error: function() {
                    toastr.error("{{ __('Something when wrong please try to calculate total deposit.') }}");
                }
            });
        },
    };

    const DASHBOARD = {
        init: () => {
            const utcOffset = currentUtcOffset.get();

            const startDateDefault = moment().utcOffset(utcOffset).startOf('day').add(utcOffset * -1, 'minutes').format(APP_CONSTANT.DATE_TIME_FORMAT, APP_CONSTANT.DATE_TIME_FORMAT);
            const endDateDefault   = moment().utcOffset(utcOffset).endOf('day').add(utcOffset * -1, 'minutes').format(APP_CONSTANT.DATE_TIME_FORMAT, APP_CONSTANT.DATE_TIME_FORMAT);

            DASHBOARD.setupDateRangeFilter();
            DASHBOARD.loadDataTable();

            DASHBOARD.fetchData();
        },
        fetchData: () => {
            const fromId = 'form_dashboard_filter';
            const formData = $("#" + fromId).serializeArray();
            const params = {};
            const utcOffset = currentUtcOffset.get();

            $.each(formData, function(key, val) {
                let name = val.name;
                if (name.includes('[]')) {
                    name = normalize(name)

                    if (fscommon.isValidDate(val.value, APP_CONSTANT.DATE_TIME_FORMAT)) {
                        val.value = fscommon.convertToClientTime(val.value, utcOffset * -1, APP_CONSTANT.DATE_TIME_FORMAT, APP_CONSTANT.DATE_TIME_FORMAT);
                    }
                    if (!params[name]) {
                        params[name] = []
                    }
                    if (val.value) {
                        params[name].push(val.value)
                    }
                } else {
                    params[name] = val.value;
                }
            });

            STATISTIC.statisticUser(params);
            STATISTIC.statisticOrder(params);
            STATISTIC.statisticDeposit(params);
        },
        loadDataTable: () => {

        },
        setupDateRangeFilter: () => {
            $(".dateRangeFilter").on('apply.daterangepicker', function(ev, picker) {
                const fromId  = 'form_dashboard_filter';
                const labelId = $(this).attr('date-range-label');
                const start   = picker.startDate;
                const end     = picker.endDate;

                $(this).parent().find('input[data-daterangepicker-catch=start]').val(start.format(APP_CONSTANT.DATE_TIME_FORMAT));
                $(this).parent().find('input[data-daterangepicker-catch=end]').val(end.format(APP_CONSTANT.DATE_TIME_FORMAT));

                DASHBOARD.fetchData();
                DASHBOARD.onChangeDateRange(ev, picker);
            });
        },
        onChangeDateRange(e, picker) {
            const start = picker.startDate;
            const end = picker.endDate;
            const id = $(e).attr('id');

            if (picker.chosenLabel == "Custom Range") {
                $('#inputDateRangePicker').val(start.format(APP_CONSTANT.DATE_TIME_FORMAT) + ' to ' + end.format(APP_CONSTANT.DATE_TIME_FORMAT));
            } else {
                $('#inputDateRangePicker').val(picker.chosenLabel);
            }
        }
    };

    DASHBOARD.init();

    fscommon.initDateRangePickers('.daterangepickers', {
        startDate: moment().utcOffset(utcOffset).startOf('day'),
        endDate: moment().utcOffset(utcOffset).endOf('day')
    });
});
</script>
