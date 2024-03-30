<div class="col-lg-8 col-sm-8">
    @include('backoffice.partials.message')
    <div class="tab-content" id="content_systemSetting">
        @foreach ($groups as $group)
        <div

            id="tab_{{ data_get($group, 'id') }}"
            class="system-setting-tab-pane tab-pane fade {{ empty($tab) ? ( $loop->index + 1 == $loop->first ? 'active show' : '') : ($tab == data_get($group, 'id') ? 'active show' : '') }}"
        >
            <div class="k-portlet">
                <div class="k-portlet__head">
                    <div class="k-portlet__head-label">
                        <h3
                            class="k-portlet__head-title group-name"
                            data-pk="{{ data_get($group, 'id') }}"
                            data-type="text"
                            data-url="{{ route('bo.api.system-settings.group.update', data_get($group, 'id')) }}"
                            data-mode="inline"
                            data-name="name"
                            data-title="{{ __('Group Name') }}"
                        >
                            {{ __( data_get($group, 'name_display')) }}
                        </h3>
                    </div>
                </div>
                <div class="k-portlet__body">
                    <div class="row">
                        <div class="col-sm-12">
                            @foreach($group->systemSettings as $setting)
                            <div class="row system-setting-item {{ data_get($setting, 'value_type') }}" id="{{ data_get($setting, 'key') }}_section">
                                <div class="col-sm-12">
                                    <div class="row h-100">
                                        <div class="col-6 d-flex flex-column justify-content-center">
                                            <div class="d-flex align-items-center">
                                                <div class="btn_editSetting" data-route="{{ route('bo.web.system-settings.edit', data_get($setting, 'id')) }}">
                                                    <span>{{ __(data_get($setting, 'label_display')) }}</span>
                                                </div>
                                            </div>
                                            <div>
                                                <small class="copyable_settingKey text-lowercase text-muted" title="{{ __('Copy Clipboard.') }}">{{ data_get($setting, 'key') }}</small>
                                                @can('system-settings.update')
                                                <button
                                                    type="button"
                                                    class="btn_changeValueSetting btn btn-link btn-sm ml-2 p-0"
                                                    style="font-size: 0.8rem;"
                                                    data-setting-key="{{ data_get($setting, 'key') }}"
                                                    data-setting-valuetype="{{ data_get($setting, 'value_type') }}"
                                                >{{ __('Edit') }}</button>
                                                <button
                                                    type="button"
                                                    class="btn_cancelChangeValueSetting btn btn-link btn-sm ml-2 p-0 d-none"
                                                    style="font-size: 0.8rem;"
                                                    data-setting-key="{{ data_get($setting, 'key') }}"
                                                    data-setting-valuetype="{{ data_get($setting, 'value_type') }}"
                                                >{{ __('Cancel') }}</button>
                                                @if(data_get($setting, 'value_type') == 'json')
                                                <button
                                                    type="button"
                                                    class="btn_updateValueSetting section_settingAction btn-sm p-0 d-none btn btn-link"
                                                    style="font-size: 0.8rem;"
                                                    data-setting-key="{{ data_get($setting, 'key') }}"
                                                >{{ __('Save') }}</button>
                                                @endif
                                                @endcan
                                            </div>
                                        </div>
                                        <div class="{{ data_get($setting, 'value_type') == 'json' ? 'col-12' : 'col-6' }}">
                                            <div class="content-value h-100 d-flex align-items-start flex-column justify-content-center">
                                                <div class="{{ data_get($setting, 'value_type') == 'json' ? 'h-100 w-100' : 'w-100' }}">
                                                    @if(in_array(data_get($setting, 'value_type'), array_keys($settingTypes)))
                                                    @include('backoffice.pages.system-settings.partials.datatype.' . data_get($setting, 'value_type'))
                                                    @endif
                                                </div>
                                                @if(data_get($setting, 'value_type') != 'json')
                                                <div>
                                                    @can('system-settings.update')
                                                    <div class="section_settingAction" data-setting-key="{{ data_get($setting, 'key') }}">
                                                        <div class="d-flex justify-content-end">
                                                            <button
                                                                type="button"
                                                                class="btn_cancelChangeValueSetting btn btn-link btn-sm p-0 mr-2"
                                                                style="font-size: 0.8rem;"
                                                                data-setting-key="{{ data_get($setting, 'key') }}"
                                                                data-setting-valuetype="{{ data_get($setting, 'value_type') }}"
                                                            >{{ __('Cancel') }}</button>
                                                            <button
                                                                type="button"
                                                                class="btn_updateValueSetting btn btn-link p-1"
                                                                style="font-size: 0.8rem;"
                                                                data-setting-key="{{ data_get($setting, 'key') }}"
                                                            >{{ __('Save') }}</button>
                                                        </div>
                                                    </div>
                                                    @endcan
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
