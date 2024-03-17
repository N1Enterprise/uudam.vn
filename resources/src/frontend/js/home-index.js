$(document).ready(function() {
    function handleHomeVideo() {
        const containerHeight = $('[home_video_wrapper-resize-detection]').height();
        const containerWidth = $('[home_video_wrapper-resize-detection]').width();
        const videoWitdh = $("#home_video_wrapper").width();

        let styleH = `height: ${containerHeight}px;`;
        let styleW = ``;

        if (videoWitdh < containerWidth) {
            styleW = `width: 100%`;
            styleH = 'height: auto;';
        }

        $("#home_video_wrapper").attr('style', `${styleH} ${styleW}`);
    }

    handleHomeVideo();

    $(window).resize(function(){
        handleHomeVideo();
    });
});

// Handle Navigation Section Tab-Content
$(document).ready(function() {
    $('.section-template-wrapper-nav-tabs-item').on('click', function() {
        const sectionRef = $(this).attr('data-featured-video-nav-tab-id');

        $('.section-template-wrapper-nav-tabs-item').removeClass('active');
        $(this).addClass('active');

        $('[data-featured-video-nav-content-ref]').addClass('d-none');
        $(`[data-featured-video-nav-content-ref="${sectionRef}"]`).removeClass('d-none');
    });

    $('.section-template-wrapper-nav-tabs-item').eq(0).trigger('click');
});