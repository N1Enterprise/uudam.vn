<div class="collection-hero color-background-1 gradient">
    @if(! empty(data_get($collection, 'cover_image')))
    <div class="collection-hero__inner page-width" style="margin-top: 2.5rem;">
        <img srcset="{{ data_get($collection, 'cover_image') }}" src="{{ data_get($collection, 'cover_image') }}" alt="{{ data_get($collection, 'name') }}" style="width: 100%; height: 250px; object-fit: cover;">
    </div>
    @endif

    <div class="collection-hero__inner page-width">
        <div class="collection-hero__text-wrapper">
            <h1 class="collection-hero__title">
                <span class="visually-hidden">Collection: </span>{{ data_get($collection, 'name') }}
            </h1>
            <div class="collection-hero__description rte read_more_span">
                {!! data_get($collection, 'description') !!}
            </div>
            <button id="btnreadmore" class="read_more_btn button button--secondary" style="display: block;">Xem Thêm</button>
        </div>
    </div>
</div>
