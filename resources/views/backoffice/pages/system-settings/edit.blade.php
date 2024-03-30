<div class="modal fade" id="modal_editSetting" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Edit Setting') }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="form_editSetting" method="POST" action="{{ route('bo.web.system-settings.update', ['id' => $systemSetting->id]) }}">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for="edit-group-id">{{ __('Group') }}</label>
                        <select name="group_id" id="edit-group-id" class="form-control">
                            <option value="" disabled>Choose Group</option>
                            @foreach($groups as $group)
                            <option value="{{ $group->id }}" {{ $group->id === $systemSetting->group_id ? 'selected' : '' }}>
                                {{ __(\Illuminate\Support\Str::title(str_replace('_',' ', $group->name))) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Key') }}</label>
                        <input type="text" class="form-control" name="key" disabled value="{{ $systemSetting->key }}">
                    </div>
                    <div class="form-group">
                        <label>{{ __('Label') }}</label>
                        <input type="text" class="form-control" name="label" value="{{ $systemSetting->label }}" placeholder="{{ __('Label') }}">
                    </div>
                    <div class="form-group">
                        <label>{{ __('Index') }}</label>
                        <input type="number" min="0" class="form-control" name="order" value="{{ $systemSetting->order }}" placeholder="{{ __('Index') }}">
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between align-items-center">
                    <button
                        type="button"
                        class="btn btn-danger actionBtn"
                        data-confirmable="{{ __('Are you sure you want to delete this setting?') }}"
                        data-success-message="{{ __('Delete setting key success.') }}"
                        data-method="DELETE"
                        data-url="{{ route('bo.api.system-settings.delete', ['id' => $systemSetting->id, 'tab' => $systemSetting->group_id]) }}"
                    >{{ __('Delete') }}</button>
                    <div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Đóng') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
