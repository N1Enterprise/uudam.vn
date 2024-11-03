<script>
    let DISPLAY_BANNER_100_PERCENT_ALLOWED_COUNTRY_BADGE = {
        id: null,
        name: null,
        parseFromObject: function(obj) {
            this.id = obj?.id;
            this.name = obj?.name;

            return this;
        },
        render: function() {
            return $(`<button type="button" title="{{ __('Remove') }}" class="Display_Banner_100_Percent_Badge_Selected btn btn-sm btn-outline-brand btn-primary btn-right-icon mr-3 mb-3">`)
                .attr('data-id', this.id)
                .attr('data-name', this.name)
                .append($(`<span class="data-content">`).text(`${this.name} - ${this.id}`))
                .append($('<i class="la la-close">'));
        }
    }

    $(document).ready(function () {
        $('select.Display_Banner_100_Percent_Selector').on('loaded.bs.select', function() {
            $(this).trigger('changed.bs.select');
        });

        $('select.Display_Banner_100_Percent_Selector').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            let $this = $(this);
            let optionHolder = $(`.Display_Banner_100_Percent_Allowed_Holder`);
            let displayBanner_100_PercentList = [];

            optionHolder.find('.Display_Banner_100_Percent_Holder_Content').html('');

            $.each($this.val(), function(i, id) {
                let obj = {
                    id: $this.find(`option[value="${id}"]`).first().val(),
                    name: $this.find(`option[value="${id}"]`).first().attr('data-banner-100-percent-name'),
                }

                displayBanner_100_PercentList.push(obj);
            });

            if ($.isEmptyObject(displayBanner_100_PercentList)) {
                optionHolder.find('.Display_Banner_100_Percent_Holder_Content').html('');
                optionHolder.addClass('d-none');
            } else {
                optionHolder.removeClass('d-none');

                displayBanner_100_PercentList.map(function(obj) {
                    generateDisplayBanner_100_PercentBadge(obj, optionHolder);
                });
            }
        });

        function generateDisplayBanner_100_PercentBadge(obj, holderSelector) {
            if ($.isEmptyObject(obj)) {
                return;
            }

            $(holderSelector).find('.Display_Banner_100_Percent_Holder_Content').append(DISPLAY_BANNER_100_PERCENT_ALLOWED_COUNTRY_BADGE.parseFromObject(obj).render());
        }
    });

    $(document).on('click', '.Display_Banner_100_Percent_Badge_Selected', function() {
        const obj = {
            id: $(this).data('id'),
            name: $(this).data('name'),
        }

        const selector = $(`select.Display_Banner_100_Percent_Selector`);

        selector.find(`option[value="${obj.id}"]`).prop('selected', false);
        selector.trigger('changed.bs.select').selectpicker('render');
    });
</script>
