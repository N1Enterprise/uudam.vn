@extends('frontend.layouts.profile')

@section('profile_content')
<div class="profile-change-password">
    <h4>Thay đổi mật khẩu</h4>
    <form action="{{ route('fe.api.user.update-password') }}" method="POST" data-form="change-password">
        <div class="form-fields">

            <div class="form-group">
                <div class="field field--with-error" style="margin: 5px 0;">
                    <input type="text" name="password" id="password" class="field__input" autocomplete="phone" value aria-required="true" required placeholder="password">
                    <label class="field__label" for="password">Mật khẩu <span aria-hidden="true">*</span></label>
                </div>
            </div>

            <button type="submit" class="button" style="display: block; width: 100%; margin-bottom: 5px;" data-button-submit-text>Lưu thay đổi</button>
        </div>
        </div>
    </form>
</div>
@endsection

@section('profile_js')
<script src="{{ mix('frontend/bundle/js/profile/change-password.min.js') }}"></script>
@endsection
