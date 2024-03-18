<div id="shopify-section-sections--16783368323330__footer" class="shopify-section shopify-section-group-footer-group">
    <div id="FooterMobileNavWrap" class="footer__section footer__section--border medium-up--hide hide">
        <div id="FooterMobileNav" class="page-width"></div>
    </div>
    <footer class="site-footer" data-section-id="sections--16783368323330__footer" data-section-type="footer-section">
        <div id="FooterMenus" class="footer__section footer__section--menus">
            <div class="page-width">
                <div class="footer__blocks">
                    @foreach (data_get($SYSTEM_SETTING, 'footer_menus') as $item)
                    <div class="footer__block" data-type="menu">
                        <h2 class="footer__title">{{ data_get($item, 'group') }}</h2>
                        <ul class="footer__menu">
                            @foreach (data_get($item, 'menus', []) as $menu)
                            <li>
                                <a href="{{ data_get($menu, 'url') }}">{{ data_get($menu, 'name') }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>    
                    @endforeach
                    <div class="footer__block" data-type="contact">
                        <div class="footer__mobile-section">
                            <div class="footer__blocks--mobile">
                                <div class="footer__block--mobile">
                                    <h2 class="footer__title">Thông tin liên hệ</h2>
                                    <ul class="footer__menu footer__menu--underline">
                                        <li>
                                            <a href="tel:{{ data_get($SYSTEM_SETTING, 'page_settings.phone_support.phone') }}" target="_blank">
                                                <span class="icon-and-text">
                                                    <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-phone" viewBox="0 0 64 64">
                                                        <path d="m18.4 9.65 10.2 10.2-6.32 6.32c2.1 7 6.89 12.46 15.55 15.55l6.32-6.32 10.2 10.2-8.75 8.75C25.71 50.3 13.83 38.21 9.65 18.4Z"></path>
                                                    </svg>
                                                    <span>{{ data_get($SYSTEM_SETTING, 'page_settings.phone_support.phone') }}</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="mailto:{{ data_get($SYSTEM_SETTING, 'page_settings.email_support.value') }}" target="_blank">
                                                <span class="icon-and-text">
                                                    <svg class="icon icon-email" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="_x32_" viewBox="0 0 512 512" xml:space="preserve">
                                                        <g><path class="st0" d="M510.746,110.361c-2.128-10.754-6.926-20.918-13.926-29.463c-1.422-1.794-2.909-3.39-4.535-5.009   c-12.454-12.52-29.778-19.701-47.531-19.701H67.244c-17.951,0-34.834,7-47.539,19.708c-1.608,1.604-3.099,3.216-4.575,5.067   c-6.97,8.509-11.747,18.659-13.824,29.428C0.438,114.62,0,119.002,0,123.435v265.137c0,9.224,1.874,18.206,5.589,26.745   c3.215,7.583,8.093,14.772,14.112,20.788c1.516,1.509,3.022,2.901,4.63,4.258c12.034,9.966,27.272,15.45,42.913,15.45h377.51   c15.742,0,30.965-5.505,42.967-15.56c1.604-1.298,3.091-2.661,4.578-4.148c5.818-5.812,10.442-12.49,13.766-19.854l0.438-1.05   c3.646-8.377,5.497-17.33,5.497-26.628V123.435C512,119.06,511.578,114.649,510.746,110.361z M34.823,99.104   c0.951-1.392,2.165-2.821,3.714-4.382c7.689-7.685,17.886-11.914,28.706-11.914h377.51c10.915,0,21.115,4.236,28.719,11.929   c1.313,1.327,2.567,2.8,3.661,4.272l2.887,3.88l-201.5,175.616c-6.212,5.446-14.21,8.443-22.523,8.443   c-8.231,0-16.222-2.99-22.508-8.436L32.19,102.939L34.823,99.104z M26.755,390.913c-0.109-0.722-0.134-1.524-0.134-2.341V128.925   l156.37,136.411L28.199,400.297L26.755,390.913z M464.899,423.84c-6.052,3.492-13.022,5.344-20.145,5.344H67.244   c-7.127,0-14.094-1.852-20.142-5.344l-6.328-3.668l159.936-139.379l17.528,15.246c10.514,9.128,23.922,14.16,37.761,14.16   c13.89,0,27.32-5.032,37.827-14.16l17.521-15.253L471.228,420.18L464.899,423.84z M485.372,388.572   c0,0.803-0.015,1.597-0.116,2.304l-1.386,9.472L329.012,265.409l156.36-136.418V388.572z"/></g>
                                                    </svg>
                                                    <span>{{ data_get($SYSTEM_SETTING, 'page_settings.email_support.value') }}</span>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer__section">
            <div class="page-width text-center small--text-left" style="text-align: center; padding: 5px 0px;">
                <h4 style="color: #fff; font-weight: bold; margin: 0; padding: 10px;">{{ data_get($SYSTEM_SETTING, 'page_settings.legal_name') }}</h4>
                <div style="font-size: 14px; padding: 10px 0;">
                    <b>Địa chỉ:</b> <span>{{ data_get($SYSTEM_SETTING, 'page_settings.address.value') }}</span>
                </div>
                @if (data_get($SYSTEM_SETTING, 'page_settings.informed_moit.enable'))
                <a href="{{ data_get($SYSTEM_SETTING, 'page_settings.informed_moit.link') }}"  style="margin: 0; padding: 10px;">
                    <img src="{{ asset_with_version('frontend/assets/images/shared/bo-cong-thuong-informed.png') }}" alt="{{ data_get($SYSTEM_SETTING, 'page_settings.legal_name') }}" width="200">
                </a>
                @endif
            </div>
        </div>
        <div class="footer__section">
            <div class="page-width text-center small--text-left" style="text-align: center;">
                <div class="footer__base-links">
                    <span> © {{ now()->year }} {{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }} </span>
                    <span>|</span>
                    <a target="_blank" rel="nofollow" href="{{ data_get($SYSTEM_SETTING, 'page_settings.license.link') }}" class="js-no-transition">Được cung cấp bởi {{ data_get($SYSTEM_SETTING, 'page_settings.license.value') }}</a>
                </div>
            </div>
        </div>
    </footer>
</div>
@push('js_pages')
@if(data_get($SYSTEM_SETTING, 'receive_new_post_setting.enable'))
<script>
    $('#ContactFooter').on('submit', function(e) {
        e.preventDefault();

        const email = $(this).find('[name="contact[email]"]').val();

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: { email },
            success: () => {
                toastr.success("Đăng ký thành công.");
                $('#ContactFooter').find('[name="contact[email]"]').val('');
            },
            error: function (jqXHR, status, errorThrown) {
                toastr.error("Đăng ký không thành công.");
            },
        });
    });
</script>
@endif
@endpush
