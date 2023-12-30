@if (has_data( data_get($SYSTEM_SETTING, 'oauth_providers', []) ))
<div class="social-authentication">
    <div class="social-authentication__title" style="padding: 10px 0; text-align: center;">
        <span>Đăng nhập với mạng xã hội</span>
    </div>
    <div style="display: flex; justify-content: center;">
        @foreach (data_get($SYSTEM_SETTING, 'oauth_providers', []) as $provider => $config)
        <div class="social-authentication__item {{ $provider }}" data-oauth-provider="{{ $provider }}" data-oauth-login-route="{{ route('fe.api.user.oauth.providers') }}">
            <img src="{{ data_get($config, 'logo') }}" alt="{{ $provider }} Login">
        </div>
        @endforeach
    </div>
</div>
@endif