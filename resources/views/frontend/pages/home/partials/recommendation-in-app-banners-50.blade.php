<div class="slider-mobile-gutter">
    <div class="owl-carousel owl-theme multicolumn-list contains-content-container grid grid--1-col-tablet-down grid--3-col-desktop slider slider--mobile grid--peek" data-owl-id="Slider_In_App_Banner_50_{{ data_get($item, 'id') }}" data-owl-items="2">
        @foreach (data_get($item, 'linked_items') as $linkedItem)
        <div data-recommendation-in-app-banner-50-identifier="{{ $linkedItem }}" class="in-app-banner-wrapper" style="display: block; margin: 0 5px;">
            <div class="a-prevent">
                <img width="900" height="400" class="image-lazy" srcset="{{ asset_with_version('frontend/assets/images/shared/skeleton-banner-50.webp') }}" src="{{ asset_with_version('frontend/assets/images/shared/skeleton-post.webp') }}" sizes="(min-width: 1600px) 750px, (min-width: 750px) calc((100vw - 130px) / 2), calc((100vw - 50px) / 2)" alt="Ưu đàm bài viết" class="motion-reduce" loading="lazy" width="1815" height="150">
            </div>
        </div>
        @endforeach
    </div>
</div>
