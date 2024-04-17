<script>
    var FORM_PRIMARY_IMAGE_FILE = {
        element: $('[name="primary_image[file]"]'),
        elemen_del: $('[data-image-ref-delete="primary"]'),

        onChange: () => {
            FORM_PRIMARY_IMAGE_FILE.element.on('change', async function() {
                __IMAGE_MANAGER__.reviewFileOn($(this)[0].files[0], 'primary', 0);
            });
        },
        onDelete: () => {
            FORM_PRIMARY_IMAGE_FILE.elemen_del.on('click', function() {
                __IMAGE_MANAGER__.deleteRef('primary', 0);
            });
        },
    };

    var FORM_MEDIA_IMAGE_FILE = {
        element_list: $('.media_image_file'),
        elemen_del_list: $('[data-image-ref-delete="media"]'),
        onChange: () => {
            $.each(FORM_MEDIA_IMAGE_FILE.element_list, function(index, element) {
                $(element).on('change', function() {
                    __IMAGE_MANAGER__.reviewFileOn($(this)[0].files[0], 'media', index);
                });
            });
        },
        onDelete: () => {
            $.each(FORM_MEDIA_IMAGE_FILE.elemen_del_list, function(index, element) {
                $(element).on('click', function() {
                    __IMAGE_MANAGER__.deleteRef('media', index);
                });
            });
        },
    };

    var FORM_MEDIA_IMAGE_PATH = {
        element_list: $('.media_image_path'),
        onChange: () => {
            $.each(FORM_MEDIA_IMAGE_PATH.element_list, function(index, element) {
                $(element).on('change', function() {
                    __IMAGE_MANAGER__.reviewPathOn($(this).val(), 'media', index);
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
        $('.media_image_repeater').repeater({
            initEmpty: false,
            show: function() {
                $(this).slideDown();

                $.each($('[data-repeater-item]'), function(index, repeater) {
                    const $repeater = $(repeater);

                    const for_ref_id = `media_image_file_${index}`;

                    $repeater.attr('data-repeater-index', index);

                    $repeater.find('.media_image_file_wapper').attr('for', for_ref_id);
                    $repeater.find('.media_image_file').attr('id', for_ref_id);
                    $repeater.find('[data-image-ref-index]').attr('data-image-ref-index', index);
                });

                FORM_MEDIA_IMAGE_FILE.element_list    = $('[data-repeater-item] .media_image_file');
                FORM_MEDIA_IMAGE_PATH.element_list    = $('[data-repeater-item] .media_image_path');
                FORM_MEDIA_IMAGE_FILE.elemen_del_list = $('[data-repeater-item] [data-image-ref-delete]');

                FORM_MEDIA_IMAGE_FILE.onChange();
                FORM_MEDIA_IMAGE_PATH.onChange();
                FORM_MEDIA_IMAGE_FILE.onDelete();
            },
            hide: function(deleteElement) {
                if (confirm('Bạn có chắc chắn muốn xóa phần tử này?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            ready: function(setIndexes) {
            },
        });

        FORM_MASTER.init();
        FORM_MEDIA_IMAGE_PATH.triggerChange();
    });
</script>
