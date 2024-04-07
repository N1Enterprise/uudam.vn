@if (has_data( data_get($SYSTEM_SETTING, 'oauth_providers', []) ))
<div class="social-authentication">
    <div class="social-authentication__title" style="padding: 10px 0; text-align: center;">
        <span>Đăng nhập với mạng xã hội</span>
    </div>
    <div>
        @foreach (data_get($SYSTEM_SETTING, 'oauth_providers', []) as $provider => $config)
        <div class="social-authentication-provider-wrapper" data-oauth-provider="{{ $provider }}" data-oauth-login-route="{{ route('fe.api.user.oauth.providers') }}">
            <div class="social-authentication__item {{ $provider }}">
                <img src="{{ data_get($config, 'logo') }}" alt="{{ $provider }} Login">
            </div>
            <span style="margin-left: 10px;">{{ data_get($config, 'button_label') }}</span>
        </div>
        @endforeach
    </div>
</div>
@endif
