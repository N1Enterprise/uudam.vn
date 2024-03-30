<div class="isolate">
    <div class="slider-mobile-gutter">
        <div class="owl-carousel owl-theme multicolumn-list contains-content-container grid grid--1-col-tablet-down grid--3-col-desktop slider slider--mobile grid--peek" role="list" data-owl-id="Slider_Featured_Collections" data-owl-items="3">
            @foreach (data_get($item, 'linked_items') as $linkedItem)
            <div class="multicolumn-list__item grid__item slider__slide center" style="width: 100%;" data-recommendation-collection-identifier="{{ $linkedItem }}">
                <div class="recommendation-target">
                    <div class="multicolumn-list__item grid__item slider__slide center" style="width: 100%;">
                        <a href="/" class="a-prevent" style="text-decoration: none;">
                            <div class="multicolumn-card content-container">
                                <div class="multicolumn-card__image-wrapper multicolumn-card__image-wrapper--full-width">
                                    <div class="media media--transparent media--adapt">
                                        <img class="multicolumn-card__image image-lazy" srcset="{{ asset_with_version('frontend/assets/images/shared/skeleton-collection.webp') }}" src="{{ asset_with_version('frontend/assets/images/shared/skeleton-collection.webp') }}" alt="Ưu đàm bộ sưu tập" style="width: 100%; height: 100%;" loading="lazy">
                                    </div>
                                </div>
                                <div class="multicolumn-card__info" style="padding: 10px 0;">
                                    <h3 class="skeleton"></h3>
                                    <a class="link animate-arrow" href="">
                                        <span class="skeleton"></span>
                                    </a>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
