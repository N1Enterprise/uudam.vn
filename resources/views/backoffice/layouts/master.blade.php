<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
		<title>{{ __($APP_NAME) }}</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="app-locale" content="{{ \App::currentLocale() }}">
		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
		<script>
			WebFont.load({
                google: {"families":["Poppins:300,400,500,600,700"]},
                active: function() {
                    sessionStorage.fonts = true;
                }
            });
        </script>
		<!--end::Web font -->

        @yield('style_datatable')
		@yield('style')
        @stack('style_pages')

        <!--begin::Page Vendors Styles -->
		<link href="{{ asset('backoffice/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/css/main.css') }}" rel="stylesheet" type="text/css" />
        <!--end::Page Vendors Styles -->

        <!--begin:: Global Mandatory Vendors -->
		<link href="{{ asset('backoffice/assets/vendors/general/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css" />
		<!--end:: Global Mandatory Vendors -->

        <!--begin:: Global Optional Vendors -->
		<link href="{{ asset('backoffice/assets/vendors/general/tether/dist/css/tether.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/vendors/general/bootstrap-timepicker/css/bootstrap-timepicker.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/vendors/custom/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/vendors/general/bootstrap-select/dist/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/vendors/general/nouislider/distribute/nouislider.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/vendors/general/owl.carousel/dist/assets/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/vendors/general/owl.carousel/dist/assets/owl.theme.default.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/vendors/general/dropzone/dist/dropzone.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/vendors/general/summernote/dist/summernote.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/vendors/general/bootstrap-markdown/css/bootstrap-markdown.min.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/vendors/general/animate.css/animate.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/vendors/general/toastr/build/toastr.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/vendors/general/morris.js/morris.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/vendors/general/sweetalert2/dist/sweetalert2.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/vendors/general/socicon/css/socicon.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/vendors/custom/vendors/line-awesome/css/line-awesome.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/vendors/custom/vendors/flaticon/flaticon.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/vendors/custom/vendors/flaticon2/flaticon.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/vendors/custom/vendors/fontawesome5/css/all.min.css') }}" rel="stylesheet" type="text/css" />
		<!--end:: Global Optional Vendors -->

        <!--begin::Global Theme Styles -->
		<link href="{{ asset('backoffice/assets/demo/default/base/style.bundle.css?v=4195752989') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles -->

		<!--begin::Layout Skins -->
		<link href="{{ asset('backoffice/assets/demo/default/skins/header/base/light.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/demo/default/skins/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/demo/default/skins/brand/navy.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('backoffice/assets/demo/default/skins/aside/navy.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Layout Skins -->
		<link rel="shortcut icon" href="{{ asset('backoffice/assets/img/logos/stevephamhi_favicon.png') }}" />
    </head>

    <body class="k-header--fixed k-header-mobile--fixed k-aside--enabled k-aside--fixed">
        <!-- begin:: Header Mobile -->
		<div id="k_header_mobile" class="k-header-mobile  k-header-mobile--fixed ">
			<div class="k-header-mobile__logo">
				<a href="{{ route('bo.web.dashboard') }}">
					<img alt="Logo" src="{{ asset('backoffice/assets/img/logos/stevephamhi_logo.png') }}" style="max-width: 100%; padding-right: 8px; max-height:50px" />
				</a>
			</div>
			<div class="k-header-mobile__toolbar">
				<button class="k-header-mobile__toolbar-toggler k-header-mobile__toolbar-toggler--left" id="k_aside_mobile_toggler"><span></span></button>
				<button class="k-header-mobile__toolbar-topbar-toggler" id="k_header_mobile_topbar_toggler"><i class="flaticon-more"></i></button>
			</div>
		</div>
		<!-- end:: Header Mobile -->

        <!-- start:: Page -->
        <div class="k-grid k-grid--hor k-grid--root">
            <div class="k-grid__item k-grid__item--fluid k-grid k-grid--ver k-page">
                <button class="k-aside-close " id="k_aside_close_btn">
                    <i class="la la-close"></i>
                </button>

                <div class="k-aside  k-aside--fixed k-grid__item k-grid k-grid--desktop k-grid--hor-desktop" id="k_aside">
					<div class="k-aside__brand	k-grid__item " id="k_aside_brand">
						<div class="k-aside__brand-logo">
							<a href="{{ route('bo.web.dashboard') }}">
								<img alt="Logo" src="{{ asset('backoffice/assets/img/logos/stevephamhi_login_logo.png') }}" style="max-width: 100%; padding-right: 8px" />
							</a>
						</div>
						<div class="k-aside__brand-tools">
							<button class="k-aside__brand-aside-toggler k-aside__brand-aside-toggler--left" id="k_aside_toggler"><span></span></button>
						</div>
					</div>

					@include('backoffice.includes.left_menu')
                </div>

                <div class="k-grid__item k-grid__item--fluid k-grid k-grid--hor k-wrapper" id="k_wrapper">

					<!-- begin:: Header -->
					<div id="k_header" class="k-header k-grid__item  k-header--fixed ">

						<!-- begin: Header Menu -->
						<button class="k-header-menu-wrapper-close" id="k_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
						<div class="k-header-menu-wrapper">
							<div id="k_header_menu" class="k-header-menu k-header-menu-mobile d-none">
								<ul class="k-menu__nav">
									<li class="k-menu__item  k-menu__item--submenu k-menu__item--rel" data-kmenu-submenu-toggle="click">
										<a href="javascript:;" class="k-menu__link k-menu__toggle">
											<span class="k-menu__link-text" id="currentOffsetUTCLabel">GMT+00:00</span>
										</a>
										<div class="k-menu__submenu k-menu__submenu--classic k-menu__submenu--left w-auto">
											<ul class="k-menu__subnav p-0 k-scroll ps" id="utcOffsets"
											data-scroll="true"
											data-height="160" data-mobile-height="128" style="height: 160px; overflow: hidden;"
											>
											</ul>
										</div>
									</li>
								</ul>
							</div>
						</div>
						<!-- end: Header Menu -->

						<!-- begin:: Header Topbar -->
						<div class="k-header__topbar">
                            @include('backoffice.notifications.index')

							<!--begin: User bar -->
							<div class="k-header__topbar-item k-header__topbar-item--user">
								<div class="k-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px -2px">
									<div class="k-header__topbar-user">
										<span class="k-header__topbar-welcome k-hidden-mobile">{{__('Hi')}},</span>
										<span class="k-header__topbar-username k-hidden-mobile">{{ $AUTHENTICATED_USER->name }}</span>
										<img alt="Pic" src="{{ asset('backoffice/assets/img/users/ninja.png') }}" />
									</div>
								</div>
								<div class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-md">
									<div class="k-user-card k-margin-b-50 k-margin-b-30-tablet-and-mobile" style="">
										<div class="k-user-card__wrapper">
											<div class="k-user-card__pic">
												<img alt="Pic" src="{{ asset('backoffice/assets/img/users/ninja.png') }}" />
											</div>
											<div class="k-user-card__details">
												<div class="k-user-card__name">{{ $AUTHENTICATED_USER->name }}</div>
											</div>
										</div>
									</div>
									<ul class="k-nav k-margin-b-10">
										<li class="k-nav__item">
											<a href="javascript:;" data-toggle="modal" data-target="#userProfileModal" class="k-nav__link">
												<span class="k-nav__link-icon"><i class="flaticon2-calendar-3"></i></span>
												<span class="k-nav__link-text">{{__('My Profile')}}</span>
											</a>
										</li>
										<li class="k-nav__item k-nav__item--custom k-margin-t-15">
                                            <form method="post" action="{{ route('logout') }}" class="inline">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-metal btn-hover-brand btn-upper btn-font-dark btn-sm btn-bold">{{ __('Sign Out') }}</button>
                                            </form>
										</li>
									</ul>
								</div>
							</div>
							<!--end: User bar -->
						</div>
						<!-- end:: Header Topbar -->
					</div>
					<!-- end:: Header -->

					<!-- begin:: Content -->
					<div class="k-content	k-grid__item k-grid__item--fluid k-grid k-grid--hor" id="k_content">
						<!-- begin:: Content Head -->
						<div class="k-content__head	k-grid__item">
							<div class="k-content__head-main">
								<h3 class="k-content__head-title">@yield('header')</h3>
								@yield('breadcrumb')
							</div>
						</div>

						<!-- end:: Content Head -->

						<!-- begin:: Content Body -->
						@yield('content_body')
						@stack('modals')
						<!-- end:: Content Body -->
					</div>

					<!-- end:: Content -->

					<!-- begin:: Footer -->
                    @include('backoffice.includes.footer')
					<!-- end:: Footer -->
				</div>
            </div>
        </div>
        <!-- end:: Page -->

        <!-- begin::Scrolltop -->
		<div id="k_scrolltop" class="k-scrolltop">
			<i class="la la-arrow-up"></i>
		</div>
        <!-- end::Scrolltop -->

        @include('backoffice.layouts.parials.modal-user-profile')

        @include('backoffice.layouts.js.master-script')

        <!--begin:: Global Mandatory Vendors -->
        <script src="{{ asset('backoffice/js/vendors/jquery.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/popper.js/dist/umd/popper.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/js/vendors/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('backoffice/assets/vendors/general/js-cookie/src/js.cookie.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/moment/min/moment.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/tooltip.js/dist/umd/tooltip.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/sticky-js/dist/sticky.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/wnumb/wNumb.js') }}" type="text/javascript"></script>
        <!--end:: Global Mandatory Vendors -->

        <!--begin:: Global Optional Vendors -->
        <script src="{{ asset('backoffice/assets/vendors/general/jquery-form/dist/jquery.form.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/block-ui/jquery.blockUI.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/custom/theme/framework/vendors/bootstrap-datepicker/init.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/custom/theme/framework/vendors/bootstrap-timepicker/init.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/custom/bootstrap-daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/bootstrap-maxlength/src/bootstrap-maxlength.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/custom/vendors/bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/typeahead.js/dist/typeahead.bundle.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/inputmask/dist/jquery.inputmask.bundle.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/inputmask/dist/inputmask/inputmask.date.extensions.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/inputmask/dist/inputmask/inputmask.numeric.extensions.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/inputmask/dist/inputmask/inputmask.phone.extensions.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/nouislider/distribute/nouislider.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/owl.carousel/dist/owl.carousel.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/autosize/dist/autosize.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/clipboard/dist/clipboard.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/dropzone/dist/dropzone.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/summernote/dist/summernote.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/markdown/lib/markdown.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/bootstrap-markdown/js/bootstrap-markdown.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/custom/theme/framework/vendors/bootstrap-markdown/init.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/jquery-validation/dist/jquery.validate.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/jquery-validation/dist/additional-methods.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/custom/theme/framework/vendors/jquery-validation/init.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/toastr/build/toastr.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/raphael/raphael.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/morris.js/morris.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/chart.js/dist/Chart.bundle.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/custom/vendors/bootstrap-session-timeout/dist/bootstrap-session-timeout.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/custom/vendors/jquery-idletimer/idle-timer.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/waypoints/lib/jquery.waypoints.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/counterup/jquery.counterup.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/es6-promise-polyfill/promise.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/sweetalert2/dist/sweetalert2.min.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/custom/theme/framework/vendors/sweetalert2/init.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/jquery.repeater/src/lib.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/jquery.repeater/src/jquery.input.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/assets/vendors/general/jquery.repeater/src/repeater.js') }}" type="text/javascript"></script>
        <!--end:: Global Optional Vendors -->

        <!--begin::Global Theme Bundle -->
		<script src="{{ asset('backoffice/assets/demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>
		<!--end::Global Theme Bundle -->

        <!--begin::Page Vendors -->
		<script src="{{ asset('backoffice/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/js/common/constant.js') }}" type="text/javascript"></script>
        <script src="{{ asset('backoffice/js/common/fscommon.js') }}" type="text/javascript"></script>
		<script src="{{ asset('backoffice/js/components/slick.js') }}" type="text/javascript"></script>
		<!--end::Page Vendors -->

        @yield('js_datatable')
		@yield('js_script')
		@stack('js_pages')
    </body>
</html>
