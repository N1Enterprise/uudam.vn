@php
    $collection = optional(data_get($menu, 'collection'));
@endphp

<li data-menu-type="collection">
    <div class="mm-list-image">
        <a data-href="{{ route('fe.web.collections.index', data_get($collection, 'slug')) }}" href="{{ route('fe.web.collections.index', data_get($collection, 'slug')) }}" aria-label="{{ data_get($menu, 'name') }}">
            <img data-src="{{ data_get($collection, 'primary_image') }}" src="{{ data_get($collection, 'primary_image') }}"class="get-collection-image mmLs-is-cached mmLazyloaded" data-id="401408360698" aspect-ratio="1.5021418372203712" style="border-radius: 50%; overflow: hidden;">
        </a>
    </div>
    <div class="mm-list-info">
        <a data-href="{{ route('fe.web.collections.index', data_get($collection, 'slug')) }}" href="{{ route('fe.web.collections.index', data_get($collection, 'slug')) }}" aria-label="{{ data_get($menu, 'name') }}" class="mm-product-name">
            <span class="mm-title">
                {{ data_get($menu, 'label', data_get($collection, 'name')) }}
                @if(data_get($menu, 'is_new'))
                <span class="mm-label new">MỚI</span>
                @endif
            </span>
        </a>
        <div class="mega-menu-prices get-mega-menu-prices" data-id="{{ data_get($collection, 'id') }}"></div>
    </div>
</li>
