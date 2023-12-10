<div class="social-authentication">
    <div class="social-authentication__title" style="padding: 10px 0; text-align: center;">
        <span>Đăng nhập với mạng xã hội</span>
    </div>
    <div style="display: flex; justify-content: center;">
        <div class="social-authentication__item facebook" data-oauth-provider="facebook" data-oauth-login-route="{{ route('fe.api.user.oauth.providers') }}">
            <img src="{{ asset_with_version('frontend/assets/images/shared/facebook.png') }}" alt="Facebook Login">
        </div>

        <div class="social-authentication__item google" data-oauth-provider="google" data-oauth-login-route="{{ route('fe.api.user.oauth.providers') }}">
            <img src="{{ asset_with_version('frontend/assets/images/shared/google.png') }}" alt="Google Login">
        </div>
    </div>
</div>
