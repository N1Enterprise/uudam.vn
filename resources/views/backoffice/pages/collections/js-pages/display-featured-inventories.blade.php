<script>
    let DISPLAY_FEATURED_INVENTORY_ALLOWED_COUNTRY_BADGE = {
        id: null,
        name: null,
        parseFromObject: function(obj) {
            this.id = obj?.id;
            this.name = obj?.name;

            return this;
        },
        render: function() {
            return $(`<button type="button" title="{{ __('Remove') }}" class="Display_Featured_Inventory_Badge_Selected btn btn-sm btn-outline-brand btn-primary btn-right-icon mr-3 mb-3">`)
                .attr('data-id', this.id)
                .attr('data-name', this.name)
                .append($(`<span class="data-content">`).text(`${this.name} - ${this.id}`))
                .append($('<i class="la la-close">'));
        }
    }

    $(document).ready(function () {
        $('select.Display_Featured_Inventory_Selector').on('loaded.bs.select', function() {
            $(this).trigger('changed.bs.select');
        });

        $('select.Display_Featured_Inventory_Selector').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            let $this = $(this);
            let optionHolder = $(`.Display_Featured_Inventory_Allowed_Holder`);
            let displayInventoryList = [];

            optionHolder.find('.Display_Featured_Inventory_Holder_Content').html('');

            $.each($this.val(), function(i, id) {
                let obj = {
                    id: $this.find(`option[value="${id}"]`).first().val(),
                    name: $this.find(`option[value="${id}"]`).first().attr('data-featured-inventory-name'),
                }

                displayInventoryList.push(obj);
            });

            if ($.isEmptyObject(displayInventoryList)) {
                optionHolder.find('.Display_Featured_Inventory_Holder_Content').html('');
                optionHolder.addClass('d-none');
            } else {
                optionHolder.removeClass('d-none');

                displayInventoryList.map(function(obj) {
                    generateDisplayFeaturedInventoryBadge(obj, optionHolder);
                });
            }
        });

        function generateDisplayFeaturedInventoryBadge(obj, holderSelector) {
            if ($.isEmptyObject(obj)) {
                return;
            }

            $(holderSelector).find('.Display_Featured_Inventory_Holder_Content').append(DISPLAY_FEATURED_INVENTORY_ALLOWED_COUNTRY_BADGE.parseFromObject(obj).render());
        }
    });

    $(document).on('click', '.Display_Featured_Inventory_Badge_Selected', function() {
        const obj = {
            id: $(this).data('id'),
            name: $(this).data('name'),
        }

        const selector = $(`select.Display_Featured_Inventory_Selector`);

        selector.find(`option[value="${obj.id}"]`).prop('selected', false);
        selector.trigger('changed.bs.select').selectpicker('render');
    });
</script>
