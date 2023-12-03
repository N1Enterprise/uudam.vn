@extends('frontend.layouts.master')

{{-- @section('page_title')
404 Not Found
@endsection --}}

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
        <p>403</p>
        <h1 class="title">Vui lòng đăng nhập!</h1>
        <a href="?overlay=signin" class="button" data-overlay-action-button="signin">Đăng Nhập</a>
    </div>
</div>
@endsection
