<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
<title>
{{ get_static_page_seo_title('maintenance') }}
</title>
@foreach (data_get($SYSTEM_SETTING, 'page_settings.favicon', []) as $favicon)
<link rel="icon" type="image/png" sizes="{{ data_get($favicon, 'sizes') }}" href="{{ data_get($favicon, 'image') }}">
@endforeach
{!! generate_static_page_seo_html('maintenance') !!}
<link rel="stylesheet" id="flatsome-main-css" href="{{ asset_with_version('frontend/bundle/css/maintenance-index.min.css') }}" type="text/css" media="all">
<style id="custom-css" type="text/css">
.sticky-add-to-cart--active, #wrapper, #main, #main.dark {background-color: #025b50;}body {color: #fff;background-color: #025b50;overflow: hidden;}h1, h2, h3, h4, h5, h6, .heading-font {color: #faaf40;}a {color: #faaf40!important;}.link-pay {background: #fff;display: flex;justify-content: center;flex-direction: column;align-items: center;padding: 8px;width: 100%;border-radius: 3px;margin: 0 auto;}.master-image {width: 100%!important;}.allow-ip-button {padding: 4px 10px;background: #fff;border-radius: 3px;margin-top: 10px;font-weight: bold;color: #025b50!important;}
</style>
</head>
<body class="home page-template page-template-page-blank page-template-page-blank-php page page-id-18 theme-flatsome woo-variation-swatches wvs-behavior-blur wvs-theme-flatsome wvs-show-label lightbox nav-dropdown-has-arrow nav-dropdown-has-shadow nav-dropdown-has-border">
<div id="wrapper">
<main id="main">
<section class="section" id="section_827439329">
<div class="bg section-bg fill bg-fill bg-loaded">
<div class="effect-snow bg-effect fill no-click"></div>
</div>
<div class="section-content relative">
<div class="row" id="row-1785759987">
<div id="col-1646844837" class="col small-12 large-12">
<div class="col-inner">
<div id="text-304991508" class="text">
<h2 class="uppercase" style="text-align: center;">uudam handmade</h2>
<h3 class="thin-font" style="text-align: center;">
Website đang bảo trì!
</h3>
<div style="font-size: 14px; text-align: center;">
<span style="font-weight: bold;">Từ ngày <u>{{ ($maintenanceStartDate)->format('d/m/Y H:i') }}</u> đến ngày <u>{{ ($maintenanceEndDate)->format('d/m/Y H:i') }}</u></span>
</div>
@if ($isMaintenanceAllowIp)
<div style="font-size: 14px; text-align: center; display: flex; justify-content: center;">
<a href="{{ route('fe.web.home') }}" class="allow-ip-button">IP của bạn có thể truy cập vào trang chủ</a>
</div>
@endif
</div>
</div>
</div>
<div id="col-827608374" class="" style="padding: 4px 10px;">
<div class="col-inner text-center">
<marquee>
<p>
<b>Chuyên Cung Cấp Các Sản Phẩm Nến Bơ Thực Vật An Toàn Cho Sức Khỏe Và Nguyên Liệu Làm Nến.</b>
</p>
</marquee>
</div>
</div>
</div>
<div class="row align-center">
<div class="col-inner">
<div class="img has-hover x md-x lg-x y md-y lg-y" id="image_1998674865">
<div data-parallax-fade="true" data-parallax="-2" class="parallax-active">
<div data-animate="fadeInLeft" data-animated="true">
<div class="img-inner dark">
<img class="master-image" src="{{ asset('frontend/assets/images/shared/Banner-nenbo.jpg') }}" srcset="{{ asset('frontend/assets/images/shared/Banner-nenbo.jpg') }}" class="attachment-large size-large" alt="" decoding="async" loading="lazy">
</div>
</div>
</div>
</div>
</div>
<div style="padding: 0 15px;">
<a href="https://shope.ee/6Ke1BpR0Nw" class="link-pay" target="_blank">
<img src="{{ asset('frontend/assets/images/shared/shopee.png') }}" width="120" height="20" class="ux-logo-image block" style="height:40px;">
</a>
</div>
</div>
</div>
</section>
</main>
</div>
</body>
</html>
