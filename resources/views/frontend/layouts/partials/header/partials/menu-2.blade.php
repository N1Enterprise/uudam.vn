@php
    $inventory = data_get($menu, 'inventory');
@endphp

<li data-menu-type="inventory" data-menu-id="{{ data_get($menu, 'id') }}">
    <div class="mm-list-image">
        <a data-href="{{ route('fe.web.products.index', data_get($inventory, 'slug')) }}" href="{{ route('fe.web.products.index', data_get($inventory, 'slug')) }}" aria-label="{{ data_get($menu, 'name') }}">
            <img data-src="{{ data_get($inventory, 'image') }}" alt="{{ data_get($menu, 'name', 'menu item') }}" src="{{ data_get($inventory, 'image') }}" class="get-product-image mmLs-is-cached mmLazyloaded" data-id="4441599049861" aspect-ratio="1" style="border-radius: 50%; overflow: hidden;">
        </a>
    </div>
    <div class="mm-list-info">
        <a data-href="{{ route('fe.web.products.index', data_get($inventory, 'slug')) }}" href="{{ route('fe.web.products.index', data_get($inventory, 'slug')) }}" aria-label="{{ data_get($menu, 'name') }}" class="mm-product-name">
            <span class="mm-title">
                {{ data_get($menu, 'label', data_get($inventory, 'title')) }}
                @if(data_get($menu, 'is_new'))
                <span class="mm-label new">MỚI</span>
                @endif
            </span>
        </a>
        <div class="mega-menu-prices ">
            <span class="mega-menu-price">
                <span class="money">{{ format_price(data_get($inventory, 'final_price')) }}</span>
            </span>
        </div>
    </div>
</li>
