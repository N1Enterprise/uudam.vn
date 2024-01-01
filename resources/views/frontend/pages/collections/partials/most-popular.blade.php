<limespot-box data-owner="LimeSpot" data-box-type="Related" data-dynamic="true" data-host-page="Home" data-placement-order="2" class="ls-recommendation-box limespot-recommendation-box ls-animate page-width no-zoom section-template-padding" data-placement-disposition="0" data-placement-method="before" data-box-style="carousel" style="display: block;">
    <h3 class="ls-box-title">Sản phẩm nổi bậc</h3>
    <div class="limespot-recommendation-box-carousel-container">
        <div class="recommendation-items" data-show>
            <div class="ls-ul-container limespot-recommendation-box-carousel ls-drag-scroll v-align">
                <div class="owl-carousel owl-theme ls-ul limespot-recommendation-box-carousel-shelf" data-owl-id="Slider_Popular_Products_In_Collection" data-owl-items="5">
                    @foreach ($linkedFeaturedInventories as $inventory)
                    <div class="limespot-recommendation-box-item" style="max-width: 100%; min-width: 100%;" data-recommendation-product-identifier="{{ $inventory->id }}">
                        <div class="recommendation-target">
                            <a class="ls-link" data-product-identifier="{{ $inventory->id }}" href="{{ route('fe.web.products.index', $inventory->slug) }}">
                                <div class="ls-image-wrap">
                                    <img class="ls-image image-lazy" alt="{{ $inventory->image }}" title="{{ $inventory->image }}" loading="lazy" srcset="{{ $inventory->image }}" src="{{ $inventory->image }}" style="border-radius: 0px;">
                                </div>
                                <div class="ls-info-wrap">
                                    <div class="ls-title">{{ $inventory->title }}</div>
                                    <div class="ls-vendor">{{ data_get($inventory, 'product.branch') }}</div>
                                    <div class="ls-price-wrap">
                                        <span class="ls-original-price" style="display: none;"></span>
                                        <span class="ls-price money" data-numeric-value="{{ format_price($inventory->final_price) }}" data-money-convertible="">{{ format_price($inventory->final_price) }}</span>
                                        @if ($inventory->has_offer_price)
                                        <del class="price-item--sub">{{ format_price(data_get($inventory, 'sub_price')) }}</del>
                                            <span class="price-discount-percent">-{{ get_percent(data_get($inventory, 'final_price'), data_get($inventory, 'sub_price')) }}%</span>
                                            <div class="price-for-saving">(Tiết kiệm <span>{{ format_price( (float) data_get($inventory, 'sub_price') - (float) data_get($inventory, 'final_price') ) }}</span>)</div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</limespot-box>
