$(document).ready(function() {
    const SLICK_CAROUSEL = {
        init: () => {
            $.each($('[data-slick-config]'), function(index, element) {
                const bsConfig = {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: false,
                    infinite: false,
                };

                const instance = $(element);

                const ctConfig = JSON.parse(instance.attr('data-slick-config') || '{}');

                let __config = { ...bsConfig, ...ctConfig };

                let responsive = SLICK_CAROUSEL.buildResponsive(__config.slidesToShow);

                __config = { ...__config, responsive };

                instance.slick(__config);

                const slickID = ctConfig?.id;

                if (slickID) {
                    const ctBtnNext = $(`[data-slick-id="${slickID}"][data-slick-button-next]`);
                    const ctBtnPrev = $(`[data-slick-id="${slickID}"][data-slick-button-prev]`);

                    if (ctBtnNext) ctBtnNext.on('click', () => instance.find('.slick-next.slick-arrow').trigger('click'));

                    if (ctBtnPrev) ctBtnPrev.on('click', () => instance.find('.slick-prev.slick-arrow').trigger('click'));
                }
            });
        },
        buildResponsive: (count) => {
            const settings = {
                5: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    }
                ],
                3: [
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ],
            };

            return settings?.[count] || [];
        },
    };

    SLICK_CAROUSEL.init();
});
