<div class="multicolumn color-background-1 gradient background-none">
    <div class="page-width section-template-padding isolate">
        <div class="title-wrapper-with-link title-wrapper--self-padded-mobile title-wrapper--no-top-margin">
            <h2 class="title h2">Bộ sưu tập của chúng tôi</h2>
        </div>
        <div class="slider-mobile-gutter">
            <div class="multicolumn-list contains-content-container grid grid--2-col-tablet-down grid--6-col-desktop">
                @foreach ($displayOnFrontendCollections as $collection)
                <div class="multicolumn-list__item grid__item center">
                    <div class="multicolumn-card content-container">
                        <div class="multicolumn-card__image-wrapper multicolumn-card__image-wrapper--full-width multicolumn-card-spacing">
                            <div class="media media--transparent media--circle">
                                <img class="multicolumn-card__image" srcset="{{ data_get($collection, 'primary_image') }}" src="{{ data_get($collection, 'primary_image') }}" sizes="(min-width: 990px) 550px, (min-width: 750px) 550px, calc(100vw - 30px)" alt="{{ data_get($collection, 'name') }}" height="800" width="800" loading="lazy">
                            </div>
                        </div>
                        <div class="multicolumn-card__info">
                            <a class="link animate-arrow" href="{{ route('fe.web.collections.index', data_get($collection, 'slug')) }}">
                                <span>{{ data_get($collection, 'name') }}</span>
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
        </div>
    </div>
</div>
