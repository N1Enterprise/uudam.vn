<div class="slider-component thumbnail-slider slider-mobile-gutter quick-add-hidden small-hide">
    <button type="button" class="slider-button slider-button--prev" data-owl-prev="Slider_Product_Thumnail">
        <svg focusable="false" role="presentation" class="icon icon-caret" viewBox="0 0 10 6">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor"></path>
        </svg>
    </button>
    <div data-owl-id="Slider_Product_Thumnail" data-owl-items="5" data-owl-dots-container=".Slider_Product_Detail_Class" class="owl-carousel owl-theme thumbnail-list list-unstyled slider slider--mobile slider--tablet-up">
        @if(!empty($mediaVideos))
            @foreach ($mediaVideos as $video)
            <div data-owl-index="0" class="thumbnail-list__item slider__slide" style="width: 100%;">
                <button class="thumbnail global-media-settings global-media-settings--no-shadow thumbnail--narrow owl-dot">
                    <iframe style="height: 100%; width: 100%" src="{{ $video }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    <div class="video-wrapper">
                        <span class="deferred-media__poster-button motion-reduce">
                            <svg xmlns="http://www.w3.org/2000/svg" focusable="false" role="presentation" class="icon icon-play" fill="none" viewBox="0 0 10 14">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.48177 0.814643C0.81532 0.448245 0 0.930414 0 1.69094V12.2081C0 12.991 0.858787 13.4702 1.52503 13.0592L10.5398 7.49813C11.1918 7.09588 11.1679 6.13985 10.4965 5.77075L1.48177 0.814643Z" fill="currentColor"></path>
                            </svg>
                        </span>
                    </div>
                </button>
            </div>
            @endforeach
        @endif
        @foreach ($imageGalleries as $image)
        <div data-owl-index="{{ empty($mediaVideos) ? $loop->index : $loop->index + 1 }}" class="thumbnail-list__item slider__slide" style="width: 100%;">
            <button class="thumbnail global-media-settings global-media-settings--no-shadow thumbnail--narrow" {{ empty($mediaVideos) ? $loop->index == 0 ? 'aria-current' : '' : '' }}>
                <img data-image-index="{{ $loop->index }}" srcset="{{ $image }}" src="{{ $image }}" sizes="(min-width: 1200px) calc((1200px - 19.5rem) / 12), (min-width: 750px) calc((100vw - 16.5rem) / 8), calc((100vw - 8rem) / 5)" alt="{{ data_get($inventory, 'title') }}" height="200" width="200" loading="lazy">
            </button>
        </div>
        @endforeach
    </div>
    <button type="button" class="slider-button slider-button--next" data-owl-next="Slider_Product_Thumnail">
        <svg focusable="false" role="presentation" class="icon icon-caret" viewBox="0 0 10 6">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor"></path>
        </svg>
    </button>
</div>
