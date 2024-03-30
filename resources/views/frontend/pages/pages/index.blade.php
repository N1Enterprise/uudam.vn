@extends('frontend.layouts.master')

@section('page_title')
{{ data_get($page, 'name') }} | {{ config('app.user_domain') }}
@endsection

@section('page_seo')
{!! $page->toHtmlSEO() !!}
@endsection

@push('style_pages')
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/pages/page.min.css') }}">
@endpush

@section('content_body')
<section class="shopify-section section">
    <article class="article-template" itemscope itemtype="http://schema.org/BlogPosting">
        <header class="page-width page-width--narrow">
            <h1 class="article-template__title" itemprop="headline">{{ $page->title }}</h1>
            <span class="circle-divider caption-with-letter-spacing" itemprop="dateCreated pubdate datePublished">
                <span>Cập nhật lần cuối vào lúc: </span>
                <time datetime="{{ $page->updated_at }}">{{ format_datetime($page->updated_at) }}</time>
            </span>
        </header>
        <div class="article-template__social-sharing page-width page-width--narrow">
            <share-button class="share-button">
                <button class="share-button__button hidden">
                    <svg width="13" height="12" viewBox="0 0 13 12" class="icon icon-share" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                        <path d="M1.625 8.125V10.2917C1.625 10.579 1.73914 10.8545 1.9423 11.0577C2.14547 11.2609 2.42102 11.375 2.70833 11.375H10.2917C10.579 11.375 10.8545 11.2609 11.0577 11.0577C11.2609 10.8545 11.375 10.579 11.375 10.2917V8.125" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.14775 1.27137C6.34301 1.0761 6.65959 1.0761 6.85485 1.27137L9.56319 3.9797C9.75845 4.17496 9.75845 4.49154 9.56319 4.6868C9.36793 4.88207 9.05135 4.88207 8.85609 4.6868L6.5013 2.33203L4.14652 4.6868C3.95126 4.88207 3.63468 4.88207 3.43942 4.6868C3.24415 4.49154 3.24415 4.17496 3.43942 3.9797L6.14775 1.27137Z" fill="currentColor"></path>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.5 1.125C6.77614 1.125 7 1.34886 7 1.625V8.125C7 8.40114 6.77614 8.625 6.5 8.625C6.22386 8.625 6 8.40114 6 8.125V1.625C6 1.34886 6.22386 1.125 6.5 1.125Z" fill="currentColor"></path>
                    </svg> Share </button>
                <details>
                    <summary class="share-button__button" role="button" aria-expanded="false" aria-controls="Article-share-template--16599720231162__main">
                        <svg width="13" height="12" viewBox="0 0 13 12" class="icon icon-share" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                            <path d="M1.625 8.125V10.2917C1.625 10.579 1.73914 10.8545 1.9423 11.0577C2.14547 11.2609 2.42102 11.375 2.70833 11.375H10.2917C10.579 11.375 10.8545 11.2609 11.0577 11.0577C11.2609 10.8545 11.375 10.579 11.375 10.2917V8.125" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.14775 1.27137C6.34301 1.0761 6.65959 1.0761 6.85485 1.27137L9.56319 3.9797C9.75845 4.17496 9.75845 4.49154 9.56319 4.6868C9.36793 4.88207 9.05135 4.88207 8.85609 4.6868L6.5013 2.33203L4.14652 4.6868C3.95126 4.88207 3.63468 4.88207 3.43942 4.6868C3.24415 4.49154 3.24415 4.17496 3.43942 3.9797L6.14775 1.27137Z" fill="currentColor"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.5 1.125C6.77614 1.125 7 1.34886 7 1.625V8.125C7 8.40114 6.77614 8.625 6.5 8.625C6.22386 8.625 6 8.40114 6 8.125V1.625C6 1.34886 6.22386 1.125 6.5 1.125Z" fill="currentColor"></path>
                        </svg> Share
                    </summary>
                    <div class="share-button__fallback motion-reduce">
                        <div class="field">
                            <span class="share-button__message hidden" role="status"></span>
                            <input type="text" class="field__input" id="url" value="{{ route('fe.web.pages.index', $page->slug) }}" placeholder="Link" onclick="this.select();" readonly="">
                            <label class="field__label" for="url">Link</label>
                        </div>
                        <button class="share-button__close hidden no-js-hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" role="presentation" class="icon icon-close" fill="none" viewBox="0 0 18 17">
                                <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor"></path>
                            </svg>
                            <span class="visually-hidden">Close share</span>
                        </button>
                        <button class="share-button__copy no-js-hidden">
                            <svg class="icon icon-clipboard" width="11" height="13" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" viewBox="0 0 11 13">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2 1a1 1 0 011-1h7a1 1 0 011 1v9a1 1 0 01-1 1V1H2zM1 2a1 1 0 00-1 1v9a1 1 0 001 1h7a1 1 0 001-1V3a1 1 0 00-1-1H1zm0 10V3h7v9H1z" fill="currentColor"></path>
                            </svg>
                            <span class="visually-hidden">Copy link</span>
                        </button>
                    </div>
                </details>
            </share-button>
        </div>
        <div class="article-template__content page-width page-width--narrow rte contentview" itemprop="articleBody">
            {!! $page->content !!}
        </div>
        <div class="article-template__back element-margin-top center">

            @if(request()->viewfrom == 'checkout')
            <a href="{{ route('fe.web.user.checkout.confirmation') }}" data-backto="{{ route('fe.web.user.checkout.confirmation') }}" class="article-template__link link animate-arrow">
                <span class="icon-wrap">
                    <svg viewBox="0 0 14 10" fill="none" aria-hidden="true" focusable="false" role="presentation" class="icon icon-arrow" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.537.808a.5.5 0 01.817-.162l4 4a.5.5 0 010 .708l-4 4a.5.5 0 11-.708-.708L11.793 5.5H1a.5.5 0 010-1h10.793L8.646 1.354a.5.5 0 01-.109-.546z" fill="currentColor"></path>
                    </svg>
                </span>
                Trở lại trang thanh toán
            </a>
            @else
            <a href="{{ route('fe.web.home') }}" class="article-template__link link animate-arrow">
                <span class="icon-wrap">
                    <svg viewBox="0 0 14 10" fill="none" aria-hidden="true" focusable="false" role="presentation" class="icon icon-arrow" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.537.808a.5.5 0 01.817-.162l4 4a.5.5 0 010 .708l-4 4a.5.5 0 11-.708-.708L11.793 5.5H1a.5.5 0 010-1h10.793L8.646 1.354a.5.5 0 01-.109-.546z" fill="currentColor"></path>
                    </svg>
                </span>
                Trở lại trang chủ
            </a>
            @endif
        </div>
    </article>
</section>
@endsection

@section('js_script')
<script>
    $('[data-backto]').on('click', function(e) {
        e.preventDefault();

        window.close();
        window.open($(this).attr('href'), '_blank');
    });
</script>
@endsection
