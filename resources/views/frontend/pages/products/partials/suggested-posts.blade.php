<div class="product-review-posts">
    <div class="rte">
        <div class="spr-container">

            <div class="spr-content product-description-content article__content-posts">
                <h2 class="spr-header-title" style="text-align: left; text-transform: uppercase; font-weight: bold; color: #025B50; font-size: 17px; display: flex; align-items: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="15" viewBox="0 0 20 15" style="margin-right: 5px; transform: translateY(-1px);">
                        <path id="newspaper" d="M17.5,6.5V4H0V17.75A1.25,1.25,0,0,0,1.25,19H18.125A1.875,1.875,0,0,0,20,17.125V6.5ZM16.25,17.75h-15V5.25h15ZM2.5,7.75H15V9H2.5Zm7.5,2.5h5V11.5H10Zm0,2.5h5V14H10Zm0,2.5h3.75V16.5H10Zm-7.5-5H8.75V16.5H2.5Z" transform="translate(0 -4)" fill="#025B50"></path>
                    </svg>
                    <span>Bài viết liên quan</span>
                </h2>
                @foreach ($suggestedPosts as $post)
                <article>
                    <a target="_blank" href="{{ route('fe.web.posts.index', data_get($post, 'slug')) }}" class="suggested_post__content-item button__link">
                        <img src="{{ data_get($post, 'image') }}" alt="{{ data_get($post, 'name') }}" loading="lazy" class="content-item__img">
                        <div class="content-item__text">{{ data_get($post, 'name') }}</div>
                    </a>
                </article>
                @endforeach
            </div>

            {{-- <a href="" class="act-button btn jsArticle btn-show-more-posts-related-product">
                <span>Xem tất cả bài viết</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="10" height="10" class="icon-view-more">
                    <path d="M224 416c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L224 338.8l169.4-169.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-192 192C240.4 412.9 232.2 416 224 416z"></path>
                </svg>
            </a> --}}
        </div>
    </div>
</div>
