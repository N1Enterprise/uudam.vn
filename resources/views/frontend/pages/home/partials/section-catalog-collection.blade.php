<div class="section-template-padding page-width isolate">
    <div class="slider-mobile-gutter">
        <div class="owl-carousel owl-theme multicolumn-list contains-content-container grid grid--1-col-tablet-down grid--3-col-desktop slider slider--mobile grid--peek" role="list" data-owl-id="Slider_Featured_Collections" data-owl-items="3">
            @foreach ($featuredCollections as $collection)
            <div class="multicolumn-list__item grid__item slider__slide center" style="padding: 0 5px; width: 100%;">
                <div class="multicolumn-card content-container">
                    <div class="multicolumn-card__image-wrapper multicolumn-card__image-wrapper--full-width multicolumn-card-spacing">
                        <div class="media media--transparent media--adapt" style="padding-bottom: 59.78043912175649%;">
                            <img class="multicolumn-card__image" srcset="{{ data_get($collection, 'primary_image') }}" src="{{ data_get($collection, 'primary_image') }}" sizes="(min-width: 990px) 550px, (min-width: 750px) 550px, calc(100vw - 30px)" alt="{{ data_get($collection, 'name') }}" height="2000" width="3000" loading="lazy">
                        </div>
                    </div>
                    <div class="multicolumn-card__info">
                        <h3>{{ data_get($collection, 'name') }}</h3>
                        <a class="link animate-arrow" href="{{ route('fe.web.collections.index', data_get($collection, 'slug')) }}">
                            <span>{{ data_get($collection, 'cta_label') }}</span>
                            <span class="icon-wrap">&nbsp;
                                <svg viewBox="0 0 14 10" fill="none" aria-hidden="true" focusable="false" role="presentation" class="icon icon-arrow" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.537.808a.5.5 0 01.817-.162l4 4a.5.5 0 010 .708l-4 4a.5.5 0 11-.708-.708L11.793 5.5H1a.5.5 0 010-1h10.793L8.646 1.354a.5.5 0 01-.109-.546z" fill="currentColor"></path>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="slider-buttons no-js-hidden medium-hide">
            <button type="button" class="slider-button slider-button--prev" name="previous" aria-label="Slide left" data-owl-prev="Slider_Featured_Collections">
                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-caret" viewBox="0 0 10 6">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor"></path>
                </svg>
            </button>
            <button type="button" class="slider-button slider-button--next" name="next" aria-label="Slide right" data-owl-next="Slider_Featured_Collections">
                <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-caret" viewBox="0 0 10 6">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor"></path>
                </svg>
            </button>
        </div>
    </div>
</div>
