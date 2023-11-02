@php
    $post = optional($menu->post);
@endphp

<div data-menu-type="post">
    <div class="mega-menu-item-container">
        <div class="mm-image-container" style="height: 298px;">
            <div class="mm-image" style="width: 570px; height: 298.359px;">
                <a data-href="{{ route('fe.web.posts.index', data_get($post, 'slug')) }}" href="{{ route('fe.web.posts.index', data_get($post, 'slug')) }}" aria-label="{{ data_get($menu, 'name', data_get($post, 'name')) }}">
                    <img data-src="{{ data_get($post, 'image') }}" src="{{ data_get($post, 'image') }}" aspect-ratio="1.9132569558101473" class="get-article-image mmLs-is-cached mmLazyloaded" data-id="587642110202"></a>
                </div>
            <div class="mm-label-wrap" style="width: 570px; height: 298.359px;"></div>
        </div>
        <a data-href="{{ route('fe.web.posts.index', data_get($post, 'slug')) }}" href="{{ route('fe.web.posts.index', data_get($post, 'slug')) }}" aria-label="{{ data_get($menu, 'name', data_get($post, 'name')) }}" class="mm-featured-title" style="min-height: 18px;">
            <span class="mm-title">{{ data_get($menu, 'name', data_get($post, 'name')) }}</span>
        </a>
        <div class="mega-menu-prices get-mega-menu-prices" data-id="{{ data_get($post, 'id') }}" style="height: 0px;"></div>
    </div>
</div>
