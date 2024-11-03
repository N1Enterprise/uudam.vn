<div class="modal fade" id="userProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="form-group">
                    <h5 class="mb-4">
                        {{ __('My Profile') }}
                        <button style="font-family: 'LineAwesome'; transform: translateY(-2px); " type="button" class="close" data-dismiss="modal">
                            <span style="color: #a1a8c3">&times;</span>
                        </button>
                    </h5>
                    <form id="updateCurrentAdminProfileForm">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Email') }}</label>
                            <input name="email" type="text" class="form-control" value="{{ $AUTHENTICATED_ADMIN->email }}" disabled>
                        </div>

                        <div class="form-group">
                            <label>{{ __('Tên') }} *</label>
                            <input name="name" required type="text" class="form-control" value="{{ $AUTHENTICATED_ADMIN->name }}">
                        </div>

                        <div class="form-group mb-2 text-right">
                            <button
                                data-success-callback="onSuccessUpdateUserProfile"
                                data-form="#updateCurrentAdminProfileForm"
                                data-method="put"
                                type="submit"
                                data-url=""
                                class="btn btn-primary"
                            >
                                {{ __('Save') }}
                            </button>
                        </div>
                    </form>
                </div>
                <div class="k-separator k-separator--border-dashed"></div>
                <div class="form-group mb-2">
                    <h5 class="my-4">{{ __('Change Password') }}</h5>
                    <form id="Form_UpdateCurrentAdminPassword">
                        @csrf
                        <div class="form-group">
                            <label>{{ __('Current Password') }} *</label>
                            <input required name="password" type="password" class="form-control" autocomplete="current-password">
                        </div>

                        <div class="form-group">
                            <label>{{ __('New Password') }} *</label>
                            <input required name="new_password" type="password" class="form-control" autocomplete="new-password">
                        </div>

                        <div class="form-group mb-0 text-right">
                            <button
                                data-success-callback="onSuccessUpdateUserPassword"
                                data-form="#Form_UpdateCurrentAdminPassword"
                                data-method="put"
                                type="submit"
                                data-url=""
                                class="btn btn-primary"
                            >{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Đóng') }}</button>
            </div>
        </div>
    </div>
</div>
