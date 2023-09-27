@extends('frontend.layouts.master')

@push('style_pages')
<link rel="stylesheet" href="{{ asset('backoffice/assets/vendors/general/slick/slick.css') }}">
<link rel="stylesheet" href="{{ asset('backoffice/assets/vendors/general/slick/slick-theme.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/pages/home/index.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/common/component-slider.css') }}">
@endpush

@section('content_body')
    @include('frontend.pages.home.parials.section-banner')
@endsection

@push('js_pages')
<script src="{{ asset('backoffice/assets/vendors/general/slick/slick.min.js') }}" type="text/javascript"></script>
<script>
    $('.home-banner__slick').slick({
        autoplay: true,
    });

    onNavigateBanner();

    function onNavigateBanner() {
        $('.slider-button.slider-button--prev').on('click', function() {
            $('.slick-prev.slick-arrow').trigger('click');
        });

        $('.slider-button.slider-button--next').on('click', function() {
            $('.slick-next.slick-arrow').trigger('click');
        });
    }
</script>
@endpush
