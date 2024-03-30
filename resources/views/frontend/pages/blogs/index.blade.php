@extends('frontend.layouts.master')

@push('style_pages')
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/pages/page.min.css') }}">
@endpush

@section('page_seo')
{!! $blog->toHtmlSEO() !!}
@endsection

@section('content_body')
<section class="shopify-section section">
    <div class="main-blog page-width section-template__main-paddingg">
        <h1 class="title--primary">{{ data_get($blog, 'name') }}</h1>
        <div class="blog-articles blog-articles--collage">
            @if (has_data(data_get($blog, 'posts', [])))
                @foreach (data_get($blog, 'posts', []) as $post)
                <div class="blog-articles__article article">
                    <div class="card-wrapper underline-links-hover">
                        <div class="card article-card card--standard article-card__image--medium card--media" style="--ratio-percent: 66.66666666666666%;">
                            <div class="card__inner  color-background-2 gradient ratio" style="--ratio-percent: 66.66666666666666%;">
                                <div class="article-card__image-wrapper card__media">
                                    <div class="article-card__image media media--hover-effect">
                                        <img srcset="{{ data_get($post, 'image') }}" src="{{ data_get($post, 'image') }}" sizes="(min-width: 1600px) 750px, (min-width: 750px) calc((100vw - 130px) / 2), calc((100vw - 50px) / 2)" alt="{{ data_get($post, 'name') }}" class="motion-reduce" loading="lazy" width="2727" height="1818">
                                    </div>
                                </div>
                            </div>
                            <div class="card__content">
                                <div class="card__information">
                                    <h3 class="card__heading h2">
                                        <a href="{{ route('fe.web.posts.index', data_get($post, 'slug')) }}" class="full-unstyled-link"> {{ data_get($post, 'name') }} </a>
                                    </h3>
                                    <div class="article-card__info caption-with-letter-spacing h5">
                                        <span class="circle-divider">
                                            <time datetime="{{ data_get($post, 'post_at') }}">{{ format_datetime(data_get($post, 'post_at')) }}</time>
                                        </span>
                                    </div>
                                    <p class="article-card__excerpt rte-width">{{ data_get($post, 'description') }}</p>
                                    <div class="article-card__footer"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
        {{-- <div class="pagination-wrapper">
            <nav class="pagination" role="navigation">
                <ul class="pagination__list list-unstyled" role="list">
                    <li>
                        <a role="link" aria-disabled="true" class="pagination__item pagination__item--current light" aria-current="page">1</a>
                    </li>
                    <li>
                        <a href="/blogs/news?page=2" class="pagination__item link">2</a>
                    </li>
                    <li>
                        <a href="/blogs/news?page=3" class="pagination__item link>3</a>
                    </li>
                    <li>
                        <span class="pagination__item">…</span>
                    </li>
                    <li>
                        <a href="/blogs/news?page=43" class="pagination__item link">43</a>
                    </li>
                    <li>
                        <a href="/blogs/news?page=2" class="pagination__item pagination__item--prev pagination__item-arrow link motion-reduce">
                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-caret" viewBox="0 0 10 6">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.354.646a.5.5 0 00-.708 0L5 4.293 1.354.646a.5.5 0 00-.708.708l4 4a.5.5 0 00.708 0l4-4a.5.5 0 000-.708z" fill="currentColor"></path>
                            </svg>
                        </a>
                    </li>
                </ul>
            </nav>
        </div> --}}
    </div>
</section>
@endsection
