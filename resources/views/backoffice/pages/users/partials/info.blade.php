<div class="k-portlet">
    <div class="k-portlet__head">
        <div class="k-portlet__head-label">
            <h3 class="k-portlet__head-title mr-2">{{ __('Thông tin chung') }}</h3>
            @if($user->is_test_user)
            <span class="btn btn-label-success btn-sm btn-pill" >
                <span>{{ __('Tài khoản thử nghiệm') }}</span>
            </span>
            @endif
        </div>
        <div class="k-portlet__head-toolbar">
            <div class="k-portlet__head-group">
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-primary btn-pill" data-modal="#modal_update_user">
                        <i class="la la-pencil"></i>
                        <span>{{ __('Cập nhật') }}</span>
                    </button>
                    @can('users.change_password')
                    <button type="button" class="btn btn-sm btn-outline-primary btn-pill" data-modal="#modal_change_password">
                        <i class="la la-pencil"></i>
                        <span>{{ __('Đổi mật khẩu') }}</span>
                    </button>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <div class="k-portlet__body">
        <div class="form-group row">
            <div class="col-lg-4">
                <label>{{ __('Tên tài khoản') }}</label>
                <input type="text" class="form-control" disabled="disabled" value="{{ $user->username }}">
            </div>
            <div class="col-lg-4">
                <label>{{ __('Tên') }}</label>
                <input type="text" class="form-control" disabled="disabled" value="{{ $user->name }}">
            </div>
            <div class="col-lg-4">
                <label class="">{{ __('Email') }}</label>
                <input type="text" class="form-control" disabled="disabled" value="{{ $user->email }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-4">
                <label>{{ __('Số điện thoại') }}</label>
                <input  class="form-control" type="text" disabled="disabled" value="{{ $user->phone_number }}">
            </div>
            <div class="col-lg-4">
                <label>{{ __('Đăng nhập lần cuối vào lúc') }}</label>
                <input type="text" class="form-control" disabled="disabled" value="{{ $user->last_logged_in_at }}">
            </div>
            <div class="col-lg-4">
                <label class="">{{ __('Sinh nhật') }}</label>
                <input type="text" class="form-control" disabled="disabled" value="{{ $user->birthday }}">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-lg-4">
                <label>{{ __('Mã tiền tệ') }}</label>
                <input  class="form-control" type="text" disabled="disabled" value="{{ $user->currency_code }}">
            </div>
            <div class="col-lg-4">
                <label>{{ __('Kênh truy cập') }}</label>
                <input type="text" class="form-control" disabled="disabled" value="{{ $user->access_channel_type_name }}">
            </div>
            <div class="col-lg-4">
                <label class="">{{ __('Reference kênh truy cập') }}</label>
                <input type="text" class="form-control" disabled="disabled" value="{{ data_get($user->meta, 'access_channel.reference_id') }}">
            </div>
        </div>
    </div>
</div>

@can('users.change_password')
<div class="modal fade" id="modal_change_password" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="form_update_user" method="POST" action="{{ route('bo.web.users.update-password', $user->getKey()) }}">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Đổi mật khẩu') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">{{ __('Mật khẩu') }}</label>
                        <div class="input-group">
                            <input id="password" type="text" name="password" value="{{ old('password') }}" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="{{ __('Nhập mật khẩu') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" data-generate data-generate-length="10" data-generate-ref="#password" data-generate-lowercase="true" type="button">{{ __('Generate password') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Đóng') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endcan

@can('users.update')
<div class="modal fade" id="modal_update_user" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="form_update_user" method="POST" action="{{ route('bo.web.users.update', $user->getKey()) }}">
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Cập nhật thông tin') }}</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label>{{ __('Tên khách hàng') }}</label>
                            <input type="text" class="form-control" name="username" value="{{ old('username', $user->username) }}">
                        </div>
                        <div class="col-lg-4">
                            <label>{{ __('Tên') }}</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">
                        </div>
                        <div class="col-lg-4">
                            <label>{{ __('Email') }}</label>
                            <input type="text" class="form-control" name="email" value="{{ old('email', $user->email) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label>{{ __('Số điện thoại') }}</label>
                            <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}">
                        </div>
                        <div class="col-lg-4">
                            <label>{{ __('Sinh nhật') }}</label>
                            <div class="input-group">
                                <input autocomplete="off" type="datepicker" class="form-control" name="birthday" value="{{ old('birthday', $user->birthday) }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>{{ __('Cho phép đăng nhập') }} *</label>
                                <select name="allow_login" data-live-search="true" class="form-control k_selectpicker" required>
                                    <option value="1" {{ old('allow_login', $user->allow_login) == 1 ? 'selected' : '' }}>{{ __('Có') }}</option>
                                    <option value="0" {{ old('allow_login', $user->allow_login) == 0 ? 'selected' : '' }}>{{ __('Không') }}</option>
                                </select>
                                @error('allow_login')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>{{ __('Kênh truy cập') }} *</label>
                                <select name="access_channel_type" data-live-search="true" class="form-control k_selectpicker" required>
                                    @foreach($accessChannelTypeLables as $key => $label)
                                    <option value="{{ $key }}" {{ old('access_channel_type', $user->access_channel_type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('access_channel_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">{{ __('Reference kênh truy cập') }}</label>
                                <input type="text" class="form-control" name="meta[access_channel][reference_id]" placeholder="{{ __('Nhập reference kênh truy cập') }}" value="{{ old('meta.access_channel.reference_id', data_get($user->meta, 'access_channel.reference_id')) }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Đóng') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endcan
