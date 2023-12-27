<div class="shopify-section">
    <footer class="footer color-background-1 gradient section-footer-padding">
        <div class="footer__content-top page-width">
            <div class="footer__blocks-wrapper grid grid--1-col grid--2-col grid--4-col-tablet ">
                <div class="footer-block grid__item">
                    <div>
                        <h2 class="footer-block__heading"></h2>
                        <div class="footer-block__details-content rte">

                        </div>
                    </div>
                </div>
                @if(! empty($PAGES_DISPLAY_IN_FOOTER))
                <div class="footer-block grid__item footer-block--menu">
                    <h2 class="footer-block__heading">MENU</h2>
                    <ul class="footer-block__details-content list-unstyled">
                        @foreach ($PAGES_DISPLAY_IN_FOOTER as $page)
                        <li>
                            <a href="{{ route('fe.web.pages.index', data_get($page, 'slug')) }}" class="link link--text list-menu__item list-menu__item--link">{{ data_get($page, 'name') }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            <div class="footer-block--newsletter">
                <ul class="footer__list-social list-unstyled list-social" role="list">
					@foreach (data_get($SYSTEM_SETTING, 'social_networks', []) as $network)
					<li class="list-social__item">
						<a href="{{ data_get($network, 'link') }}" target="_blank" title="{{ data_get($network, 'tooltip') }}" class="link list-social__link">
							@include('frontend.icons.'.data_get($network, 'icon'))
							<span class="visually-hidden">{{ data_get($network, 'name') }}</span>
						</a>
					</li>
					@endforeach
                </ul>
            </div>
        </div>
        <div class="footer__content-bottom">
            <div class="footer__content-bottom-wrapper page-width">
                <div class="footer__column footer__localization isolate"></div>
                <div class="footer__column footer__column--info">
                    <div class="footer__copyright caption">
                        <small class="copyright__content" style="display: flex;">© {{ now()->year }}, <a href="{{ route('fe.web.home') }}" title="{{ data_get($SYSTEM_SETTING, 'page_settings.title') }}">{{ $APP_URL }}</a></small>
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
