@php
    $inventory = optional($menu->inventory);
@endphp

<li data-menu-type="inventory" data-menu-id="{{ $menu->id }}">
    <div class="mm-list-image">
        <a data-href="{{ route('fe.web.products.show', $inventory->slug) }}" href="{{ route('fe.web.products.show', $inventory->slug) }}" aria-label="{{ data_get($menu, 'name') }}">
            <img data-src="{{ data_get($inventory, 'image') }}" src="{{ data_get($inventory, 'image') }}" class="get-product-image mmLs-is-cached mmLazyloaded" data-id="4441599049861" aspect-ratio="1" style="border-radius: 50%; overflow: hidden;">
        </a>
    </div>
    <div class="mm-list-info">
        <a data-href="{{ route('fe.web.products.show', $inventory->slug) }}" href="{{ route('fe.web.products.show', $inventory->slug) }}" aria-label="{{ data_get($menu, 'name') }}" class="mm-product-name">
            <span class="mm-title">{{ data_get($menu, 'name') }}</span>
        </a>
        <div class="mega-menu-prices ">
            <span class="mega-menu-price">
                <span class="money">{{ format_price($inventory->sale_price) }}</span>
            </span>
        </div>
        <div class="mm-add-to-cart">
            <div varid="{{ data_get($inventory, 'id') }}" sellingplan="">Thêm Vào Giỏ Hàng</div>
        </div>
    </div>
</li>
