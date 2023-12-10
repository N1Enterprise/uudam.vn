<div class="page-width">
    <div class="shopify-block shopify-app-block">
        <div id="shopify-product-reviews">
            <style scoped>
                .spr-container {
                    padding: 24px;
                    border-color: #ECECEC;
                }

                .spr-review,
                .spr-form {
                    border-color: #ECECEC;
                }
            </style>
            <div class="spr-container">
                <div class="spr-header">
                    <h2 class="spr-header-title">Phản hồi khách hàng</h2>
                    @if($AUTHENTICATED_USER)
                    <div class="spr-summary rte">
                        <span class="spr-summary-actions">
                            <a href="javascript:void(0)" class="spr-summary-actions-newreview" onclick="">Viết đánh giá</a>
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
                                <div class="spr-form-contact-name">
                                    <label class="spr-form-label" for="user_name">Tên của bạn *</label>
                                    <input class="spr-form-input spr-form-input-text " type="text" name="user_name" placeholder="Nhập tên bạn" style="padding: 5px;" required>
                                </div>
                            </fieldset>
                            <fieldset class="spr-form-review">
                                <div class="spr-form-review-rating">
                                    <label class="spr-form-label" for="">chất lượng sản phẩm *</label>
                                    <div class="spr-form-input spr-starrating ">
                                        <select name="rating_type" class="ls-bundle-add-to-cart-select" size="1" data-price="32" data-original-price="null" style="padding: 5px;" required>
                                            @foreach ($productReviewRatingEnumLabels as $rating => $label)
                                            <option value="{{ $rating }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="spr-form-review-body">
                                    <label class="spr-form-label" for="Review_Product_Content"> Nội dung đánh giá *
                                        <span role="status" aria-live="polite" aria-atomic="true">
                                            <span class="spr-form-review-body-charactersremaining">(<span class="charactersremaining-count">1000</span>)</span>
                                            <span class="visuallyhidden">ký tự còn lại</span>
                                        </span>
                                    </label>
                                    <div class="spr-form-input">
                                        <textarea id="Review_Product_Content" class="spr-form-input spr-form-input-textarea" maxlength="1000" data-product-id="{{ $inventory->id }}" name="content" rows="10" placeholder="Viết đánh giá của bạn tại đây" style="padding: 5px;" required></textarea>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="spr-form-actions">
                                <button type="submit" class="spr-button spr-button-primary button button-primary btn btn-primary" style="padding: 10px;">Gửi đánh giá</button>
                            </fieldset>
                        </form>
                    </div>
                    <div class="spr-reviews">
                        @if($productReviews->count())
                            @foreach ($productReviews as $review)
                            <div class="spr-review" data-status="{{ $review->status }}" data-status-name="{{ $review->status_name }}">
                                <div class="spr-review-header">
                                    <span class="spr-starratings spr-review-header-starratings">{{ data_get($productReviewRatingEnumLabels, $review->rating_type, $review->rating_type_name) }}</span>
                                    <h3 class="spr-review-header-title">{{ $review->user_name }}</h3>
                                    <span class="spr-review-header-byline">
                                        <strong>{{ date('d/m/Y H:i', strtotime($review->created_at)) }}</strong>
                                    </span>
                                </div>
                                <div class="spr-review-content">
                                    <p class="spr-review-content-body">{{ $review->content }}</p>
                                </div>
                            </div>
                            @endforeach
                        @else
                        <div class="product-review-empty">Hãy là người đánh giá sản phẩm này bạn nhé!</div>
                        @endif
                    </div>
                </div>
                @else
                <a href="?overlay=signin" data-overlay-action-button="signin">Đăng Nhập</a>
                <span>để bình luận</span>
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
