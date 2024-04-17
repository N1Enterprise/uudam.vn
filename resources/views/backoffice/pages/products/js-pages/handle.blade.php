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

    var FORM_PRIMARY_IMAGE_PATH = {
        element: $('[name="primary_image[path]"]'),
        onChange: () => {
            FORM_PRIMARY_IMAGE_PATH.element.on('change', function() {
                __IMAGE_MANAGER__.reviewPathOn($(this).val(), 'primary', 0);
            });
        },
        triggerChange: () => {
            $(document).ready(function() {
                FORM_PRIMARY_IMAGE_PATH.element.trigger('change');
            });
        },
        onDelete: () => {},
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
            FORM_PRIMARY_IMAGE_FILE.onChange();
            FORM_PRIMARY_IMAGE_PATH.onChange();
            FORM_MEDIA_IMAGE_FILE.onChange();
            FORM_MEDIA_IMAGE_PATH.onChange();

            FORM_PRIMARY_IMAGE_FILE.onDelete();
            FORM_PRIMARY_IMAGE_PATH.onDelete();
            FORM_MEDIA_IMAGE_FILE.onDelete();
            FORM_MEDIA_IMAGE_PATH.onDelete();
        },
        getFormData: () => {
            const $form = $('#form_store_product');

            const __name = $form.find('[name="name"]').val();
            const __code = $form.find('[name="code"]').val();
            const __slug = $form.find('[name="slug"]').val();
            const __primaryImage = {
                file: $form.find('[name="primary_image[file]"]')[0].files[0] ?? '',
                path: $form.find('[name="primary_image[path]"]').val()
            };
            const __imageMedia = $form.find('[data-repeater-item]').map(function(index, element) {
                return {
                    file:  $(element).find(`[name="media[image][${index}][file]"]`)[0].files[0] ?? '',
                    path: $(element).find(`[name="media[image][${index}][path]"]`).val(),
                };
            });
            const __videoMedia = $form.find('.video-media-item').map(function(index, element) {
                return {
                    order: $(element).find(`[name="media[video][${index}][order]"]`).val(),
                    path:  $(element).find(`[name="media[video][${index}][path]"]`).val()
                };
            });
            const __description = $form.find('[name="description"]').val();
            const __suggestedRelationships = {
                inventories: $form.find('[name="suggested_relationships[inventories][]"]').val(),
                posts: $form.find('[name="suggested_relationships[posts][]"]').val(),
            };
            const __categories = $form.find('[name="categories[]"]').val();
            const __type = $form.find('[name="type"]').val();
            const __branch = $form.find('[name="branch"]').val();
            const __status = $form.find('[name="status"]').val();

            const formData = new FormData();

            formData.append('name', __name);
            formData.append('code', __code);
            formData.append('slug', __slug);
            formData.append('primary_image[file]', __primaryImage.file);
            formData.append('primary_image[path]', __primaryImage.path);

            $.each(__imageMedia, function(index, item) {
                formData.append(`media[image][${index}][file]`, item.file);
                formData.append(`media[image][${index}][path]`, item.path);
            });

            $.each(__videoMedia, function(index, item) {
                formData.append(`media[video][${index}][order]`, item.order);
                formData.append(`media[video][${index}][path]`, item.path);
            });

            formData.append('description', __description);

            $.each(__suggestedRelationships.inventories, function(index, item) {
                formData.append(`suggested_relationships[inventories][${index}]`, item);
            });

            $.each(__suggestedRelationships.posts, function(index, item) {
                formData.append(`suggested_relationships[posts][${index}]`, item);
            });

            $.each(__categories, function(index, item) {
                formData.append(`categories[${index}]`, item);
            });

            formData.append('type', __type);
            formData.append('branch', __branch);
            formData.append('status', __status);

            for (var p of formData) {
                let name = p[0];
                let value = p[1];
            }

            return formData;
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
                if (confirm('Bạn có chắc chắn muốn xóa phần tử này ?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            ready: function(setIndexes) {
            },
        });

        FORM_MASTER.init();
        FORM_PRIMARY_IMAGE_PATH.triggerChange();
        FORM_MEDIA_IMAGE_PATH.triggerChange();
    });
</script>
