<div class="shopify-section">
    <footer class="footer color-background-1 gradient section-footer-padding">
        <div class="footer__content-top page-width">
            <div class="footer__blocks-wrapper grid grid--1-col grid--2-col grid--4-col-tablet ">
                <div class="footer-block grid__item">
                    <div>
                        <div class="footer-block__details-content rte">
                            @if (has_data( data_get($SYSTEM_SETTING, 'page_settings.address') ))
                            <div style="display: flex; font-size: 14px; align-items: center; padding: 5px 0;">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:serif="http://www.serif.com/" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" width="23" height="23" viewBox="0 0 32 32" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;" version="1.1" xml:space="preserve">
                                    <g id="Layer1"><path d="M16,2c-6.071,0 -11,4.929 -11,11c0,2.778 1.654,6.081 3.699,9.019c2.939,4.224 6.613,7.707 6.613,7.707c0.386,0.365 0.99,0.365 1.376,-0c0,-0 3.674,-3.483 6.613,-7.707c2.045,-2.938 3.699,-6.241 3.699,-9.019c0,-6.071 -4.929,-11 -11,-11Zm0,5.5c-3.036,0 -5.5,2.464 -5.5,5.5c0,3.036 2.464,5.5 5.5,5.5c3.036,-0 5.5,-2.464 5.5,-5.5c0,-3.036 -2.464,-5.5 -5.5,-5.5Zm0,2c1.932,0 3.5,1.568 3.5,3.5c0,1.932 -1.568,3.5 -3.5,3.5c-1.932,-0 -3.5,-1.568 -3.5,-3.5c0,-1.932 1.568,-3.5 3.5,-3.5Z"/></g>
                                </svg>
                                <span style="margin-left: 10px;">Địa chỉ: {{ data_get($SYSTEM_SETTING, 'page_settings.address.value') }}</span>    
                            </div>
                            @endif
                            
                            @if (has_data( data_get($SYSTEM_SETTING, 'page_settings.phone_support') ))
                            <div style="display: flex; font-size: 14px; align-items: center; padding: 5px 0; padding-left: 2px;;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                                    <g id="SVGRepo_iconCarrier">
                                        <path d="M15.5562 14.5477L15.1007 15.0272C15.1007 15.0272 14.0181 16.167 11.0631 13.0559C8.10812 9.94484 9.1907 8.80507 9.1907 8.80507L9.47752 8.50311C10.1841 7.75924 10.2507 6.56497 9.63424 5.6931L8.37326 3.90961C7.61028 2.8305 6.13596 2.68795 5.26145 3.60864L3.69185 5.26114C3.25823 5.71766 2.96765 6.30945 3.00289 6.96594C3.09304 8.64546 3.81071 12.259 7.81536 16.4752C12.0621 20.9462 16.0468 21.1239 17.6763 20.9631C18.1917 20.9122 18.6399 20.6343 19.0011 20.254L20.4217 18.7584C21.3806 17.7489 21.1102 16.0182 19.8833 15.312L17.9728 14.2123C17.1672 13.7486 16.1858 13.8848 15.5562 14.5477Z" fill="#000000" />
                                        <path d="M13.2595 1.87983C13.3257 1.47094 13.7122 1.19357 14.1211 1.25976C14.1464 1.26461 14.2279 1.27983 14.2705 1.28933C14.3559 1.30834 14.4749 1.33759 14.6233 1.38082C14.9201 1.46726 15.3347 1.60967 15.8323 1.8378C16.8286 2.29456 18.1544 3.09356 19.5302 4.46936C20.906 5.84516 21.705 7.17097 22.1617 8.16725C22.3899 8.66487 22.5323 9.07947 22.6187 9.37625C22.6619 9.52466 22.6912 9.64369 22.7102 9.72901C22.7197 9.77168 22.7267 9.80594 22.7315 9.83125L22.7373 9.86245C22.8034 10.2713 22.5286 10.6739 22.1197 10.7401C21.712 10.8061 21.3279 10.53 21.2601 10.1231C21.258 10.1121 21.2522 10.0828 21.2461 10.0551C21.2337 9.9997 21.2124 9.91188 21.1786 9.79572C21.1109 9.56339 20.9934 9.21806 20.7982 8.79238C20.4084 7.94207 19.7074 6.76789 18.4695 5.53002C17.2317 4.29216 16.0575 3.59117 15.2072 3.20134C14.7815 3.00618 14.4362 2.88865 14.2038 2.82097C14.0877 2.78714 13.9417 2.75363 13.8863 2.7413C13.4793 2.67347 13.1935 2.28755 13.2595 1.87983Z" fill="#000000" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M13.4857 5.3293C13.5995 4.93102 14.0146 4.7004 14.4129 4.81419L14.2069 5.53534C14.4129 4.81419 14.4129 4.81419 14.4129 4.81419L14.4144 4.81461L14.4159 4.81505L14.4192 4.81602L14.427 4.81834L14.4468 4.8245C14.4618 4.82932 14.4807 4.8356 14.5031 4.84357C14.548 4.85951 14.6074 4.88217 14.6802 4.91337C14.8259 4.97581 15.0249 5.07223 15.2695 5.21694C15.7589 5.50662 16.4271 5.9878 17.2121 6.77277C17.9971 7.55775 18.4782 8.22593 18.7679 8.7154C18.9126 8.95991 19.009 9.15897 19.0715 9.30466C19.1027 9.37746 19.1254 9.43682 19.1413 9.48173C19.1493 9.50418 19.1555 9.52301 19.1604 9.53809L19.1665 9.55788L19.1688 9.56563L19.1698 9.56896L19.1702 9.5705C19.1702 9.5705 19.1707 9.57194 18.4495 9.77798L19.1707 9.57194C19.2845 9.97021 19.0538 10.3853 18.6556 10.4991C18.2607 10.6119 17.8492 10.3862 17.7313 9.99413L17.7276 9.98335C17.7223 9.96832 17.7113 9.93874 17.6928 9.89554C17.6558 9.8092 17.5887 9.66797 17.4771 9.47938C17.2541 9.10264 16.8514 8.53339 16.1514 7.83343C15.4515 7.13348 14.8822 6.73078 14.5055 6.50781C14.3169 6.39619 14.1757 6.32909 14.0893 6.29209C14.0461 6.27358 14.0165 6.26254 14.0015 6.25721L13.9907 6.25352C13.5987 6.13564 13.3729 5.72419 13.4857 5.3293Z" fill="#000000" />
                                    </g>
                                </svg>
                                <span style="margin-left: 10px;">Số điện thoại: <a href="tel:{{ data_get($SYSTEM_SETTING, 'page_settings.phone_support.phone') }}" class="link">{{ data_get($SYSTEM_SETTING, 'page_settings.phone_support.phone') }}</a></span>
                            </div>
                            @endif

                            @if (has_data( data_get($SYSTEM_SETTING, 'page_settings.email_support') ))
                            <div style="display: flex; font-size: 14px; align-items: center; padding: 5px 0; padding-left: 4px">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" width="17" height="17" viewBox="0 0 1920 1920">
                                    <path d="M1920 428.266v1189.54l-464.16-580.146-88.203 70.585 468.679 585.904H83.684l468.679-585.904-88.202-70.585L0 1617.805V428.265l959.944 832.441L1920 428.266ZM1919.932 226v52.627l-959.943 832.44L.045 278.628V226h1919.887Z" fill-rule="evenodd"/>
                                </svg>
                                <span style="margin-left: 10px;">Email: <a href="mail:{{ data_get($SYSTEM_SETTING, 'page_settings.email_support.value') }}" class="link">{{ data_get($SYSTEM_SETTING, 'page_settings.email_support.value') }}</a></span>
                            </div>
                            @endif

                            @if (has_data( data_get($SYSTEM_SETTING, 'page_settings.license') ))
                            <div style="display: flex; font-size: 14px; align-items: center; padding: 5px 0;">
                                <span style="margin-left: 10px;">© Bản quyền thuộc về <a href="{{ data_get($SYSTEM_SETTING, 'page_settings.license.link') }}" target="_blank" class="link">{{ data_get($SYSTEM_SETTING, 'page_settings.license.value') }}</a></span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if(has_data(data_get($SYSTEM_SETTING, 'pages_display_in_footer', [])))
                <div class="footer-block grid__item footer-block--menu">
                    <h2 class="footer-block__heading">MENU</h2>
                    <ul class="footer-block__details-content list-unstyled">
                        @foreach (data_get($SYSTEM_SETTING, 'pages_display_in_footer', []) as $page)
                        <li>
                            <a href="{{ data_get($page, 'url') }}" target="{{data_get($page, 'target')  }}" class="link link--text list-menu__item list-menu__item--link">{{ data_get($page, 'name') }}</a>
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
                        <small class="copyright__content" style="display: flex;">© {{ now()->year }}, <a href="{{ route('fe.web.home') }}" title="{{ data_get($SYSTEM_SETTING, 'page_settings.title') }}" style="margin-left: 3px;">{{ config('app.user_domain') }}</a></small>
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
