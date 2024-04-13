@extends('frontend.layouts.master')

@section('page_title')
404 không tìm thấy trang | {{ config('app.user_domain') }}
@endsection

@push('style_pages')
<style type="text/css">
    .template-404 .title + * {
        margin-top: 1rem;
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
        <div>
            <img src="https://cdn.uudam.vn/shared/others/404-khong-tim-thay-trang.jpg" alt="404 không tìm thấy trang này" style="width: 400px; height: auto;">
        </div>
        <h1 class="title">Trang không tồn tại!</h1>
        <span style="display: block;"><a href="{{ route('fe.web.home') }}" style="color: #025B50;">Uudam.vn</a> xin lỗi vì sự bất tiện này, có thể trang này hiện không còn hoạt động nữa,</span>
        <span style="display: block;"><a href="{{ route('fe.web.home') }}" style="color: #025B50;">Uudam</a> sẽ xem xét vấn đề đang xảy ra với bạn, Cảm ơn bạn rất nhiều 🙇🙇🙇</span>
        <a href="{{ route('fe.web.home') }}" class="button" style="margin-top: 20px;">Quay về trang chủ</a>
    </div>
</div>
@endsection
