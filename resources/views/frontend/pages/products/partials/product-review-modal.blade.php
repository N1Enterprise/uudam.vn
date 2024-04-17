<div class="product-modal-product-review">
    <product-modal class="product-media-modal media-modal">
        <button type="button" class="product-media-modal__toggle" data-product-review-modal-close>
            <svg xmlns="http://www.w3.org/2000/svg" focusable="false" class="icon icon-close" fill="none" viewBox="0 0 18 17">
                <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor"></path>
            </svg>
        </button>
        <div class="product-media-modal__content gradient" tabindex="0">
            <div class="spr-header">
                <h2 class="spr-header-title" style="text-align: left;">Đáng giá sản phẩm</h2>
            </div>
            <div class="spr-reviews">
                @if(has_data($productReviews))
                    @foreach ($productReviews as $review)
                    <div class="spr-review" data-status="{{ data_get($review, 'status') }}" data-status-name="{{ data_get($review, 'status_name') }}">
                        <div class="product-review-item">
                            <div class="spr-review-header">
                                <span class="spr-starratings spr-review-header-starratings">{{ data_get($productReviewRatingEnumLabels, data_get($review, 'rating_type'), data_get($review, 'rating_type_name')) }}</span>
                                <div style="display: flex; align-items: center;">
                                    <h3 class="spr-review-header-title">{{ data_get($review, 'user_name') }}</h3>
                                    @if (boolean(data_get($review, 'is_purchased')))
                                    <span style="padding: 0 10px;">|</span>
                                    <div is_purchased>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13px" height="13px" viewBox="0 0 24 24" fill="none">
                                            <path d="M7.29417 12.9577L10.5048 16.1681L17.6729 9" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <circle cx="12" cy="12" r="10" stroke="#FFFFFF" stroke-width="2"/>
                                        </svg>
                                        <span style="display: block; margin-left: 3px; color: #FFFFFF;">Đã mua hàng</span>
                                    </div>
                                    @endif
                                </div>
                                <span class="spr-review-header-byline">
                                    <strong>{{ date('d/m/Y H:i', strtotime(data_get($review, 'post_at'))) }}</strong>
                                </span>
                            </div>
                            <div class="spr-review-content">
                                <p class="spr-review-content-body">{{ data_get($review, 'content') }}</p>
                            </div>

                            @if (! empty(data_get($review, 'images')))
                            <div class="spr-review-images">
                                <div class="list-review-images">
                                    @foreach (data_get($review, 'images', []) as $image)
                                    <div>
                                        <div class="list-review-images__item">
                                            <img src="{{ data_get($image, 'path') }}" alt="{{ data_get($review, 'user_name') }} đánh giá sản phẩm {{ $inventory->title }}" style="width: 100%; height: auto;">
                                        </div>
                                        <a href="{{ data_get($image, 'path') }}" class="list-review-images_see-detail" target="_blank">Chi tiết</a>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @else
                <div class="product-review-empty">Hãy là người đánh giá sản phẩm này bạn nhé!</div>
                @endif
            </div>
            <button type="button" class="act-button" data-product-review-modal-close class="button" style="margin-top: 10px; padding: 10px; padding: 13px; margin-bottom: 60px;">Đã xem xong</button>
        </div>
    </product-modal>
</div>
