<div class="modal fade" id="modal_importSettings" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Import Setting') }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="form_importSettings" method="POST" action="{{ route('bo.api.system-settings.import') }}">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label>
                            {{ __('Thiết lập hệ thống') }}
                            <a data-toggle="collapse" href="#class_hint">
                                <i class="la flaticon-light"></i>
                            </a>
                        </label>
                        <div class="form-group class_hint_group collapse" id="class_hint">
                            <div class="k-section__content k-section__content--border">
                                <div class="card card-body" id="class_hint_content" style="white-space:pre; overflow: scroll;"></div>
                            </div>
                        </div>
                        <div
                            class="json_editor"
                            style="height: 200px"
                            editor-id="import-system-setting"
                            editor-minlines="15"
                            editor-maxlines="35"
                            editor-editable="enabled"
                        >
                        </div>
                        <input type="hidden" name="setting" editor-input="import-system-setting" value="{}">
                    </div>
                    <div class="form-group form-group-marginless">
                        <label>{{ __('Option') }}</label>
                        <div class="row">
                            @foreach ($importOption as $optionKey => $optionLabel)
                            <div class="col-lg-4">
                                <label class="k-option p-3">
                                    <span class="k-option__control">
                                        <span class="k-radio k-radio--check-bold">
                                            <input type="radio" name="option" value="{{ $optionKey }}" {{ $optionKey == 'merge' ? 'checked' : '' }}>
                                            <span></span>
                                        </span>
                                    </span>
                                    <span class="k-option__label">
                                        <span class="k-option__head">
                                            <span class="k-option__title">
                                                {{ __($optionLabel) }}
                                            </span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Đóng') }}</button>
                    <button id="button_importSettings" type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
