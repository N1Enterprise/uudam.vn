<div class="modal fade" id="modal_storeSettingKey" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Create Setting') }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="form_storeSettingKey" method="POST" action="{{ route('bo.api.system-settings.create-key') }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('Group name') }}</label>
                        <select class="form-control" style="text-transform: capitalize" required name="group_id">
                            @foreach($groups as $group)
                            <option value="{{ data_get($group, 'id') }}">{{ __(str_replace('_',' ', data_get($group, 'name'))) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('Setting Key') }}</label>
                        <input type="text" maxlength="255" required class="form-control" name="key" placeholder="{{ __("Setting Key") }}">
                    </div>
                    <div class="form-group">
                        <label>{{ __('Label') }}</label>
                        <input type="text" required class="form-control" name="label" placeholder="{{ __("Label") }}">
                    </div>
                    <div class="form-group">
                        <label>{{ __('Type') }}</label>
                        <select class="form-control" style="text-transform: capitalize" name="value_type">
                            @foreach($settingTypes as $type => $label)
                            <option value="{{ $type }}">{{ __($label) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Đóng') }}</button>
                    <button id="button_storeSettingKey" type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
