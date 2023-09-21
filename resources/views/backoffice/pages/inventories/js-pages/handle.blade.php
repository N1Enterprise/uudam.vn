<script>
    var __IMAGE_MANAGER__ = {
        toUrl: async (file) => {
            return file ? await __IMAGE_MANAGER__.toBase64(file) : '';
        },
        toBase64: (file) => {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = () => resolve(reader.result);
                reader.onerror = reject;
            });
        },
        reviewImage: (src, ref, index) => {
            $(`[data-image-ref-review-wapper="${ref}"][data-image-ref-index="${index}"]`).toggleClass('d-none', !src);
            $(`[data-image-ref-review-img="${ref}"][data-image-ref-index="${index}"]`).attr('src', src ? src : '');
        },
        reviewFileOn: async (file, ref, index) => {
            const imageUrl = await __IMAGE_MANAGER__.toUrl(file);

            $(`[data-image-ref-wapper="${ref}"][data-image-ref-index="${index}"]`).toggleClass('d-none', !imageUrl);
            $(`[data-image-ref-img="${ref}"][data-image-ref-index="${index}"]`).attr('src', imageUrl ? imageUrl : '');
            $(`[data-image-ref-path="${ref}"][data-image-ref-index="${index}"]`).val('');

            __IMAGE_MANAGER__.reviewImage(imageUrl, ref, index);
        },
        reviewPathOn: (path, ref, index) => {
            __IMAGE_MANAGER__.reviewImage(path, ref, index);
            $(`[data-image-ref-file="${ref}"][data-image-ref-index="${index}"]`).val('');
        },

        deleteRef: (ref, index) => {
            __IMAGE_MANAGER__.reviewFileOn(null, ref, index);
        },
    };

    var FORM_DESCRIPTION = {
        element: $('#form_inventory').find('[name="description"]'),
        setup: () => {
            FORM_DESCRIPTION.onChange();
            FORM_DESCRIPTION.pluginBuilderSetup();
        },
        onChange: () => {
            PLUGIN_BUILDER.build('block_editor', 'editorjs');
        },

        pluginBuilderSetup: () => {
            const content = JSON.parse(FORM_DESCRIPTION.element.val() || '{}');

            PLUGIN_BUILDER.setValue(content);
        },
    };

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
            FORM_DESCRIPTION.setup();
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
                if (confirm('Are you sure you want to delete this element?')) {
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
                if (confirm('Are you sure you want to delete this element?')) {
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
            if (confirm("{{ __('Confirm delete this variant?') }}")) {
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
        });
    });
</script>
