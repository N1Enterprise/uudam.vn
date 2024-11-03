<limespot-box data-owner="LimeSpot" data-box-type="Related" data-dynamic="true" data-host-page="Home" data-placement-order="2" class="ls-recommendation-box limespot-recommendation-box ls-animate page-width no-zoom section-template-padding" data-placement-disposition="0" data-placement-method="before" data-box-style="carousel" style="display: block;">
    <h3 class="ls-box-title">Sản phẩm Nổi bật</h3>
    <div class="limespot-recommendation-box-carousel-container">
        <div class="recommendation-items" data-show>
            <div class="ls-ul-container limespot-recommendation-box-carousel ls-drag-scroll v-align">
                <div class="owl-carousel owl-theme ls-ul limespot-recommendation-box-carousel-shelf" data-owl-id="Slider_Popular_Products_In_Collection" data-owl-items="5">
                    @foreach ($linkedFeaturedInventories as $inventory)
                    <div class="limespot-recommendation-box-item" style="max-width: 100%; min-width: 100%;" data-recommendation-product-identifier="{{ $inventory->id }}">
                        <div class="recommendation-target">
                            <a href="{{ route('fe.web.products.index', $inventory->slug) }}" class="ls-link" data-product-identifier="{{ $inventory->id }}">
                                <div class="ls-image-wrap">
                                    <img class="ls-image image-lazy" alt="{{ $inventory->image }}" title="{{ $inventory->title }}" loading="lazy" srcset="{{ $inventory->image }}" src="{{ $inventory->image }}" style="border-radius: 0px;">
                                </div>
                                <div class="ls-info-wrap">
                                    <div class="ls-title">{{ $inventory->title }}</div>
                                    <div class="ls-vendor">{{ data_get($inventory, 'product.branch') }}</div>
                                    <div class="ls-reviewer">
                                        @if (has_data(data_get($inventory, 'product.reviews')))
                                        <b>{{ count( data_get($inventory, 'product.reviews') ) }}</b> đánh giá tích cực
                                        @endif
                                    </div>
                                    <div class="ls-price-wrap">
                                        <div class="ls-price-group">
                                            <div>
                                                <span class="ls-price money" data-numeric-value="{{ format_price($inventory->final_price) }}" data-money-convertible="">{{ format_price($inventory->final_price) }}</span>
                                                <del class="price-item--sub">{{ format_price(data_get($inventory, 'sub_price')) }}</del>
                                            </div>
                                            <span class="sold-count">Đã bán {{ $inventory->final_sold_count }}</span>
                                        </div>

                                        @if ($inventory->has_offer_price)
                                            <span class="price-discount-percent discount-absolute">-{{ get_percent(data_get($inventory, 'final_price'), data_get($inventory, 'sub_price')) }}%</span>
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
