@extends('frontend.layouts.profile')

@section('page_title')
{{ get_static_page_seo_title('profile_change_password') }}
@endsection

@section('page_seo')
{!! generate_static_page_seo_html('profile_change_password') !!}
@endsection

@section('profile_style')
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/pages/profile.min.css') }}">
@endsection

@section('profile_content')
<div class="profile-change-password">
    <h4>Thay đổi mật khẩu</h4>
    <form action="{{ route('fe.api.user.update-password') }}" method="POST" data-form="change-password">
        <div class="form-fields">

            <div class="form-group">
                <div class="field field--with-error" style="margin: 5px 0;">
                    <input type="text" name="password" id="password" class="field__input" autocomplete="phone" value required placeholder="password">
                    <label class="field__label" for="password">Mật khẩu <span>*</span></label>
                </div>
            </div>

            <button type="submit" class="button" style="display: block; width: 100%; margin-bottom: 5px;" data-button-submit-text>Lưu thay đổi</button>
        </div>
        </div>
    </form>
</div>
@endsection

@section('profile_js')
<script src="{{ asset_with_version('frontend/bundle/js/profile-change-password.min.js') }}"></script>
@endsection
