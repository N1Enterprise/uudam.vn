<div class="slider-component thumbnail-slider slider-mobile-gutter quick-add-hidden small-hide">
    <div class="thumbnail-list list-unstyled slider slider--mobile slider--tablet-up">
        @foreach ($imageGalleries as $image)
        <div class="thumbnail-list__item slider__slide" data-media-position="{{ $loop->index + 1 }}">
            <button class="thumbnail global-media-settings global-media-settings--no-shadow thumbnail--narrow" aria-label="Load image 1 in gallery view" {{ $loop->index == 0 ? 'aria-current' : '' }}>
                <img srcset="{{ $image }}" src="{{ $image }}" sizes="(min-width: 1200px) calc((1200px - 19.5rem) / 12), (min-width: 750px) calc((100vw - 16.5rem) / 8), calc((100vw - 8rem) / 5)" alt="Teaching Garden Buddha Statue" height="200" width="200" loading="lazy">
            </button>
        </div>
        @endforeach
    </div>
</div>
