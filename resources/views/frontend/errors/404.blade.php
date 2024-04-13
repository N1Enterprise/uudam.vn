@extends('frontend.layouts.master')

@section('page_title')
404 không tìm thấy trang | {{ config('app.user_domain') }}
@endsection

@push('style_pages')
<style type="text/css">
    .template-404 .title + * {
        margin-top: 1rem;
    }

    .template-404 .image-wrapper {
        width: 500px;
        margin: 0 auto;
    }

    .template-404 .title {
        margin-top: 0;
    }

    .template-404 {
        margin-top: 20px!important;
    }

    @media screen and (max-width: 600px) {
        .template-404 .image-wrapper {
            width: 100%;
        }

        .template-404 {
            margin-top: 0!important;
        }
    }

    @media screen and (min-width: 750px) {
        .template-404 .title + * {
            margin-top: 2rem;
        }
    }
</style>
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/pages/home.min.css') }}">
@endpush

@section('content_body')
<div id="shopify-section-template--16599720198394__main" class="shopify-section">
    <div class="template-404 page-width page-margin center">
        <div class="image-wrapper">
            <img src="https://cdn.uudam.vn/shared/others/404-khong-tim-thay-trang.jpg" alt="404 không tìm thấy trang này" style="width: 100%; height: auto;">
        </div>
        <h1 class="title">Trang không tồn tại!</h1>
        <span style="display: block;"><a href="{{ route('fe.web.home') }}" style="color: #025B50;">Uudam.vn</a> xin lỗi vì sự bất tiện này, trang này hiện không còn hoạt động,</span>
        <span style="display: block;"><a href="{{ route('fe.web.home') }}" style="color: #025B50;">Uudam</a> sẽ xem xét vấn đề đang xảy ra với bạn, cảm ơn bạn rất nhiều 🙇🙇🙇</span>
        <a href="{{ route('fe.web.home') }}" class="button" style="margin-top: 20px;">Quay về trang chủ</a>
    </div>
</div>
@endsection
