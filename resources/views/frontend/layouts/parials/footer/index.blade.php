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
                @if(! empty($PAGES_BELONGTO_MENU))
                <div class="footer-block grid__item footer-block--menu">
                    <h2 class="footer-block__heading">MENU</h2>
                    <ul class="footer-block__details-content list-unstyled">
                        @foreach ($PAGES_BELONGTO_MENU as $page)
                        <li>
                            <a href="{{ route('fe.web.pages.index', data_get($page, 'slug')) }}" class="link link--text list-menu__item list-menu__item--link">{{ data_get($page, 'name') }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            <div class="footer-block--newsletter">
				@if(data_get($RECEIVE_NEW_POST_SETTING, 'enable'))
                <div class="footer-block__newsletter">
                    <h2 class="footer-block__heading">{{ data_get($RECEIVE_NEW_POST_SETTING, 'title') }}</h2>
                    <p>{{ data_get($RECEIVE_NEW_POST_SETTING, 'description') }}</p>
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
                            Thanks for subscribing
                        </h3>
                    </form>
                </div>
				@endif
                <ul class="footer__list-social list-unstyled list-social" role="list">
					@foreach ($SOCIAL_NETWORKS as $network)
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
                        <small class="copyright__content" style="display: flex;">© {{ now()->year }}, <a href="{{ route('fe.web.home') }}" title="{{ data_get($PAGE_SETTINGS, 'title') }}">{{ $APP_URL }}</a></small>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

@push('js_pages')
    @if(data_get($RECEIVE_NEW_POST_SETTING, 'enable'))
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
