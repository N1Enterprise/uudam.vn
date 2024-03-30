<div class="section-content-template">
    <div class="section-template-padding page-width">
        <div class="recommendation-target">
            <div class="section-template-wrapper video-featured-section-01">
                <div class="section-template-wrapper-nav-tabs owl-carousel owl-theme" data-owl-id="Home_Video_Featured" data-owl-items="5">
                    @foreach ($videoCategories as $category)
                    <div style="margin-right: 5px;">
                        <button type="button" class="section-template-wrapper-nav-tabs-item nav-tabs-item-link act-button w-100 {{  $loop->index == 0 ? 'active' : '' }}" data-featured-video-nav-tab-id="video_category_{{ data_get($category, 'id') }}">
                            <span>{{ data_get($category, 'name') }}</span>
                        </button>
                    </div>
                    @endforeach
                </div>

                <div class="section-template-wrapper-nav-content">
                    @foreach ($videoCategories as $category)
                    <div class="d-none" data-featured-video-nav-content-ref="video_category_{{ data_get($category, 'id') }}">
                        <div data-section="home_page_display_{{ data_get($item, 'type') }}:{{ data_get($item, 'id') }}" data-section-defer="true">
                            <limespot-box data-owner="LimeSpot" class="ls-recommendation-box limespot-recommendation-box ls-animate no-zoom multicolumn background-primary" data-box-style="carousel" style="display: block;">
                                <div class="recommendation-items">
                                    <div class="isolate">
                                        <div class="slider-mobile-gutter">
                                            <div class="owl-carousel owl-theme multicolumn-list contains-content-container grid grid--1-col-tablet-down grid--3-col-desktop slider slider--mobile grid--peek" role="list" data-owl-id="Slider_Featured_Collections" data-owl-items="3">
                                                @foreach (data_get($category, 'videos', []) as $video)
                                                <div class="recommendation-target">
                                                    <div class="blog__post article slider__slide slider__slide--full-width">
                                                        <div class="card-wrapper underline-links-hover" style="width: 100%;">
                                                            <div class="card article-card card--standard card--media">
                                                                <div class="card__inner  color-background-2 gradient ratio">
                                                                    <div class="play-icon">
                                                                        <span class="deferred-media__poster-button motion-reduce">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-play" fill="none" viewBox="0 0 10 14">
                                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.48177 0.814643C0.81532 0.448245 0 0.930414 0 1.69094V12.2081C0 12.991 0.858787 13.4702 1.52503 13.0592L10.5398 7.49813C11.1918 7.09588 11.1679 6.13985 10.4965 5.77075L1.48177 0.814643Z" fill="currentColor"></path>
                                                                            </svg>
                                                                        </span>
                                                                    </div>
                                                                    <div class="article-card__image-wrapper card__media">
                                                                        <div class="article-card__image media media--hover-effect">
                                                                            <img class="image-lazy" srcset="{{ data_get($video, 'thumbnail') }}" src="{{ data_get($video, 'thumbnail') }}" sizes="(min-width: 1600px) 750px, (min-width: 750px) calc((100vw - 130px) / 2), calc((100vw - 50px) / 2)" alt="{{ data_get($video, 'name') }}" loading="lazy" width="2727" height="1818">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card__content">
                                                                    <div class="card__information">
                                                                        <h3 class="card__heading h2">
                                                                            <a href="{{ route('fe.web.videos.index', data_get($video, 'slug')) }}" class="full-unstyled-link">{{ data_get($video, 'name') }}</a>
                                                                        </h3>
                                                                        <div class="article-card__info caption-with-letter-spacing h5">
                                                                            <span class="circle-divider">
                                                                                <time datetime="{{ data_get($video, 'created_at') }}">{{ format_datetime(data_get($video, 'created_at')) }}</time>
                                                                            </span>
                                                                        </div>
                                                                        <p class="article-card__excerpt rte-width">{{ data_get($video, 'description') }}</p>
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
                                </div>
                            </limespot-box>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
