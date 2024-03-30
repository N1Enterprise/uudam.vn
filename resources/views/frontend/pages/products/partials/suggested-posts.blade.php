<div class="blog color-background-1 gradient">
    <div class="page-width section-template__main-padding">
        <div class="title-wrapper-with-link title-wrapper--self-padded-tablet-down title-wrapper--no-top-margin" style="margin-bottom: 10px;">
            <h2 class="blog__title h2">Bài Viết Liên Quan</h2>
        </div>
        <div class="slider-mobile-gutter">
            <div class="owl-carousel owl-theme blog__posts articles-wrapper contains-card contains-card--standard grid grid--peek grid--2-col-tablet grid--3-col-desktop slider slider--tablet" style="margin: 0 0;" data-owl-id="Inventory_Related_Post" data-owl-items="3">
                @foreach ($suggestedPosts as $post)
                <div class="blog__post article slider__slide slider__slide--full-width">
                    <div class="card-wrapper underline-links-hover">
                        <div class="card article-card card--standard card--media">
                            <div class="card__inner  color-background-2 gradient ratio">
                                <div class="article-card__image-wrapper card__media">
                                    <div class="article-card__image media media--hover-effect">
                                        <img srcset="{{ $post->image }}" src="{{ $post->image }}" sizes="(min-width: 1600px) 750px, (min-width: 750px) calc((100vw - 130px) / 2), calc((100vw - 50px) / 2)" alt="What Do You Think About All Day? - Koun Franz" class="motion-reduce" loading="lazy" width="2727" height="1818">
                                    </div>
                                </div>
                                <div class="card__content">
                                    <div class="card__information">
                                        <a href="{{ route('fe.web.posts.index', $post->slug) }}" class="full-unstyled-link">
                                            <h3 class="card__heading h2">{{ $post->name }}</h3>
                                        </a>
                                        <div class="article-card__info caption-with-letter-spacing h5">
                                            <span class="circle-divider">
                                                <time datetime="{{ $post->post_at }}">{{ format_datetime($post->post_at) }}</time>
                                            </span>
                                        </div>
                                        <p class="article-card__excerpt rte-width">{{ $post->description }}</p>
                                        <div class="article-card__footer"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card__content">
                                <div class="card__information">
                                    <a href="{{ route('fe.web.posts.index', $post->slug) }}" class="full-unstyled-link">
                                        <h3 class="card__heading h2">{{ $post->name }}</h3>
                                    </a>
                                    <div class="article-card__info caption-with-letter-spacing h5">
                                        <span class="circle-divider">
                                            <time datetime="{{ $post->post_at }}">{{ format_datetime($post->post_at) }}</time>
                                        </span>
                                    </div>
                                    <p class="article-card__excerpt rte-width">{{ $post->description }}</p>
                                    <div class="article-card__footer"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="slider-buttons no-js-hidden medium-hide">
                <button data-owl-prev="Inventory_Related_Post" type="button" class="slider-button slider-button--prev" aria-label="Button Prev">
                    <svg focusable="false" class="icon icon-caret" viewBox="0 0 10 6">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor"></path>
                    </svg>
                </button>
                <button data-owl-next="Inventory_Related_Post" type="button" class="slider-button slider-button--next" name="next" aria-label="Button Next">
                    <svg focusable="false" class="icon icon-caret" viewBox="0 0 10 6">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
