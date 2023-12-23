<div class="isolate">
    <div class="slider-mobile-gutter">
        <div class="owl-carousel owl-theme multicolumn-list contains-content-container grid grid--1-col-tablet-down grid--3-col-desktop slider slider--mobile grid--peek" role="list" data-owl-id="Slider_Featured_Collections" data-owl-items="3">
            @foreach (data_get($item, 'linked_items') as $linkedItem)
            <div class="multicolumn-list__item grid__item slider__slide center" style="padding: 0 5px; width: 100%;" data-recommendation-post-identifier="{{ $linkedItem }}">
                <div class="blog__post article slider__slide slider__slide--full-width" style="padding: 0 5px;">
                    <div class="card-wrapper underline-links-hover" style="width: 100%;">
                        <div class="card article-card card--standard card--media">
                            <div class="card__inner  color-background-2 gradient ratio" style="--ratio-percent: 60.24096385542169%;">
                                <div class="article-card__image-wrapper card__media">
                                    <div class="article-card__image media media--hover-effect">
                                        <img class="image-lazy" srcset="{{ asset_with_version('frontend/assets/images/shared/skeleton-post.webp') }}" src="{{ asset_with_version('frontend/assets/images/shared/skeleton-post.webp') }}" sizes="(min-width: 1600px) 750px, (min-width: 750px) calc((100vw - 130px) / 2), calc((100vw - 50px) / 2)" alt="Ưu đàm bài viết" class="motion-reduce" loading="lazy" width="2727" height="1818">
                                    </div>
                                </div>
                            </div>
                            <div class="card__content">
                                <div class="card__information">
                                    <h3 class="card__heading h2 skeleton"></h3>
                                    <div class="article-card__info caption-with-letter-spacing h5 skeleton"></div>
                                    <p class="article-card__excerpt rte-width skeleton"></p>
                                    <div class="article-card__footer"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
