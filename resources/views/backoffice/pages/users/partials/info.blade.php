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
    </div>
</div>

@can('users.update')
<div class="modal fade" id="modal_update_user" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <form id="form_update_user" method="POST" action="{{ route('bo.web.users.update', $user->getKey()) }}">
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Edit User Info') }}</h5>
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
