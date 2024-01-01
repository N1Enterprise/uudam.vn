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
                    <li class="list-social__item">
                        <a href="https://www.facebook.com/DharmaCrafts" class="link list-social__link">
                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-facebook" viewBox="0 0 18 18">
                                <path fill="currentColor" d="M16.42.61c.27 0 .5.1.69.28.19.2.28.42.28.7v15.44c0 .27-.1.5-.28.69a.94.94 0 01-.7.28h-4.39v-6.7h2.25l.31-2.65h-2.56v-1.7c0-.4.1-.72.28-.93.18-.2.5-.32 1-.32h1.37V3.35c-.6-.06-1.27-.1-2.01-.1-1.01 0-1.83.3-2.45.9-.62.6-.93 1.44-.93 2.53v1.97H7.04v2.65h2.24V18H.98c-.28 0-.5-.1-.7-.28a.94.94 0 01-.28-.7V1.59c0-.27.1-.5.28-.69a.94.94 0 01.7-.28h15.44z"></path>
                            </svg>
                            <span class="visually-hidden">Facebook</span>
                        </a>
                    </li>
                    <li class="list-social__item">
                        <a href="https://co.pinterest.com/dharmacrafts/" class="link list-social__link">
                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-pinterest" viewBox="0 0 17 18">
                                <path fill="currentColor" d="M8.48.58a8.42 8.42 0 015.9 2.45 8.42 8.42 0 011.33 10.08 8.28 8.28 0 01-7.23 4.16 8.5 8.5 0 01-2.37-.32c.42-.68.7-1.29.85-1.8l.59-2.29c.14.28.41.52.8.73.4.2.8.31 1.24.31.87 0 1.65-.25 2.34-.75a4.87 4.87 0 001.6-2.05 7.3 7.3 0 00.56-2.93c0-1.3-.5-2.41-1.49-3.36a5.27 5.27 0 00-3.8-1.43c-.93 0-1.8.16-2.58.48A5.23 5.23 0 002.85 8.6c0 .75.14 1.41.43 1.98.28.56.7.96 1.27 1.2.1.04.19.04.26 0 .07-.03.12-.1.15-.2l.18-.68c.05-.15.02-.3-.11-.45a2.35 2.35 0 01-.57-1.63A3.96 3.96 0 018.6 4.8c1.09 0 1.94.3 2.54.89.61.6.92 1.37.92 2.32 0 .8-.11 1.54-.33 2.21a3.97 3.97 0 01-.93 1.62c-.4.4-.87.6-1.4.6-.43 0-.78-.15-1.06-.47-.27-.32-.36-.7-.26-1.13a111.14 111.14 0 01.47-1.6l.18-.73c.06-.26.09-.47.09-.65 0-.36-.1-.66-.28-.89-.2-.23-.47-.35-.83-.35-.45 0-.83.2-1.13.62-.3.41-.46.93-.46 1.56a4.1 4.1 0 00.18 1.15l.06.15c-.6 2.58-.95 4.1-1.08 4.54-.12.55-.16 1.2-.13 1.94a8.4 8.4 0 01-5-7.65c0-2.3.81-4.28 2.44-5.9A8.04 8.04 0 018.48.57z"></path>
                            </svg>
                            <span class="visually-hidden">Pinterest</span>
                        </a>
                    </li>
                    <li class="list-social__item">
                        <a href="https://www.instagram.com/shopdharmacrafts/" class="link list-social__link">
                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-instagram" viewBox="0 0 18 18">
                                <path fill="currentColor" d="M8.77 1.58c2.34 0 2.62.01 3.54.05.86.04 1.32.18 1.63.3.41.17.7.35 1.01.66.3.3.5.6.65 1 .12.32.27.78.3 1.64.05.92.06 1.2.06 3.54s-.01 2.62-.05 3.54a4.79 4.79 0 01-.3 1.63c-.17.41-.35.7-.66 1.01-.3.3-.6.5-1.01.66-.31.12-.77.26-1.63.3-.92.04-1.2.05-3.54.05s-2.62 0-3.55-.05a4.79 4.79 0 01-1.62-.3c-.42-.16-.7-.35-1.01-.66-.31-.3-.5-.6-.66-1a4.87 4.87 0 01-.3-1.64c-.04-.92-.05-1.2-.05-3.54s0-2.62.05-3.54c.04-.86.18-1.32.3-1.63.16-.41.35-.7.66-1.01.3-.3.6-.5 1-.65.32-.12.78-.27 1.63-.3.93-.05 1.2-.06 3.55-.06zm0-1.58C6.39 0 6.09.01 5.15.05c-.93.04-1.57.2-2.13.4-.57.23-1.06.54-1.55 1.02C1 1.96.7 2.45.46 3.02c-.22.56-.37 1.2-.4 2.13C0 6.1 0 6.4 0 8.77s.01 2.68.05 3.61c.04.94.2 1.57.4 2.13.23.58.54 1.07 1.02 1.56.49.48.98.78 1.55 1.01.56.22 1.2.37 2.13.4.94.05 1.24.06 3.62.06 2.39 0 2.68-.01 3.62-.05.93-.04 1.57-.2 2.13-.41a4.27 4.27 0 001.55-1.01c.49-.49.79-.98 1.01-1.56.22-.55.37-1.19.41-2.13.04-.93.05-1.23.05-3.61 0-2.39 0-2.68-.05-3.62a6.47 6.47 0 00-.4-2.13 4.27 4.27 0 00-1.02-1.55A4.35 4.35 0 0014.52.46a6.43 6.43 0 00-2.13-.41A69 69 0 008.77 0z"></path>
                                <path fill="currentColor" d="M8.8 4a4.5 4.5 0 100 9 4.5 4.5 0 000-9zm0 7.43a2.92 2.92 0 110-5.85 2.92 2.92 0 010 5.85zM13.43 5a1.05 1.05 0 100-2.1 1.05 1.05 0 000 2.1z"></path>
                            </svg>
                            <span class="visually-hidden">Instagram</span>
                        </a>
                    </li>
                    <li class="list-social__item">
                        <a href="https://www.youtube.com/user/dharmacrafts" class="link list-social__link">
                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-youtube" viewBox="0 0 100 70">
                                <path d="M98 11c2 7.7 2 24 2 24s0 16.3-2 24a12.5 12.5 0 01-9 9c-7.7 2-39 2-39 2s-31.3 0-39-2a12.5 12.5 0 01-9-9c-2-7.7-2-24-2-24s0-16.3 2-24c1.2-4.4 4.6-7.8 9-9 7.7-2 39-2 39-2s31.3 0 39 2c4.4 1.2 7.8 4.6 9 9zM40 50l26-15-26-15v30z" fill="currentColor"></path>
                            </svg>
                            <span class="visually-hidden">YouTube</span>
                        </a>
                    </li>
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
