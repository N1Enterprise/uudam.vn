<slideshow-component class="slider-mobile-gutter page-width" aria-label="Slideshow about our brand">
    <div class="slideshow__controls slideshow__controls--top slider-buttons no-js-hidden">
        <button type="button" class="slider-button slider-button--prev" name="previous" aria-label="Previous slide" aria-controls="Slider-template--16599720624378__1655078171bc129901" data-owl-prev="Slider_Home_Banner">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-caret" viewBox="0 0 10 6">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor"></path>
            </svg>
        </button>
        <button type="button" class="slider-button slider-button--next" name="next" aria-label="Next slide" aria-controls="Slider-template--16599720624378__1655078171bc129901" data-owl-next="Slider_Home_Banner">
            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-caret" viewBox="0 0 10 6">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor"></path>
            </svg>
        </button>
    </div>
    <div class="slideshow banner banner--medium grid grid--1-col slider slider--everywhere" aria-live="off" aria-atomic="true" data-autoplay="true" data-speed="9" data-owl-id="Slider_Home_Banner" data-owl-items="1" data-owl-loop="true">
        @foreach ($homeBanners as $banner)
        <div class="slideshow__slide grid__item grid--1-col slider__slide" role="group" aria-roledescription="Slide" aria-label="1 of 4" aria-hidden="true" tabindex="-1">
            <div class="slideshow__media banner__media media">
                <img data-device="desktop" class="image-lazy" src="{{ data_get($banner, 'desktop_image') }}" srcset="{{ data_get($banner, 'desktop_image') }}" loading="lazy" alt="{{ data_get($banner, 'label') }}">
                <img data-device="mobile" class="image-lazy" src="{{ data_get($banner, 'mobile_image', data_get($banner, 'desktop_image')) }}" srcset="{{ data_get($banner, 'mobile_image', data_get($banner, 'desktop_image')) }}" loading="lazy" alt="{{ data_get($banner, 'label') }}">
            </div>
            <div class="slideshow__text-wrapper banner__content banner__content--middle-center page-width banner--desktop-transparent">
                <div class="slideshow__text banner__box content-container content-container--full-width-mobile color-accent-1 gradient slideshow__text--center slideshow__text-mobile--center">
                    @if (data_get($banner, 'label'))
                    <h2 class="banner__heading h1">{{ data_get($banner, 'label') }}</h2>
                    @endif

                    @if (data_get($banner, 'description'))
                    <div class="banner__text">
                        <span>{{ data_get($banner, 'description') }}</span>
                    </div>
                    @endif

                    @if (data_get($banner, 'redirect_url') && data_get($banner, 'cta_label'))
                    <div class="banner__buttons">
                        <a href="{{ data_get($banner, 'redirect_url') }}" class="button button--primary" tabindex="-1" style="background: none; color: #fff;">{{ data_get($banner, 'cta_label') }}</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</slideshow-component>
