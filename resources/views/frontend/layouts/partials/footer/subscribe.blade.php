<div class="shopify-section">
    <div class="section--divider">
        <style data-shopify=""></style>
        <div class="index-section newsletter-container newsletter-template--16783367766274__newsletter color-scheme-1">
            <div class="scheme-none"></div>
            <div class="page-width text-center">
                <div class="newsletter-section newsletter-section--image-right newsletter-section--no-image">
                    <div class="newsletter-section__content" style="text-align: center; padding: 0;">
                        <div class="theme-block">
                            <p class="h1">{{ data_get($SYSTEM_SETTING, 'receive_new_post_setting.title') }}</p>
                        </div>
                        <div class="theme-block">
                            <div class="rte">
                                <div class="enlarge-text">
                                    <p>
                                        <em>{{ data_get($SYSTEM_SETTING, 'receive_new_post_setting.description') }}</em>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="theme-block">
                            <form method="post" action="{{ route('fe.api.user.subscribe.news-letter') }}" id="ContactFooter" accept-charset="UTF-8" class="footer__newsletter newsletter-form">
                                <div class="newsletter-form__field-wrapper" style="width: 100%;">
                                    <div class="field">
                                        <input id="NewsletterForm--footer" type="email" name="contact[email]" class="field__input" value="" aria-required="true" autocorrect="off" autocapitalize="off" autocomplete="email" placeholder="Email" required>
                                        <label class="field__label" for="NewsletterForm--footer">Email</label>
                                        <button type="submit" class="newsletter-form__button field__button" name="commit" id="Subscribe" style="width: 48px; height: 48px;">
                                            <svg viewBox="0 0 14 10" fill="none" aria-hidden="true" focusable="false" role="presentation" class="icon icon-arrow" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.537.808a.5.5 0 01.817-.162l4 4a.5.5 0 010 .708l-4 4a.5.5 0 11-.708-.708L11.793 5.5H1a.5.5 0 010-1h10.793L8.646 1.354a.5.5 0 01-.109-.546z" fill="currentColor"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
