<slideshow-component class="slider-mobile-gutter page-width" aria-label="Slideshow about our brand">
    <div class="slideshow__controls slideshow__controls--top slider-buttons no-js-hidden">
        <button type="button" class="slider-button slider-button--prev" name="previous" aria-label="Previous slide" aria-controls="Slider-template--16599720624378__1655078171bc129901" data-slick-id="home_banner" data-slick-button-prev>
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-caret" viewBox="0 0 10 6">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor"></path>
            </svg>
        </button>
        <button type="button" class="slider-button slider-button--next" name="next" aria-label="Next slide" aria-controls="Slider-template--16599720624378__1655078171bc129901" data-slick-id="home_banner" data-slick-button-next>
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-caret" viewBox="0 0 10 6">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor"></path>
            </svg>
        </button>
    </div>
    <div class="slideshow banner banner--medium grid grid--1-col slider slider--everywhere" aria-live="off" aria-atomic="true" data-autoplay="true" data-speed="9" data-slick-config='{"id": "home_banner", "slidesToShow": 1, "slidesToScroll": 1, "dots": true, "lazyLoad": "ondemand", "infinite": true }'>
        @foreach ($homeBanners as $banner)
        <div class="slideshow__slide grid__item grid--1-col slider__slide" id="{{ $banner->id }}" role="group" aria-roledescription="Slide" aria-label="1 of 4" aria-hidden="true" tabindex="-1">
            <div class="slideshow__media banner__media media">
                <img
                    src="{{ $banner->desktop_image }}&amp;width=1500"
                    srcset="{{ $banner->mobile_image }}&amp;width=375 375w,{{ $banner->mobile_image }}&amp;width=550 550w,{{ $banner->mobile_image }}&amp;width=750 750w,{{ $banner->desktop_image }}&amp;width=1100 1100w,{{ $banner->desktop_image }}&amp;width=1500 1500w,{{ $banner->desktop_image }}&amp;width=1780 1780w,{{ $banner->desktop_image }}&amp;width=2000 2000w,{{ $banner->desktop_image }}&amp;width=3000 3000w,{{ $banner->desktop_image }}&amp;width=3840 3840w,{{ $banner->desktop_image }} 4472w"
                    sizes="100vw" loading="lazy" alt="" width="4472" height="2982">
            </div>
            <div class="slideshow__text-wrapper banner__content banner__content--middle-center page-width banner--desktop-transparent">
                <div class="slideshow__text banner__box content-container content-container--full-width-mobile color-accent-1 gradient slideshow__text--center slideshow__text-mobile--center">
                    <h2 class="banner__heading h1">{{ $banner->name }}</h2>
                    @if(! empty($banner->description))
                    <div class="banner__text">
                        <span>{{ $banner->description }}</span>
                    </div>
                    @endif
                    <div class="banner__buttons">
                        <a href="{{ $banner->redirect_url }}" class="button button--primary" tabindex="-1">{{ $banner->cta_label }}</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</slideshow-component>
