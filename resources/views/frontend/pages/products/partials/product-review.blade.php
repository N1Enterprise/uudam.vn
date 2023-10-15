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
                    <div class="spr-summary rte">
                        <span class="spr-summary-actions">
                            <a href="javascript:void(0)" class="spr-summary-actions-newreview" onclick="">Viết đánh giá</a>
                        </span>
                    </div>
                </div>
                <div class="spr-content">
                    <div data-product-review class="spr-form d-none">
                        <form method="post" action="//productreviews.shopifycdn.com/api/reviews/create" class="new-review-form" onsubmit="">
                            <input type="hidden" name="review[rating]">
                            <input type="hidden" name="product_id" value="6138916339864">
                            <h3 class="spr-form-title">Đánh giá của bạn</h3>
                            <fieldset class="spr-form-contact">
                                <div class="spr-form-contact-name">
                                    <label class="spr-form-label" for="review_author_6138916339864">Tên của bạn</label>
                                    <input class="spr-form-input spr-form-input-text " type="text" name="review[author]" value="" placeholder="Enter your name">
                                </div>
                            </fieldset>
                            <fieldset class="spr-form-review">
                                <div class="spr-form-review-rating">
                                    <label class="spr-form-label" for="review[rating]">chất lượng sản phẩm</label>
                                    <div class="spr-form-input spr-starrating ">
                                        <select class="ls-bundle-add-to-cart-select" size="1" data-price="32" data-original-price="null">
                                            @foreach ($productReviewRatingEnumLabels as $rating => $label)
                                            <option value="{{ $rating }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="spr-form-review-body">
                                    <label class="spr-form-label" for="Review_Product"> Nội dung đánh giá
                                        <span role="status" aria-live="polite" aria-atomic="true">
                                            <span class="spr-form-review-body-charactersremaining">(1500)</span>
                                            <span class="visuallyhidden">ký tự còn lại</span>
                                        </span>
                                    </label>
                                    <div class="spr-form-input">
                                        <textarea class="spr-form-input spr-form-input-textarea " id="Review_Product" data-product-id="{{ $inventory->id }}" name="review[body]" rows="10" placeholder="Viết đánh giá của bạn tại đây"></textarea>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="spr-form-actions">
                                <input type="submit" class="spr-button spr-button-primary button button-primary btn btn-primary" value="Gửi đánh giá">
                            </fieldset>
                        </form>
                    </div>
                    <div class="spr-reviews">
                        <div class="spr-review">
                            <div class="spr-review-header">
                                <span class="spr-starratings spr-review-header-starratings" aria-label="4 of 5 stars" role="img">
                                    Sản Phẩm Tốt
                                </span>
                                <h3 class="spr-review-header-title">Phạm Đình Hùng</h3>
                                <span class="spr-review-header-byline">
                                    <strong>28/10/2001</strong>
                                </span>
                            </div>
                            <div class="spr-review-content">
                                <p class="spr-review-content-body">Sản Phẩm Tốt</p>
                            </div>
                        </div>
                    </div>
                </div>
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
