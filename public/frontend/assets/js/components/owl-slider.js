function getResponsive(numberOfShow) {
    const responsive = {
        1: {
            0:    { items: 1 },
            600:  { items: 1 },
            1000: { items: 1 },
        },
        3: {
            0:    { items: 2 },
            600:  { items: 2 },
            1000: { items: 3 },
        },
        5: {
            0:  { items: 2 },
            600:  { items: 2 },
            1024: { items: 5 },
        },
    };

    return responsive[numberOfShow];
}

function owlSliderSetup() {
    $.each($('[data-owl-id]'), function(index, element) {
        const owlId = $(element).attr('data-owl-id');
        const items = $(element).attr('data-owl-items');
        const hasLoop = $(element).attr('data-owl-loop') == 'true';
        const dotsContainer = $(element).attr('data-owl-dots-container');

        $(element).addClass('owl-carousel owl-theme');

        const config = {
            loop: hasLoop,
            nav: false,
            responsive: getResponsive(items),
            dotsContainer: dotsContainer,
        };

        !dotsContainer && delete config.dotsContainer;

        $(element).owlCarousel({
            ...config
        });

        $(`[data-owl-prev=${owlId}]`).on('click', function() {
            $(element).find('.owl-nav .owl-prev').trigger('click');
        });

        $(`[data-owl-next=${owlId}]`).on('click', function() {
            $(element).find('.owl-nav .owl-next').trigger('click');
        });
    });
}

owlSliderSetup();
