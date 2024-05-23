@extends('frontend.layouts.news')

@section('page_seo_news')
{!! generate_static_page_seo_html('news') !!}
@endsection

@section('news_content')
<div class="news-content__articles-wrapper">
    <h2 class="news-content__articles-heading">
        Đọc nhiều nhất
        <span class="border-cps"></span>
    </h2>
    <div class="news-content__articles-content" data-news-post="show-up">
        <div class="news-content__articles-item">
            <a class="articles-item__image" href="{{ request()->url() }}">
                <img src="{{ asset_with_version('frontend/assets/images/shared/skeleton-news-post.webp') }}" alt="uudam.vn" loading="lazy" width="300" height="300" style="color: transparent;">
            </a>
            <div class="articles-item__content">
                <a class="articles-item__content-heading" href="{{ request()->url() }}">
                    <h3 class="skeleton" style="margin-top: 5px; height: 30px; border-radius: 4px;"></h3>
                </a>
                <p class="articles-item__content-desc skeleton" style="margin-top: 10px; height: 50px; border-radius: 4px;"></p>
                <div class="articles-item__content-metadata">
                    <a class="articles-item__content-author" href="/sforum/author/quannguyen">
                        <span class="skeleton" style="width: 100px; border-radius: 4px;"></span>
                    </a>
                    <span class="articles-item__content-datetime">
                        <span class="skeleton" style="width: 100px; border-radius: 4px;"></span>
                    </span>
                </div>
            </div>
        </div>

        <div class="news-content__articles-item">
            <a class="articles-item__image" href="{{ request()->url() }}">
                <img src="{{ asset_with_version('frontend/assets/images/shared/skeleton-news-post.webp') }}" alt="uudam.vn" loading="lazy" width="300" height="300" style="color: transparent;">
            </a>
            <div class="articles-item__content">
                <a class="articles-item__content-heading" href="{{ request()->url() }}">
                    <h3 class="skeleton" style="margin-top: 5px; height: 30px; border-radius: 4px;"></h3>
                </a>
                <p class="articles-item__content-desc skeleton" style="margin-top: 10px; height: 50px; border-radius: 4px;"></p>
                <div class="articles-item__content-metadata">
                    <a class="articles-item__content-author" href="/sforum/author/quannguyen">
                        <span class="skeleton" style="width: 100px; border-radius: 4px;"></span>
                    </a>
                    <span class="articles-item__content-datetime">
                        <span class="skeleton" style="width: 100px; border-radius: 4px;"></span>
                    </span>
                </div>
            </div>
        </div>

        <div class="news-content__articles-item">
            <a class="articles-item__image" href="{{ request()->url() }}">
                <img src="{{ asset_with_version('frontend/assets/images/shared/skeleton-news-post.webp') }}" alt="uudam.vn" loading="lazy" width="300" height="300" style="color: transparent;">
            </a>
            <div class="articles-item__content">
                <a class="articles-item__content-heading" href="{{ request()->url() }}">
                    <h3 class="skeleton" style="margin-top: 5px; height: 30px; border-radius: 4px;"></h3>
                </a>
                <p class="articles-item__content-desc skeleton" style="margin-top: 10px; height: 50px; border-radius: 4px;"></p>
                <div class="articles-item__content-metadata">
                    <a class="articles-item__content-author" href="/sforum/author/quannguyen">
                        <span class="skeleton" style="width: 100px; border-radius: 4px;"></span>
                    </a>
                    <span class="articles-item__content-datetime">
                        <span class="skeleton" style="width: 100px; border-radius: 4px;"></span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="news-content__articles-loadmore d-none" data-news-post="pagination">
        <a href="" class="btn-loadmore" data-current-page="1" data-next-page="2" data-news-post="btn_load_more">
            <span class="text">Xem thêm</span>
        </a>
    </div>
</div>
@endsection
