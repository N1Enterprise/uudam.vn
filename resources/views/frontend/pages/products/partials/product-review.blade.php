<div class="page-width">
    <div class="shopify-block shopify-app-block">
        <div id="shopify-product-reviews">
            <div class="spr-container">
                <div class="spr-header">
                    <h2 class="spr-header-title" style="text-align: left;">
                        <span>Phản hồi khách hàng</span>
                        @if (has_data($productReviews))
                        <div style="opacity: .5; font-size: 14px;">(Có {{ count($productReviews) }} phản hồi)</div>
                        @endif
                    </h2>
                    @if($AUTHENTICATED_USER)
                    <div class="spr-summary rte">
                        <span class="spr-summary-actions">
                            <button type="button" class="spr-summary-actions-newreview act-button">Viết đánh giá</button>
                        </span>
                    </div>
                    @endif
                </div>

                <div class="spr-content">
                    <div>
                        @if($AUTHENTICATED_USER)
                        <div data-product-review class="spr-form d-none">
                            <form id="User_Product_Review" method="post" action="{{ route('fe.api.user.product.review') }}" class="new-review-form">
                                <input type="hidden" name="product_id" value="{{ $inventory->product_id }}">
                                <h3 class="spr-form-title">Đánh giá của bạn</h3>
                                <fieldset class="spr-form-contact">
                                    <label class="spr-form-label" for="user_name">Tên của bạn *</label>
                                    <input type="text" name="username" value="{{ data_get($AUTHENTICATED_USER, 'name') }}" style="display: block; width: 100%; padding: 10px; font-size: 13px; margin-bottom: 10px;" disabled>
                                </fieldset>
                                <fieldset class="spr-form-review">
                                    <div class="spr-form-review-rating">
                                        <label class="spr-form-label" for="">chất lượng sản phẩm *</label>
                                        <div class="spr-form-input spr-starrating ">
                                            <select name="rating_type" class="ls-bundle-add-to-cart-select" size="1" data-price="32" data-original-price="null" style="padding: 10px; font-size: 13px;" required>
                                                @foreach ($productReviewRatingEnumLabels as $rating => $label)
                                                <option value="{{ $rating }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="spr-form-review-body">
                                        <label class="spr-form-label" for="Review_Product_Content"> Nội dung đánh giá *</label>
                                        <div class="spr-form-input">
                                            <textarea id="Review_Product_Content" class="spr-form-input spr-form-input-textarea" maxlength="1000" data-product-id="{{ $inventory->id }}" name="content" rows="2" cols="2" placeholder="Viết đánh giá của bạn tại đây (cho phép 1000 ký tự)" style="padding: 10px; font-size: 14px; resize: none;" required></textarea>
                                        </div>
                                    </div>
                                    <div class="spr-form-review-body">
                                        <div class="spr-form-input">
                                            <div class="box">
                                                <input type="file" name="review_files[]" id="review_files" class="inputfile review-inputfile inputfile-1" data-multiple-caption="Tải lên {count} ảnh" multiple accept="image/*">
                                                <label for="review_files">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                                        <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                                                    </svg>
                                                    <span>Thêm hình ảnh</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="spr-form-actions">
                                    <button type="submit" class="spr-button spr-button-primary button button-primary btn btn-primary" style="padding: 10px;">Gửi đánh giá</button>
                                </fieldset>
                            </form>
                        </div>
                        @else
                        <a href="?overlay=signin" data-overlay-action-button="signin" class="link">Đăng nhập</a>
                        <span style="font-size: 1.4rem;">để bình luận</span>
                        @endif
                        <div class="spr-reviews ">
                            @if(has_data($productReviews))
                                <div class="{{ count($productReviews) > 1 ? 'product-review-content-wrapper' : '' }}">
                                    @foreach ($productReviews as $review)
                                    <div class="spr-review" data-status="{{ data_get($review, 'status') }}" data-status-name="{{ data_get($review, 'status_name') }}">
                                        <div class="product-review-item">
                                            <div class="spr-review-header">
                                                <span class="spr-starratings spr-review-header-starratings">{{ data_get($productReviewRatingEnumLabels, data_get($review, 'rating_type'), data_get($review, 'rating_type_name')) }}</span>
                                                <div style="display: flex; align-items: center;">
                                                    <h3 class="spr-review-header-title">
                                                        <span>{{ data_get($review, 'user_name') }}</span>
                                                        @if (data_get($review, 'user_phone'))
                                                        <small style="color: #6a6969;">{{ data_get($review, 'user_phone') }}</small>
                                                        @endif
                                                    </h3>
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
                                    <div class="bg-article"></div>
                                </div>
                            @else
                            <div class="product-review-empty">Hãy là người đánh giá sản phẩm này bạn nhé!</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(has_data($productReviews) && count($productReviews) > 1)
        <button type="button" class="act-button list-review-images_see-all" style="transform: translateY(-50px)" data-product-review-modal-open>
            <span>Xem tất cả ({{ count($productReviews) }}) bình luận</span>
        </button>
        @endif
    </div>
</div>
