@extends('frontend.layouts.master')

@section('page_title')
Hoàn thành thông tin | {{ config('app.user_domain') }}
@endsection

@section('page_seo')
{!! generate_seo_html(['page_name' => 'Hoàn thành thông tin']) !!}
@endsection

@push('style_pages')
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/pages/page.min.css') }}">
<link rel="stylesheet" href="{{ asset_with_version('frontend/bundle/css/pages/profile.min.css') }}">
@endpush

@section('content_body')
<section class="shopify-section section">
    <article class="article-template" itemscope itemtype="http://schema.org/BlogPosting">
        <header class="page-width">
            <h1 class="article-template__title" style="text-align: center;" itemprop="headline">Hoàn thành thông tin tài khoản</h1>
        </header>

        <div class="article-template__social-sharing page-width page-width--narrow">
            <form action="{{ route('fe.api.user.update-info') }}" method="POST" data-form="user-info">
                <div class="form-fields">
                    <input style="display: none;" type="text" name="name" id="name" value="{{ data_get($AUTHENTICATED_USER, 'name') }}">
                    <div class="form-group">
                        <div class="field field--with-error" style="margin: 5px 0;">
                            <input type="text" name="email" id="email" value="{{ data_get($AUTHENTICATED_USER, 'email') }}" class="field__input" autocomplete="phone" placeholder="E-mail">
                            <label class="field__label" for="email">E-mail <span> (không yêu cầu nhập)</span></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="field field--with-error" style="margin: 5px 0;">
                            <input type="text" name="phone_number" id="phone_number" value="{{ data_get($AUTHENTICATED_USER, 'phone_number') }}" class="field__input" autocomplete="phone" value required placeholder="Số Điện Thoại / Email">
                            <label class="field__label" for="phone_number">Số điện thoại <span>*</span></label>
                        </div>
                    </div>

                    <a href="{{ route('fe.api.user.signout') }}" id="User_SignOut" style="color: #000;">
                        <span>Đăng xuất</span>
                    </a>

                    <button type="submit" class="button" style="display: block; width: 100%; margin-bottom: 5px; margin-top: 20px;" data-button-submit-text>Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </article>
</section>
@endsection

@section('js_script')
<script src="{{ asset_with_version('frontend/bundle/js/profile-user-info.min.js') }}"></script>
@endsection
