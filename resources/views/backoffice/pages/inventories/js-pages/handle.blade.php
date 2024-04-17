<script>
    var FORM_MEDIA_IMAGE_FILE = {
        element_list: $('.variant_image_file'),
        elemen_del_list: $('[data-image-ref-delete="variant"]'),
        onChange: () => {
            $.each(FORM_MEDIA_IMAGE_FILE.element_list, function(index, element) {
                $(element).on('change', function() {
                    __IMAGE_MANAGER__.reviewFileOn($(this)[0].files[0], 'variant', index);
                });
            });
        },
        onDelete: () => {
            $.each(FORM_MEDIA_IMAGE_FILE.elemen_del_list, function(index, element) {
                $(element).on('click', function() {
                    __IMAGE_MANAGER__.deleteRef('variant', index);
                });
            });
        },
    };

    var FORM_MEDIA_IMAGE_PATH = {
        element_list: $('.variant_image_path'),
        onChange: () => {
            $.each(FORM_MEDIA_IMAGE_PATH.element_list, function(index, element) {
                $(element).on('change', function() {
                    __IMAGE_MANAGER__.reviewPathOn($(this).val(), 'variant', index);
                });
            });
        },
        triggerChange: () => {
            $(document).ready(function() {
                $.each(FORM_MEDIA_IMAGE_PATH.element_list, function(index, element) {
                    $(element).trigger('change');
                });
            });
        },
        onDelete: () => {},
    };

    var FORM_MASTER = {
        init: () => {
            FORM_MASTER.onChange();
        },
        onChange: () => {
            FORM_MEDIA_IMAGE_FILE.onChange();
            FORM_MEDIA_IMAGE_PATH.onChange();
            FORM_MEDIA_IMAGE_FILE.onDelete();
            FORM_MEDIA_IMAGE_PATH.onDelete();
        },
    };

    $(document).ready(function() {
        $('.variants_repeater').repeater({
            initEmpty: false,
            show: function() {
                $(this).slideDown();

                $.each($('[data-repeater-item]'), function(index, repeater) {
                    const $repeater = $(repeater);

                    const for_ref_id = `variant_image_file_${index}`;

                    $repeater.attr('data-repeater-index', index);

                    $repeater.find('.variant_image_file_wapper').attr('for', for_ref_id);
                    $repeater.find('.variant_image_file').attr('id', for_ref_id);
                    $repeater.find('[data-image-ref-index]').attr('data-image-ref-index', index);
                });

                FORM_MEDIA_IMAGE_FILE.element_list    = $('[data-repeater-item] .variant_image_file');
                FORM_MEDIA_IMAGE_PATH.element_list    = $('[data-repeater-item] .variant_image_path');
                FORM_MEDIA_IMAGE_FILE.elemen_del_list = $('[data-repeater-item] [data-image-ref-delete]');

                FORM_MEDIA_IMAGE_FILE.onChange();
                FORM_MEDIA_IMAGE_PATH.onChange();
                FORM_MEDIA_IMAGE_FILE.onDelete();
            },
            hide: function(deleteElement) {
                if (confirm('Bạn có chắc chắn muốn xóa phần tử này ?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            ready: function(setIndexes) {
            },
        });

        $('.key_features_repeater').repeater({
            initEmpty: false,
            show: function() {
                $(this).slideDown();
            },
            hide: function(deleteElement) {
                if (confirm('Bạn có chắc chắn muốn xóa phần tử này ?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            ready: function(setIndexes) {
            },
        });

        $('.product_combo_repeater').repeater({
            initEmpty: false,
            show: function() {
                $(this).slideDown();
                $(this).find('select.Product_Combo_Selector').selectpicker('refresh');
            },
            hide: function(deleteElement) {
                if (confirm('Bạn có chắc chắn muốn xóa phần tử này ?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            ready: function(setIndexes) {
            },
        });

        FORM_MASTER.init();
    });

    $(document).ready(function() {
        $('[data-repeater-delete-custom]').on('click', function() {
            if (confirm("{{ __('Xác nhận xóa biến thể này ?') }}")) {
                $(this).parents('[data-repeater-item-custom]').remove();
            }
        });

        $('.variant_offer_price [data-type="inputmask_numeric"]').on('change', function() {
            let hasOfferPrice = false;

            $.each($('.variant_offer_price [data-type="inputmask_numeric"]'), function(index, element) {
                const price = $(element).val();

                if (!!price) {
                    hasOfferPrice = true;
                    return;
                }
            });

            if (! hasOfferPrice) {
                $('[name="offer_start"]').val('');
                $('[name="offer_end"]').val('');
            }

            $('[data-toggle-reference="offer_date_setup"]').toggleClass('d-none', !hasOfferPrice);
            $('[data-toggle-reference="offer_date_setup"] input').toggleClass('d-none', !hasOfferPrice);
            $('[data-toggle-reference="offer_date_setup"] input').prop('disabled', !hasOfferPrice);
        });

        $('[copy-inventory-selection]').each(function(_, element) {
            $(element).on('change', function() {
                const index = $(this).parents('[data-repeater-index]').attr('data-repeater-index');
                const targetIndex = $(this).val();

                const targetValues = {
                    title: $(`[name="variants[title][${targetIndex}]"]`).val(),
                    weight: $(`[name="variants[weight][${targetIndex}]"]`).val(),
                    sku: $(`[name="variants[sku][${targetIndex}]"]`).val(),
                    condition: $(`[name="variants[condition][${targetIndex}]"]`).val(),
                    stock_quantity: $(`[name="variants[stock_quantity][${targetIndex}]"]`).val(),
                    purchase_price: $(`[name="variants[purchase_price][${targetIndex}]"]`).val(),
                    sale_price: $(`[name="variants[sale_price][${targetIndex}]"]`).val(),
                    offer_price: $(`[name="variants[offer_price][${targetIndex}]"]`).val()
                };

                $(`[name="variants[title][${index}]"]`).val(targetValues.title);
                $(`[name="variants[weight][${index}]"]`).val(targetValues.weight);
                $(`[name="variants[sku][${index}]"]`).val(targetValues.sku);
                $(`[name="variants[condition][${index}]"]`).val(targetValues.condition);

                $(`[name="variants[stock_quantity][${index}]"]`).val(targetValues.stock_quantity);
                $(`[name="variants[purchase_price][${index}]"]`).val(targetValues.purchase_price);
                $(`[name="variants[sale_price][${index}]"]`).val(targetValues.sale_price);
                $(`[name="variants[offer_price][${index}]"]`).val(targetValues.offer_price);

                $(`[data-key="variants[weight][${index}]"]`).val(targetValues.weight);
                $(`[data-key="variants[stock_quantity][${index}]"]`).val(targetValues.stock_quantity);
                $(`[data-key="variants[purchase_price][${index}]"]`).val(targetValues.purchase_price);
                $(`[data-key="variants[sale_price][${index}]"]`).val(targetValues.sale_price);
                $(`[data-key="variants[offer_price][${index}]"]`).val(targetValues.offer_price);
            });
        });
    });
</script>
