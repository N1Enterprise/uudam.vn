@extends('frontend.layouts.master')

@section('page_title')
@yield('page_title_news')
@endsection

@section('page_seo')
@yield('page_seo_news')
@endsection

@push('style_pages')
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/pages/news.min.css') }}">
@endpush

@section('content_body')
<section class="shopify-section section">
    <div class="news-section-wrapper page-width">
        <div class="news-aside">
            <div class="news-aside-categories" data-active-category="{{ data_get($postCategory, 'id') }}">
                <a href="{{ route('fe.web.news.index') }}" class="news-aside-categories__item {{ empty(data_get($postCategory, 'slug')) ? 'active' : '' }}">
                    <img src="{{ asset_with_version('frontend/assets/images/shared/app-logo.png') }}" alt="uudam.vn">
                    <span style="white-space: nowrap;">Trang chủ</span>
                </a>

                @if (! empty($postCategories))
                @foreach ($postCategories as $__postCategory)
                <a href="{{ route('fe.web.news.show-post-categories', data_get($__postCategory, 'slug')) }}" class="news-aside-categories__item {{ data_get($postCategory, 'slug') == data_get($__postCategory, 'slug') ? 'active' : '' }}">
                    <img src="{{ data_get($__postCategory, 'image') }}" alt="{{ data_get($__postCategory, 'name') }}">
                    <span style="white-space: nowrap;">{{ data_get($__postCategory, 'name') }}</span>
                </a>
                @endforeach
                @endif
            </div>
        </div>
        <div class="news-content">
            @yield('news_content')
        </div>
    </div>
</section>
@endsection

@push('js_pages')
<script src="{{ asset_with_version('frontend/bundle/js/news-index.min.js') }}"></script>
@endpush
