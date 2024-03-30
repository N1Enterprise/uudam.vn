<div class="limespot-recommendation-box-carousel-container">
    <div class="ls-ul-container limespot-recommendation-box-carousel ls-drag-scroll v-align">
        <div class="owl-carousel owl-theme ls-ul limespot-recommendation-box-carousel-shelf" data-owl-id="Slider_Popular_Products" data-owl-items="4">
            @foreach (data_get($item, 'linked_items') as $linkedItem)
            <div class="limespot-recommendation-box-item" style="max-width: 100%; min-width: 100%;" data-recommendation-product-identifier="{{ $linkedItem }}">
                <div class="recommendation-target">
                    <a href="/" class="ls-link a-prevent">
                        <div class="ls-image-wrap">
                            <img class="ls-image image-lazy" alt="Sản phẩm ưu đàm" title="Sản phẩm ưu đàm" loading="lazy" srcset="{{ asset_with_version('frontend/assets/images/shared/skeleton-product.webp') }}" src="{{ asset_with_version('frontend/assets/images/shared/skeleton-product.webp') }}" style="border-radius: 0px;">
                        </div>
                        <div class="ls-info-wrap">
                            <div class="ls-title skeleton"></div>
                            <div class="ls-price-wrap" style="display: flex;">
                                <span class="ls-original-price skeleton" style="display: none; flex: 0 0 60%;"></span>
                                <span class="ls-price money skeleton"></span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
