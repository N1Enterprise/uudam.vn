<product-modal data-media-modal-close class="product-media-modal media-modal">
    <button type="button" class="product-media-modal__toggle">
        <svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="icon icon-close" fill="none" viewBox="0 0 18 17">
            <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor"></path>
        </svg>
    </button>

    <div class="product-media-modal__content gradient" tabindex="0">
        @if(!empty($mediaVideos))
            @foreach ($mediaVideos as $video)
            <div class="product-media-modal__video">
                <iframe id="product-video-iframe" style="height: 100%; width: 100%" class="global-media-settings global-media-settings--no-shadow" src="{{ $video }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
            @endforeach
        @endif
        @foreach ($imageGalleries as $image)
        <img data-image-index="{{ $loop->index }}" class="global-media-settings global-media-settings--no-shadow {{ $loop->index == 3 ? 'active' : '' }}" srcset="{{ $image }}" src="{{ $image }}" sizes="(min-width: 750px) calc(100vw - 22rem), 1100px" alt="Omni Bench 2" loading="lazy" width="1100" height="1100" data-media-id="29768139702522">
        @endforeach
    </div>
</product-modal>
