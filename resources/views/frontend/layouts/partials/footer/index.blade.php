<div id="shopify-section-sections--16783368323330__footer" class="shopify-section shopify-section-group-footer-group">
    <footer class="site-footer" data-section-id="sections--16783368323330__footer" data-section-type="footer-section">
        <div id="FooterMenus" class="footer__section footer__section--menus">
            <div class="page-width">
                <div class="section-content-template">
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
                        @if (
                            data_get($SYSTEM_SETTING, 'page_settings.phone_support.phone')
                            || data_get($SYSTEM_SETTING, 'page_settings.backup_phone_support.phone')
                        )
                        <div class="footer__block" data-type="contact">
                            <div class="footer__mobile-section">
                                <div class="footer__blocks--mobile">
                                    <div class="footer__block--mobile">
                                        <h2 class="footer__title">Tổng đài hỗ trợ</h2>
                                        <ul class="footer__menu footer__menu--underline">
                                            @if (data_get($SYSTEM_SETTING, 'page_settings.phone_support.phone'))
                                            <li style="display: flex; align-items: center;">
                                                <a href="tel:{{ text_without_spaces(data_get($SYSTEM_SETTING, 'page_settings.phone_support.phone')) }}" style="font-size: 17px; letter-spacing: 1.2px;">
                                                    {{ data_get($SYSTEM_SETTING, 'page_settings.phone_support.phone') }}
                                                    <small>(24/7)</small>
                                                </a>
                                            </li>
                                            @endif
                                            @if (data_get($SYSTEM_SETTING, 'page_settings.backup_phone_support.phone'))
                                            <li style="display: flex; align-items: center;">
                                                <a href="tel:{{ text_without_spaces(data_get($SYSTEM_SETTING, 'page_settings.backup_phone_support.phone')) }}" style="font-size: 17px; letter-spacing: 1.2px;">
                                                    {{ data_get($SYSTEM_SETTING, 'page_settings.backup_phone_support.phone') }}
                                                    <small>(24/7)</small>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="footer__section">
            <div class="page-width">
                <div class="company-footer-content">
                    <div class="company-footer-content-item company-detail-info">
                        <div class="section-content-template">
                            <div class="text-center small--text-left" style="text-align: left;">
                                <div class="section-content-template">
                                    <div class="footer__base-links">
                                        <div style="text-transform: uppercase; font-weight: bold;">{{ data_get($SYSTEM_SETTING, 'business_information.full_name') }}</div>
                                        <div style="text-decoration: none;">MST: {{ data_get($SYSTEM_SETTING, 'business_information.tax_code') }}</div>
                                        <div>Địa chỉ: {{ data_get($SYSTEM_SETTING, 'business_information.address') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="company-footer-content-item company-social-info">
                        <div class="section-content-template">
                            <div class="footer__blocks-custom-wrapper">
                                <div class="footer__block-custom fb-fanpage-wrapper" data-type="menu">
                                    <h2 class="footer__title">Facebook Fanpage</h2>
                                    <div class="footer__block-custom-content fb-fanpage">
                                        @include('frontend.layouts.partials.embed.fb-fanpage')
                                    </div>
                                </div>
                                <div class="footer__block-custom gg-map-wrapper" data-type="menu">
                                    <h2 class="footer__title">Bản Đồ</h2>
                                    <div class="footer__block-custom-content gg-map">
                                        @include('frontend.layouts.partials.embed.gg-map')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
