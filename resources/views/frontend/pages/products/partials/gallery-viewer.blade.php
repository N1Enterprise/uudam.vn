<div class="slider-component slider-mobile-gutter">
    <a class="skip-to-content-link button visually-hidden quick-add-hidden"> Skip to product information </a>
    <div data-owl-id="Slider_Product_Detail" data-owl-items="1" class="owl-carousel owl-theme product__media-list contains-media grid grid--peek list-unstyled slider slider--mobile" >
        @if(!empty($mediaVideos))
        @foreach ($mediaVideos as $video)
        <div data-media-modal-open data-owl-index="0" class="product__media-item grid__item slider__slide">
            <div data-media-modal-open class="modal-opener product__modal-opener product__modal-opener--image no-js-hidden">
                <span class="product__media-icon motion-reduce quick-add-hidden">
                    <svg focusable="false" class="icon icon-plus" width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.66724 7.93978C4.66655 7.66364 4.88984 7.43922 5.16598 7.43853L10.6996 7.42464C10.9758 7.42395 11.2002 7.64724 11.2009 7.92339C11.2016 8.19953 10.9783 8.42395 10.7021 8.42464L5.16849 8.43852C4.89235 8.43922 4.66793 8.21592 4.66724 7.93978Z" fill="currentColor"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.92576 4.66463C8.2019 4.66394 8.42632 4.88723 8.42702 5.16337L8.4409 10.697C8.44159 10.9732 8.2183 11.1976 7.94215 11.1983C7.66601 11.199 7.44159 10.9757 7.4409 10.6995L7.42702 5.16588C7.42633 4.88974 7.64962 4.66532 7.92576 4.66463Z" fill="currentColor"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.8324 3.03011C10.1255 0.323296 5.73693 0.323296 3.03011 3.03011C0.323296 5.73693 0.323296 10.1256 3.03011 12.8324C5.73693 15.5392 10.1255 15.5392 12.8324 12.8324C15.5392 10.1256 15.5392 5.73693 12.8324 3.03011ZM2.32301 2.32301C5.42035 -0.774336 10.4421 -0.774336 13.5395 2.32301C16.6101 5.39361 16.6366 10.3556 13.619 13.4588L18.2473 18.0871C18.4426 18.2824 18.4426 18.599 18.2473 18.7943C18.0521 18.9895 17.7355 18.9895 17.5402 18.7943L12.8778 14.1318C9.76383 16.6223 5.20839 16.4249 2.32301 13.5395C-0.774335 10.4421 -0.774335 5.42035 2.32301 2.32301Z" fill="currentColor"></path>
                    </svg>
                </span>
                <div class="product__media media media--transparent gradient global-media-settings" style="padding-top: 85%;">
                    <span class="deferred-media__poster-button motion-reduce">
                        <svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="icon icon-play" fill="none" viewBox="0 0 10 14">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M1.48177 0.814643C0.81532 0.448245 0 0.930414 0 1.69094V12.2081C0 12.991 0.858787 13.4702 1.52503 13.0592L10.5398 7.49813C11.1918 7.09588 11.1679 6.13985 10.4965 5.77075L1.48177 0.814643Z" fill="currentColor"></path>
                        </svg>
                    </span>
                    <iframe style="height: 100%; width: 100%" src="{{ $video }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
                <button class="product__media-toggle quick-add-hidden" type="button">
                    <span class="visually-hidden">Xem media trong một modal</span>
                </button>
            </div>
        </div>
        @endforeach
        @endif

        @foreach ($imageGalleries as $image)
        <div data-media-modal-open data-owl-index="{{ empty($mediaVideos) ? $loop->index : $loop->index + 1 }}" class="product__media-item grid__item slider__slide is-active">
            <div class="modal-opener product__modal-opener product__modal-opener--image no-js-hidden">
                <span class="product__media-icon motion-reduce quick-add-hidden">
                    <svg focusable="false" class="icon icon-plus" width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.66724 7.93978C4.66655 7.66364 4.88984 7.43922 5.16598 7.43853L10.6996 7.42464C10.9758 7.42395 11.2002 7.64724 11.2009 7.92339C11.2016 8.19953 10.9783 8.42395 10.7021 8.42464L5.16849 8.43852C4.89235 8.43922 4.66793 8.21592 4.66724 7.93978Z" fill="currentColor"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.92576 4.66463C8.2019 4.66394 8.42632 4.88723 8.42702 5.16337L8.4409 10.697C8.44159 10.9732 8.2183 11.1976 7.94215 11.1983C7.66601 11.199 7.44159 10.9757 7.4409 10.6995L7.42702 5.16588C7.42633 4.88974 7.64962 4.66532 7.92576 4.66463Z" fill="currentColor"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.8324 3.03011C10.1255 0.323296 5.73693 0.323296 3.03011 3.03011C0.323296 5.73693 0.323296 10.1256 3.03011 12.8324C5.73693 15.5392 10.1255 15.5392 12.8324 12.8324C15.5392 10.1256 15.5392 5.73693 12.8324 3.03011ZM2.32301 2.32301C5.42035 -0.774336 10.4421 -0.774336 13.5395 2.32301C16.6101 5.39361 16.6366 10.3556 13.619 13.4588L18.2473 18.0871C18.4426 18.2824 18.4426 18.599 18.2473 18.7943C18.0521 18.9895 17.7355 18.9895 17.5402 18.7943L12.8778 14.1318C9.76383 16.6223 5.20839 16.4249 2.32301 13.5395C-0.774335 10.4421 -0.774335 5.42035 2.32301 2.32301Z" fill="currentColor"></path>
                    </svg>
                </span>
                <div class="product__media media media--transparent gradient global-media-settings" style="padding-top: 85%;">
                    <img data-image-index="{{ $loop->index }}" srcset="{{ $image }}" src="{{ $image }}" sizes="(min-width: 1600px) 975px, (min-width: 990px) calc(65.0vw - 10rem), (min-width: 750px) calc((100vw - 11.5rem) / 2), calc(100vw - 4rem)" width="973" height="973" alt="{{ data_get($inventory, 'title') }}">
                </div>
                <button class="product__media-toggle quick-add-hidden" type="button">
                    <span class="visually-hidden"> Open media 1 in modal </span>
                </button>
            </div>
        </div>
        @endforeach
    </div>
    <div class="slider-buttons no-js-hidden quick-add-hidden">
        <button data-owl-prev="Slider_Product_Detail" type="button" class="slider-button slider-button--prev" name="previous">
            <svg focusable="false" class="icon icon-caret" viewBox="0 0 10 6">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor"></path>
            </svg>
        </button>
        <button data-owl-next="Slider_Product_Detail" type="button" class="slider-button slider-button--next" name="next">
            <svg focusable="false" class="icon icon-caret" viewBox="0 0 10 6">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor"></path>
            </svg>
        </button>
    </div>
</div>
