<limespot-box data-owner="LimeSpot" class="ls-recommendation-box limespot-recommendation-box ls-animate page-width no-zoom section-template-padding" data-box-style="carousel" style="display: block;">
    <h3 class="ls-box-title">Mặt Hàng Phổ Biến Nhất</h3>
    <div class="limespot-recommendation-box-carousel-container">
        <div class="ls-ul-container limespot-recommendation-box-carousel ls-drag-scroll v-align">
            <div class="owl-carousel owl-theme ls-ul limespot-recommendation-box-carousel-shelf" data-owl-id="Slider_Popular_Products" data-owl-items="5">
                @foreach ($popularInventories as $inventory)
                <div class="limespot-recommendation-box-item" data-product-identifier="{{ $inventory->id }}" data-product-title="{{ $inventory->title }}" data-price="{{ format_price($inventory->sale_price) }}" data-original-price="{{ format_price($inventory->sale_price) }}" data-display-url="{{ route('fe.web.products.index', $inventory->slug) }}" style="margin-right: 10px; max-width: 270px; flex-basis: 270px; min-width: 270px;">
                    <div class="recommendation-target">
                        <a class="ls-link" data-product-identifier="{{ $inventory->id }}" href="{{ route('fe.web.products.index', $inventory->slug) }}">
                            <div class="ls-image-wrap">
                                <img class="ls-image image-lazy" alt="{{ $inventory->title }}" title="{{ $inventory->title }}" loading="lazy" sizes="270px" srcset="{{ $inventory->image }}" src="{{ $inventory->image }}" style="max-width: 270px; max-height: 270px; border-radius: 0px;">
                            </div>
                            <div class="ls-info-wrap">
                                <div class="ls-title">{{ $inventory->title }}</div>
                                <div class="ls-vendor">{{ $inventory->product_branch }}</div>
                                <div class="ls-price-wrap">
                                    <span class="ls-original-price" style="display: none;"></span>
                                    <span class="ls-price money" data-numeric-value="{{ format_price($inventory->sale_price) }}" data-money-convertible="">{{ format_price($inventory->sale_price) }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="ls-left-arrow limespot-recommendation-box-carousel-indicator indicator-left static-arrow ls-animate" data-owl-prev="Slider_Popular_Products">
            <div class="recomm-arrow arrow-left ls-svg-arrow" style="margin-top: 115px; max-width: 50px;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="-10 -10 44.5 62.03">
                    <path d="M5 .6a2 2 0 0 0-3 0L1 1.8a2 2 0 0 0 0 2.8l14.6 14.7a2 2 0 0 1 0 2.8L.6 37a2 2 0 0 0 0 3L2 41.3a2 2 0 0 0 3 0l19-19a2 2 0 0 0 0-2.8z"></path>
                </svg>
            </div>
        </div>
        <div class="ls-right-arrow limespot-recommendation-box-carousel-indicator indicator-right static-arrow ls-animate" data-owl-next="Slider_Popular_Products">
            <div class="recomm-arrow arrow-right ls-svg-arrow" style="margin-top: 115px; max-width: 50px;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="-10 -10 44.5 62.03">
                    <path d="M5 .6a2 2 0 0 0-3 0L1 1.8a2 2 0 0 0 0 2.8l14.6 14.7a2 2 0 0 1 0 2.8L.6 37a2 2 0 0 0 0 3L2 41.3a2 2 0 0 0 3 0l19-19a2 2 0 0 0 0-2.8z"></path>
                </svg>
            </div>
        </div>
    </div>
</limespot-box>
