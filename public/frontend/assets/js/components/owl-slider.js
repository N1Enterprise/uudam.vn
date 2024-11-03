function getResponsive(numberOfShow) {
    const responsive = {
        1: {
            0:    { items: 1 },
            600:  { items: 1 },
            1000: { items: 1 },
        },
        2: {
            0:    { items: 1 },
            600:  { items: 2 },
            1000: { items: 2 },
        },
        3: {
            0:    { items: 2 },
            600:  { items: 3 },
            900:  { items: 3 },
            1000: { items: 3 },
        },
        4: {
            0:    { items: 2 },
            600:  { items: 3 },
            900:  { items: 3 },
            1000: { items: 4 },
        },
        5: {
            0:    { items: 2 },
            600:  { items: 3 },
            900:  { items: 3 },
            1024: { items: 5 },
        },
    };

    return responsive[numberOfShow];
}

function owlBuildButton(owlId) {
    return `
        <div data-owl-controls data-owl-prev="${owlId}">
            <span class="owl-icon">&#x2039;</span>
        </div>
        <div data-owl-controls data-owl-next="${owlId}">
            <span class="owl-icon">&#x203a;</span>
        </div>
    `;
}

function owlSliderSetup() {
    $.each($('[data-owl-id]'), function(index, element) {
        const owlId = $(element).attr('data-owl-id');
        const itemsCount = +$(element).attr('data-owl-items');
        const ignoreLoop = $(element).attr('data-owl-ignore-loop') == 'true';
        const dotsContainer = $(element).attr('data-owl-dots-container');
        const inogreNav = $(element).attr('data-owl-ignore-nav') == 'true';

        $(element).addClass('owl-carousel owl-theme');

        const config = {
            loop: false,
            nav: false,
            responsive: getResponsive(itemsCount),
            dotsContainer: dotsContainer,
        };

        !dotsContainer && delete config.dotsContainer;

        $(element).owlCarousel({
            ...config
        });

        if (! inogreNav) {
            let displayItemsCount = + ($(element).find('.owl-stage-outer > .owl-stage > .owl-item').length || 0);
            let acticeItemsCount  = + ($(element).find('.owl-stage-outer > .owl-stage > .owl-item.active').length || 0);

            acticeItemsCount = acticeItemsCount > itemsCount || acticeItemsCount == 0 ? itemsCount : acticeItemsCount;

            if (displayItemsCount > acticeItemsCount) {
                $(element).parent().append(owlBuildButton(owlId));
            }
        }

        $(`[data-owl-prev=${owlId}]`).on('click', function() {
            $(element).find('.owl-nav .owl-prev').trigger('click');
        });

        $(`[data-owl-next=${owlId}]`).on('click', function() {
            $(element).find('.owl-nav .owl-next').trigger('click');
        });
    });
}

owlSliderSetup();
