function owlSlider(className, numberOfShow, config = {}) {
    const buttonPrev = `${className}__prev`;
    const buttonNext = `${className}__next`;

    $(className).owlCarousel({
        loop: true,
        nav: false,
        ...config,
        responsive: getResponsive(numberOfShow)
    });

    $(buttonPrev).on('click', function() {
        $(className).find('.owl-nav .owl-prev').trigger('click');
    });

    $(buttonNext).on('click', function() {
        $(className).find('.owl-nav .owl-next').trigger('click');
    });
}

function getResponsive(numberOfShow) {
    const responsive = {
        1: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    };

    return responsive[numberOfShow];
}
