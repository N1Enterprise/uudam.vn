<div class="page-width">
    <div class="shopify-block shopify-app-block">
        <div id="shopify-product-reviews">
            <div class="spr-container">
                <div class="spr-header">
                    <h2 class="spr-header-title" style="text-align: left;">
                        <span style="text-align: left; text-transform: uppercase; font-weight: bold; color: #025B50; font-size: 17px;">Phản hồi khách hàng</span>
                        @if (has_data($productReviews))
                        <div style="font-size: 14px;">
                            @if(has_data($productReviews) && count($productReviews) > 1)
                            <div data-product-review-modal-open style="padding: 9px 0; text-decoration: underline; cursor: pointer; display: inline-block;">Xem ({{ count($productReviews) }}) đánh giá</div>
                            @endif
                        </div>
                        @endif
                    </h2>
                    @if($AUTHENTICATED_USER)
                    <div class="spr-summary rte">
                        <span class="spr-summary-actions">
                            <button type="button" class="spr-summary-actions-newreview act-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24" fill="none" style="transform: translateY(-2px); margin-right: 3px;">
                                    <path d="M8 9.00006H6.2C5.0799 9.00006 4.51984 9.00006 4.09202 9.21805C3.71569 9.40979 3.40973 9.71575 3.21799 10.0921C3 10.5199 3 11.08 3 12.2001V17.8001C3 18.9202 3 19.4802 3.21799 19.908C3.40973 20.2844 3.71569 20.5903 4.09202 20.7821C4.51984 21.0001 5.07989 21.0001 6.2 21.0001H17.787C18.9071 21.0001 19.4671 21.0001 19.895 20.7821C20.2713 20.5903 20.5772 20.2844 20.769 19.908C20.987 19.4802 20.987 18.9202 20.987 17.8001V12.0001M6 15.0001H6.01M10 15H10.01M11.5189 12.8946L12.8337 12.6347C13.5432 12.4945 13.8979 12.4244 14.2287 12.2953C14.5223 12.1807 14.8013 12.0318 15.06 11.8516C15.3514 11.6487 15.607 11.393 16.1184 10.8816L21.2668 5.73321C21.9541 5.04596 21.9541 3.9317 21.2668 3.24444C20.5796 2.55719 19.4653 2.55719 18.7781 3.24445L13.5416 8.48088C13.0625 8.96004 12.8229 9.19963 12.6294 9.47121C12.4576 9.71232 12.3131 9.97174 12.1986 10.2447C12.0696 10.5522 11.9921 10.8821 11.837 11.5417L11.5189 12.8946Z" stroke="#025b50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>Viết đánh giá</span>
                            </button>
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
                        <span data-overlay-action-button="signin" class="link">Đăng nhập</span>
                        <span style="font-size: 1.4rem;">để bình luận</span>
                        @endif
                        <div class="spr-reviews" style="margin-top: 0;">
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
            @if (has_data($productReviews))
            <button type="button" id="see-product-description" class="act-button btn" data-product-review-modal-open>
                <span>Xem thêm ...</span>
            </button>
            @endif
        </div>
    </div>
</div>
