<div class="gallery-thumbnails__slider-nav gallery-thumbnails">
    @if(!empty($mediaVideos))
        @foreach ($mediaVideos as $video)
        <div class="thumbnail-list__item slider__slide" data-media-position="">
            <button class="thumbnail global-media-settings global-media-settings--no-shadow thumbnail--narrow" aria-label="Load image 1 in gallery view">
                <iframe style="height: 100%; width: 100%" src="{{ $video }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                <div class="video-wrapper">
                    <span class="deferred-media__poster-button motion-reduce">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-play" fill="none" viewBox="0 0 10 14">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M1.48177 0.814643C0.81532 0.448245 0 0.930414 0 1.69094V12.2081C0 12.991 0.858787 13.4702 1.52503 13.0592L10.5398 7.49813C11.1918 7.09588 11.1679 6.13985 10.4965 5.77075L1.48177 0.814643Z" fill="currentColor"></path>
                        </svg>
                    </span>
                </div>
            </button>
        </div>
        @endforeach
    @endif
    @foreach ($imageGalleries as $image)
    <div class="thumbnail-list__item slider__slide" data-media-position="{{ $loop->index + 1 }}">
        <button class="thumbnail global-media-settings global-media-settings--no-shadow thumbnail--narrow" aria-label="Load image 1 in gallery view">
            <img data-image-index="{{ $loop->index }}" srcset="{{ $image }}" src="{{ $image }}" sizes="(min-width: 1200px) calc((1200px - 19.5rem) / 12), (min-width: 750px) calc((100vw - 16.5rem) / 8), calc((100vw - 8rem) / 5)" alt="Teaching Garden Buddha Statue" height="200" width="200" loading="lazy">
        </button>
    </div>
    @endforeach
</div>
