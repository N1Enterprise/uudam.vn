@php
    $post = optional(data_get($menu, 'post'));
@endphp

<div data-menu-type="post">
    <div class="mega-menu-item-container">
        <div class="mm-image-container" style="height: 298px;">
            <div class="mm-image" style="width: 450px; height: 298.359px;">
                <a data-href="{{ route('fe.web.posts.index', data_get($post, 'slug')) }}" href="{{ route('fe.web.posts.index', data_get($post, 'slug')) }}">
                    <img data-src="{{ data_get($post, 'image') }}" alt="{{ data_get($menu, 'name', data_get($post, 'name', 'menu item')) }}" src="{{ data_get($post, 'image') }}" aspect-ratio="1.9132569558101473" class="get-article-image mmLs-is-cached mmLazyloaded" data-id="587642110202"></a>
                </div>
            <div class="mm-label-wrap" style="width: 450px; height: 298.359px;"></div>
        </div>
        <a data-href="{{ route('fe.web.posts.index', data_get($post, 'slug')) }}" href="{{ route('fe.web.posts.index', data_get($post, 'slug')) }}" class="mm-featured-title" style="min-height: 18px;">
            <span class="mm-title">
                {{ data_get($menu, 'label', data_get($post, 'name')) }}
                @if(data_get($menu, 'is_new'))
                <span class="mm-label new">MỚI</span>
                @endif
            </span>
        </a>
        <div class="mega-menu-prices get-mega-menu-prices" data-id="{{ data_get($post, 'id') }}" style="height: 0px;"></div>
    </div>
</div>
