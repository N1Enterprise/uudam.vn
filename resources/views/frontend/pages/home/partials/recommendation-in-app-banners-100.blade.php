<div class="slider-mobile-gutter" style="margin: 0 9px;">
    <div class="owl-carousel owl-theme multicolumn-list contains-content-container grid grid--1-col-tablet-down grid--3-col-desktop slider slider--mobile grid--peek" data-owl-id="Slider_In_App_Banner_100_{{ data_get($item, 'id') }}" data-owl-items="1">
        @foreach (data_get($item, 'linked_items', []) as $linkedItem)
        <div data-recommendation-in-app-banner-100-identifier="{{ $linkedItem }}" class="in-app-banner-wrapper">
            <a href="/" class="a-prevent">
                <img width="1815" height="300" class="image-lazy" srcset="{{ asset_with_version('frontend/assets/images/shared/skeleton-banner-100.webp') }}" src="{{ asset_with_version('frontend/assets/images/shared/skeleton-post.webp') }}" sizes="(min-width: 1600px) 750px, (min-width: 750px) calc((100vw - 130px) / 2), calc((100vw - 50px) / 2)" alt="Ưu đàm bài viết" class="motion-reduce" loading="lazy">
            </a>
        </div>
        @endforeach
    </div>
</div>
