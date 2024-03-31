<div class="modal fade" id="modal_storeGroup" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Create Group') }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="from_storeGroup" method="POST" action="{{ route('bo.api.system-settings.create-group') }}">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>{{ __('Group name') }} *</label>
                        <input type="text" maxlength="255" required class="form-control" name="name">
                    </div>

                    <div class="form-group">
                        <label>{{ __('Thứ tự') }}</label>
                        <input type="number" class="form-control" name="order">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Đóng') }}</button>
                    <button id="button_storeGroup" type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
