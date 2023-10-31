@extends('frontend.layouts.master')

@section('page_title')
404 Not Found - {{ $APP_NAME }}
@endsection

@section('page_title')
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
@endsection

@section('content_body')
<div id="shopify-section-template--16599720198394__main" class="shopify-section">
    <div class="template-404 page-width page-margin center">
        <p>404</p>
        <h1 class="title">Trang không tồn tại!</h1>
        <a href="{{ route('fe.web.home') }}" class="button">Tiếp tục mua sắm</a>
    </div>
</div>
@endsection
