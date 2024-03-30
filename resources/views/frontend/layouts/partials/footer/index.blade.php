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
                        <div class="footer__block" data-type="contact">
                            <div class="footer__mobile-section">
                                <div class="footer__blocks--mobile">
                                    <div class="footer__block--mobile">
                                        <h2 class="footer__title">Tổng đài hỗ trợ</h2>
                                        <ul class="footer__menu footer__menu--underline">
                                            <li style="display: flex; align-items: center;">
                                                <span style="display: block; color: #000; margin-right: 5px; flex: 0 0 52px;">SĐT 1: </span>
                                                <a href="tel:{{ text_without_spaces(data_get($SYSTEM_SETTING, 'page_settings.phone_support.phone')) }}" style="color: #2f80ed; font-weight: bold;">{{ data_get($SYSTEM_SETTING, 'page_settings.phone_support.phone') }}</a>
                                                <span style="color: #000; margin-left: 5px;">(24/7)</span>
                                            </li>
                                            <li style="display: flex; align-items: center;">
                                                <span style="display: block; color: #000; margin-right: 5px; flex: 0 0 52px;">SĐT 2: </span>
                                                <a href="tel:{{ text_without_spaces(data_get($SYSTEM_SETTING, 'page_settings.backup_phone_support.phone')) }}" style="color: #2f80ed; font-weight: bold;">{{ data_get($SYSTEM_SETTING, 'page_settings.backup_phone_support.phone') }}</a>
                                                <span style="color: #000; margin-left: 5px;">(24/7)</span>
                                            </li>
                                            <li style="display: flex; align-items: center;">
                                                <span style="display: block; color: #000; margin-right: 5px; flex: 0 0 52px;">Zalo: </span>
                                                <a href="https://zalo.me/{{ text_without_spaces(data_get($SYSTEM_SETTING, 'page_settings.phone_zalo.phone')) }}" target="_blank" style="color: #2f80ed; font-weight: bold;">{{ data_get($SYSTEM_SETTING, 'page_settings.phone_zalo.phone') }}</a>
                                                <span style="color: #000; margin-left: 5px;">(24/7)</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer__section">
            <div class="page-width text-center small--text-left" style="text-align: center;">
                <div class="section-content-template">
                    <div class="footer__base-links" style="color: #000;">
                        <span style="padding: 0; margin: 0;"> © {{ now()->year }} {{ data_get($SYSTEM_SETTING, 'page_settings.app_name') }} | <b>{{ data_get($SYSTEM_SETTING, 'business_information.full_name') }}</b>, MST <b>{{ data_get($SYSTEM_SETTING, 'business_information.tax_code') }}</b>, địa chỉ tại <b>{{ data_get($SYSTEM_SETTING, 'business_information.address') }}</b></span>
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
