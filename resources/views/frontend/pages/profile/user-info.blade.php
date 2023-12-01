@extends('frontend.layouts.profile')

@section('profile_content')
<div class="profile-user-info">
    <h4>Thông tin tài khoản</h4>

    <form action="{{ route('fe.api.user.update-info') }}" method="POST" data-form="user-info">
        <div class="form-fields">
            <div class="form-group">
                <div class="field field--with-error" style="margin: 5px 0;">
                    <input type="text" name="name" id="name" value="{{ data_get($AUTHENTICATED_USER, 'name') }}" class="field__input" autocomplete="name" value aria-required="true" placeholder="Họ tên" required>
                    <label class="field__label" for="name">Họ tên <span aria-hidden="true">*</span></label>
                </div>
            </div>

            <div class="form-group">
                <div class="field field--with-error" style="margin: 5px 0;">
                    <input type="text" name="email" id="email" value="{{ data_get($AUTHENTICATED_USER, 'email') }}" class="field__input" autocomplete="phone" value aria-required="true" required placeholder="E-mail">
                    <label class="field__label" for="email">E-mail <span aria-hidden="true">*</span></label>
                </div>
            </div>

            <div class="form-group">
                <div class="field field--with-error" style="margin: 5px 0;">
                    <input type="text" name="phone_number" id="phone_number" value="{{ data_get($AUTHENTICATED_USER, 'phone_number') }}" class="field__input" autocomplete="phone" value aria-required="true" required placeholder="Số Điện Thoại / Email">
                    <label class="field__label" for="phone_number">Số điện thoại <span aria-hidden="true">*</span></label>
                </div>
            </div>

            <div class="form-group">
                <div class="field field--with-error" style="margin: 5px 0;">
                    <input type="date" name="birthday" id="birthday" value="{{ data_get($AUTHENTICATED_USER, 'birthday') }}" class="field__input" autocomplete="birthday" value placeholder="Số Điện Thoại">
                    <label class="field__label" for="birthday">Sinh nhật</label>
                </div>
            </div>

            <button type="submit" class="button" style="display: block; width: 100%; margin-bottom: 5px;" data-button-submit-text>Lưu thay đổi</button>
        </div>
        </div>
    </form>
</div>
@endsection

@section('profile_js')
<script src="{{ mix('frontend/bundle/js/profile/user-info.min.js') }}"></script>
@endsection
