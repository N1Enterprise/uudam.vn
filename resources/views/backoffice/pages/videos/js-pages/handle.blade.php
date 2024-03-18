<script>
    var FORM_THUMBNAIL_FILE = {
        element: $('[name="thumbnail[file]"]'),
        elemen_del: $('[data-image-ref-delete="thumbnail"]'),

        onChange: () => {
            FORM_THUMBNAIL_FILE.element.on('change', async function() {
                __IMAGE_MANAGER__.reviewFileOn($(this)[0].files[0], 'thumbnail', 0);
            });
        },
        onDelete: () => {
            FORM_THUMBNAIL_FILE.elemen_del.on('click', function() {
                __IMAGE_MANAGER__.deleteRef('thumbnail', 0);
            });
        },
    };

    var FORM_THUMBNAIL_PATH = {
        element: $('[name="thumbnail[path]"]'),
        onChange: () => {
            FORM_THUMBNAIL_PATH.element.on('change', function() {
                __IMAGE_MANAGER__.reviewPathOn($(this).val(), 'thumbnail', 0);
            });
        },
        triggerChange: () => {
            $(document).ready(function() {
                FORM_THUMBNAIL_PATH.element.trigger('change');
            });
        },
        onDelete: () => {},
    };

    var FORM_MASTER = {
        init: () => {
            FORM_MASTER.onChange();
        },
        onChange: () => {
            FORM_THUMBNAIL_FILE.onChange();
            FORM_THUMBNAIL_PATH.onChange();

            FORM_THUMBNAIL_FILE.onDelete();
            FORM_THUMBNAIL_PATH.onDelete();
        },
    };

    const FORM_VIDEO_SOURCE = {
        init: () => {
            FORM_VIDEO_SOURCE.onChange();
        },
        onChange: () => {
            $('[name="source_url"]').on('change', function() {
                const sourceURL = $(this).val();
                const videoContainer = $('#video_source_container');

                videoContainer.empty();

                const externalRegex = /^(?:(?:https?|ftp):\/\/)?(?:\S+(?::\S*)?@)?(?:www\.)?(?:(?:(?!-)[A-Za-z0-9-]{1,63}(?<!-)\.)+(?:[A-Za-z]{2,6}\.?|[A-Za-z0-9-]{2,}\.?))(?::\d+)?(?:\/[\w#!:.?+=&%@!\-\/]*)?$/;

                if (! sourceURL) {
                    fstoast.warning('Video Source is empty!');
                    return;
                }

                if (! externalRegex.test(sourceURL)) {
                    fstoast.warning('Invalid video source!');
                    return;
                }

                const video = $('<video controls style="max-width: 100%"></video>');

                const source = $('<source>').attr({
                    src: sourceURL,
                    type: 'video/mp4'
                });

                video.append(source);
                videoContainer.append(video);
            });
        },
        triggerChange: () => {
            $('[name="source_url"]').trigger('change');
        },
    };

    $(document).ready(function() {
        FORM_MASTER.init();
        FORM_THUMBNAIL_PATH.triggerChange();

        FORM_VIDEO_SOURCE.init();
        FORM_VIDEO_SOURCE.triggerChange();
    });
</script>
