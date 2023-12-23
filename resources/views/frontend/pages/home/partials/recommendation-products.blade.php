<div class="limespot-recommendation-box-carousel-container">
    <div class="ls-ul-container limespot-recommendation-box-carousel ls-drag-scroll v-align">
        <div class="owl-carousel owl-theme ls-ul limespot-recommendation-box-carousel-shelf" data-owl-id="Slider_Popular_Products" data-owl-items="5">
            @foreach (data_get($item, 'linked_items') as $linkedItem)
            <div class="limespot-recommendation-box-item" style="margin-right: 10px; max-width: 270px; flex-basis: 270px; min-width: 270px;">
                <a class="ls-link" data-product-identifier="" href="">
                    <div class="ls-image-wrap">
                        <img class="ls-image image-lazy" alt="Sản phẩm ưu đàm" title="Sản phẩm ưu đàm" loading="lazy" sizes="270px" srcset="{{ asset_with_version('frontend/assets/images/shared/skeleton-product.webp') }}" src="{{ asset_with_version('frontend/assets/images/shared/skeleton-product.webp') }}" style="max-width: 270px; max-height: 270px; border-radius: 0px;">
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
            @endforeach
        </div>
    </div>
</div>