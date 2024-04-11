<div class="page-width">
    <div class="shopify-block shopify-app-block">
        <div id="shopify-product-reviews">
            <div class="spr-container">
                <div class="spr-header">
                    <h2 class="spr-header-title" style="text-align: left;">Phản hồi khách hàng</h2>
                    @if($AUTHENTICATED_USER)
                    <div class="spr-summary rte">
                        <span class="spr-summary-actions">
                            <button type="button" class="spr-summary-actions-newreview act-button">Viết đánh giá</button>
                        </span>
                    </div>
                    @endif
                </div>

                @if($AUTHENTICATED_USER)
                <div class="spr-content">
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
                                        <textarea id="Review_Product_Content" class="spr-form-input spr-form-input-textarea" maxlength="1000" data-product-id="{{ $inventory->id }}" name="content" rows="2" cols="2" placeholder="Viết đánh giá của bạn tại đây (cho phép 1000 ký tự)" style="padding: 5px;  font-size: 13px;" required></textarea>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="spr-form-actions">
                                <button type="submit" class="spr-button spr-button-primary button button-primary btn btn-primary" style="padding: 10px;">Gửi đánh giá</button>
                            </fieldset>
                        </form>
                    </div>
                    <div class="spr-reviews">
                        @if(has_data($productReviews))
                            @foreach ($productReviews as $review)
                            <div class="spr-review" data-status="{{ data_get($review, 'status') }}" data-status-name="{{ data_get($review, 'status_name') }}">
                                <div class="spr-review-header">
                                    <span class="spr-starratings spr-review-header-starratings">{{ data_get($productReviewRatingEnumLabels, data_get($review, 'rating_type'), data_get($review, 'rating_type_name')) }}</span>
                                    <h3 class="spr-review-header-title">{{ data_get($review, 'user_name') }}</h3>
                                    <span class="spr-review-header-byline">
                                        <strong>{{ date('d/m/Y H:i', strtotime(data_get($review, 'created_at'))) }}</strong>
                                    </span>
                                </div>
                                <div class="spr-review-content">
                                    <p class="spr-review-content-body">{{ data_get($review, 'content') }}</p>
                                </div>
                            </div>
                            @endforeach
                        @else
                        <div class="product-review-empty">Hãy là người đánh giá sản phẩm này bạn nhé!</div>
                        @endif
                    </div>
                </div>
                @else
                <a href="?overlay=signin" data-overlay-action-button="signin" class="link">Đăng nhập</a>
                <span style="font-size: 1.4rem;">để bình luận</span>
                @endif

            </div>
        </div>
        <style>
            .spr-form-review-body .spr-form-input {
                width: 100%;
            }

            .spr-form-review-body .spr-form-input textarea {
                min-height: 10rem;
            }
        </style>
    </div>
</div>
