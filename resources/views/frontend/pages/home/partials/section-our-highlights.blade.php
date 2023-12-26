<div class="multicolumn color-background-1 gradient background-none no-heading">
    <div class="page-width section-template-padding isolate">
        <div class="slider-mobile-gutter">
            <ul class="multicolumn-list contains-content-container grid grid--2-col-tablet-down grid--4-col-desktop">
                @foreach (data_get($SYSTEM_SETTING, 'page_highlight_information', []) as $item)
                <li id="Slide-template--16599720624378__1658781193af1744fb-1" class="multicolumn-list__item grid__item">
                    <div class="multicolumn-card content-container">
                        <div class="multicolumn-card__info">
                            <h3>{{ data_get($item, 'title') }}</h3>
                            <div class="rte">
                                <p>{{ data_get($item, 'description') }}</p>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
