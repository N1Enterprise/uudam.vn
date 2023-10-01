var fsDateRangePicker = {
    className: '#datetime_range',
    valueClassName: '#search_datetime_range',
    object: null,
    init: function() {
        var self = this;
        self.initDateRangePicker();
    },
    initDateRangePicker: function() {
        var self = this;
        self.object = $(self.className).daterangepicker({
            buttonClasses: 'btn btn-sm',
            applyClass: 'btn-primary',
            cancelClass: 'btn-secondary',
            timePicker: true,
            timePickerIncrement: 30,
            timePicker24Hour: true,
            locale: {
                format: 'YYYY-MM-DD H:mm'
            }
        }, function(start, end, label) {
            $(self.valueClassName).val( start.format('YYYY-MM-DD H:mm') + ' -> ' + end.format('YYYY-MM-DD H:mm'));
        });
    }
};
