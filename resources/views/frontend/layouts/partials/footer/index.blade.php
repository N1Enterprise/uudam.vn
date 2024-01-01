<div class="shopify-section">
    <footer class="footer color-background-1 gradient section-footer-padding">
        <div class="footer__content-top page-width">
            <div class="footer__blocks-wrapper grid grid--1-col grid--2-col grid--4-col-tablet ">
                <div class="footer-block grid__item">
                    <h2 class="footer-block__heading">GIỚI THIỆU VỀ ƯU ĐÀM</h2>
                    <div class="footer-block__details-content rte">
                        <p>Ưu Đàm là công ty chuyên cung cấp các sản phẩm và nguyên vật liệu từ nến.</p>
                        <p>Nếu ưu đàm là sự kết hợp giữa Bơ Thực Vật nguyên chất và Sáp Ong tinh luyện. Nguyên liệu hoàn toàn tự nhiên, an toàn cho sức khỏe, không gây ra khói đen và cay mắt trong quá trình sử dụng. Việc thắp nến bơ cúng dường là phương pháp tẩy trừ sự tăm tối vô minh, tượng trưng cho ánh sáng của trí tuệ thông suốt của Đức Phật.</p>
                        <p>Cúng Dường và Dâng Phật nến bơ mang một ý nghĩa đặc biệt tích lũy được nhiều công đức vô lượng.</p>
                    </div>
                </div>
                <div class="footer-block grid__item footer-block--menu">
                    @if (has_data($FOOTER_PAGES))
                    <h2 class="footer-block__heading">MENU</h2>
                    <ul class="footer-block__details-content list-unstyled">
                        @foreach ($FOOTER_PAGES as $menu)
                        <li>
                            <a href="{{ route('fe.web.pages.index', data_get($menu, 'slug')) }}" class="link link--text list-menu__item list-menu__item--link">{{ data_get($menu, 'name') }}</a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
            <div class="footer-block--newsletter">
                <div class="footer-block__newsletter">
                    @if (data_get($SYSTEM_SETTING, 'receive_new_post_setting.enable'))
                    <h2 class="footer-block__heading">{{ data_get($SYSTEM_SETTING, 'receive_new_post_setting.title') }}</h2>
                    <p>{{ data_get($SYSTEM_SETTING, 'receive_new_post_setting.description') }}</p>
                    <form method="post" action="{{ route('fe.api.user.subscribe.news-letter') }}" id="ContactFooter" accept-charset="UTF-8"
                        class="footer__newsletter newsletter-form">
                        <div class="newsletter-form__field-wrapper">
                            <div class="field">
                                <input id="NewsletterForm--footer" type="email" name="contact[email]" class="field__input" value="" aria-required="true" autocorrect="off" autocapitalize="off" autocomplete="email" placeholder="Email" required>
                                <label class="field__label" for="NewsletterForm--footer">Email</label>
                                <button type="submit" class="newsletter-form__button field__button" name="commit" id="Subscribe" aria-label="Subscribe">
                                    <svg viewBox="0 0 14 10" fill="none" aria-hidden="true" focusable="false" role="presentation" class="icon icon-arrow" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.537.808a.5.5 0 01.817-.162l4 4a.5.5 0 010 .708l-4 4a.5.5 0 11-.708-.708L11.793 5.5H1a.5.5 0 010-1h10.793L8.646 1.354a.5.5 0 01-.109-.546z" fill="currentColor"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <h3 class="newsletter-form__message newsletter-form__message--success form__message d-none" id="ContactFooter-success" tabindex="-1" autofocus="">
                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-success" viewBox="0 0 13 13">
                                <path d="M6.5 12.35C9.73087 12.35 12.35 9.73086 12.35 6.5C12.35 3.26913 9.73087 0.65 6.5 0.65C3.26913 0.65 0.65 3.26913 0.65 6.5C0.65 9.73086 3.26913 12.35 6.5 12.35Z" fill="#428445" stroke="white" stroke-width="0.7"></path>
                                <path d="M5.53271 8.66357L9.25213 4.68197" stroke="white"></path>
                                <path d="M4.10645 6.7688L6.13766 8.62553" stroke="white"></path>
                            </svg>
                        </h3>
                    </form>

                    @endif
                </div>
                <ul class="footer__list-social list-unstyled list-social" role="list">
                    @foreach (data_get($SYSTEM_SETTING, 'social_networks', []) as $network)
                    <li class="list-social__item">
                        <a href="{{ data_get($network, 'link') }}" target="_blank" title="{{ data_get($network, 'tooltip') }}" class="link list-social__link">
                            <img src="{{ data_get($network, 'icon.link') }}" alt="{{ data_get($network, 'name') }}" width="{{ data_get($network, 'icon.width') }}" height="{{ data_get($network, 'icon.height') }}">
                            <span class="visually-hidden">{{ data_get($network, 'name') }}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @if (has_data( data_get($SYSTEM_SETTING, 'page_settings.informed_moit.enable') ) || has_data( data_get($SYSTEM_SETTING, 'page_settings.registered_moit.enable') ))
        <div class="footer__content-bottom">
            <div class="footer__content-bottom-wrapper page-width" style="display: flex; align-items: center; justify-content: center;">
                @if (has_data( data_get($SYSTEM_SETTING, 'page_settings.informed_moit.enable') ))
                <div class="item" style="padding: 5px 10px;">
                    <a href="{{ data_get($SYSTEM_SETTING, 'page_settings.informed_moit.link') }}" target="_blank">
                        <img width="150" src="{{ asset_with_version('frontend/assets/images/shared/bo-cong-thuong-informed.png') }}" alt="Đã thông báo bộ công thương">
                    </a>
                </div>
                @endif
                @if (has_data( data_get($SYSTEM_SETTING, 'page_settings.registered_moit.enable') ))
                <div class="item" style="padding: 5px 10px;">
                    <a href="{{ data_get($SYSTEM_SETTING, 'page_settings.registered_moit.link') }}" target="_blank">
                        <img width="150" src="{{ asset_with_version('frontend/assets/images/shared/bo-cong-thuong-registered.png') }}" alt="Đã đăng ký bộ công thương">
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif
        <div class="footer__content-bottom">
            <div class="footer__content-bottom-wrapper page-width">
                <div class="footer__column footer__localization isolate"></div>
                <div class="footer__column footer__column--info">
                    <div class="footer__copyright caption">
                        <small class="copyright__content">© {{ now()->year }}, <a href="/" title="">{{ data_get($SYSTEM_SETTING, 'page_settings.title') }}</a></small>
                        @if (has_data(data_get($SYSTEM_SETTING, 'page_settings.license')))
                        <small class="copyright__content">
                            <a target="_blank" rel="nofollow" href="{{ data_get($SYSTEM_SETTING, 'page_settings.license.link') }}">Được cung cấp bởi <span style="text-decoration: underline;">{{ data_get($SYSTEM_SETTING, 'page_settings.license.value') }}</span></a>
                        </small>
                        @endif
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
                beforeSend: () => {
                    $('#ContactFooter-success').addClass('d-none');
                },
                success: () => {
                    $('#ContactFooter-success').removeClass('d-none');
                },
                error: function (jqXHR, status, errorThrown) {
                    toastr.error("Đăng ký không thành công.");
                },
            });
        });
    </script>
    @endif
@endpush
