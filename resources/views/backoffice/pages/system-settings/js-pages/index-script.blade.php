<script>
    setImportHint();
    handleChangeValueSetting();
    handleChangeSwitch();
    handleChangeUrlByTabKey();
    handleShowEditModal();
    hanleUpdateSetting();
    handleEditGroupName();
    handleCopySettingKey();
    handleInputmask();

    var systemSettingEditor = initJsonEditor();

    const SYSTEM_SETTING_KEY = {
        json: 'json',
        string: 'string',
        number: 'number',
        datetime: 'datetime',
        boolean: 'boolean'
    };

    function handleChangeValueSetting() {
        $('.btn_changeValueSetting').on('click', function() {
            let settingKey = $(this).attr('data-setting-key');
            let valueType  = $(this).attr('data-setting-valuetype');
            toggleChangeValueSetting(settingKey, valueType, true);
        });

        $('.btn_cancelChangeValueSetting').on('click', function() {
            let settingKey = $(this).attr('data-setting-key');
            let valueType  = $(this).attr('data-setting-valuetype');
            handleResetValueSetting(settingKey, valueType);
            toggleChangeValueSetting(settingKey, valueType, false);
        });

        $('.btn_updateValueSetting').on('click', function() {
            handleUpdateValueSetting(this);
        });
    }

    function handleResetValueSetting(settingKey, valueType) {
        let originValue = getOriginalSettingValue(settingKey);

        if (valueType === SYSTEM_SETTING_KEY.json) {
            editorHelper(systemSettingEditor[settingKey]).resetValue();
        } else if (valueType === SYSTEM_SETTING_KEY.boolean) {
            $(`.switch-item[data-setting-key=${settingKey}]`).prop('checked', originValue === 'on');
        } else if (valueType === SYSTEM_SETTING_KEY.number) {
            $(`[data-inputmask-ref=${settingKey}]`).val(originValue);
            $(`input[id=${settingKey}]`).val(originValue);
        } else {
            $(`input[id=${settingKey}]`).val(originValue);
        }
    }

    function toggleChangeValueSetting(settingKey, valueType, isOpen = true) {
        $(`.section_settingAction[data-setting-key=${settingKey}]`).toggleClass('d-inline-block', isOpen);
        $(`.btn_changeValueSetting[data-setting-key=${settingKey}]`).toggleClass('d-none', isOpen);
        $(`.btn_cancelChangeValueSetting[data-setting-key=${settingKey}]`).toggleClass('d-none', !isOpen);

        SYSTEM_SETTING_KEY.json === valueType
            ? editorHelper(systemSettingEditor[settingKey]).editable(isOpen)
            : $(`.section_settingValue[data-setting-key=${settingKey}]`).toggleClass('d-none', isOpen);
    }

    function handleChangeSwitch() {
        $('.switch-item').on('change', function() {
            let settingKey  = $(this).attr('data-setting-key');
            $('#' + settingKey).val(
                $(this).is(':checked') ? 'on' : 'off'
            );
        });
    }

    function handleChangeUrlByTabKey() {
        $('.section_groupSettingItem').on('click', function() {
            let tabKey = $(this).attr('data-tab');
            let params = new URLSearchParams(location.search);
            params.set('tab', tabKey);
            let newURL = location.pathname + '?' + params.toString();
            window.history.pushState({ path: newURL }, '', newURL);
        });
    }

    function handleUpdateValueSetting(target) {
        let settingKey = $(target).attr('data-setting-key');
        let settingVal = $(`[name=${settingKey}]`).val();

        if (confirm("{{ __('Xác nhận giá trị cài đặt cập nhật.') }}")) {
            $.ajax({
                url: "{{ route('bo.api.system-settings.update-key') }}",
                type: 'PUT',
                data: {
                    key: settingKey,
                    value: settingVal
                },
                beforeSend: function() {
                    $(target).prop('disabled', true);
                },
                success: function({ value_type } = {}) {
                    fstoast.success("{{ __('Update setting value success.') }}");
                    $(target).prop('disabled', false);

                    handleChangeDisplayValue(settingKey, value_type, settingVal);
                    toggleChangeValueSetting(settingKey, value_type, false);
                },
                error: function() {
                    fstoast.error("{{ __('Update setting value fail.') }}");
                    $(target).prop('disabled', false);
                }
            });
        }
    }

    function handleChangeDisplayValue(settingKey, valueType, value) {
        let displaySettingValue = $(`.display_settingValue[data-setting-key=${settingKey}]`);

        displaySettingValue.toggleClass('text-secondary', !value);
        displaySettingValue.toggleClass('text-success', valueType === SYSTEM_SETTING_KEY.boolean && value === 'on');
        displaySettingValue.toggleClass('text-muted', valueType === SYSTEM_SETTING_KEY.boolean && value === 'off');

        if (valueType === SYSTEM_SETTING_KEY.json) {
            editorHelper(systemSettingEditor[settingKey]).editable(false);
            editorHelper(systemSettingEditor[settingKey]).setValue(value);
        } else {
            if (valueType === SYSTEM_SETTING_KEY.boolean) {
                $(`.switch-item[data-setting-key=${settingKey}]`).attr('data-origin', value);
            }

            value = valueType === SYSTEM_SETTING_KEY.datetime
                ? value ? moment(value).format('YYYY-MM-DD HH:mm') : "{{ __('N/A') }}"
                : value || "{{ __('N/A') }}";

            $(`input[name=${settingKey}]`).attr('data-origin', value);

            displaySettingValue.text(value);

            if (valueType === SYSTEM_SETTING_KEY.number && +value) {
                inputmaskSetter(displaySettingValue, function($el) {
                    $el.val(value);
                });
            }
        }
    }

    function handleShowEditModal() {
        $('.btn_editSetting').on('click', function() {
            $.ajax({
                url: $(this).attr('data-route'),
                type: 'GET',
                beforeSend: () => {
                    $(this).addClass('disabled');
                },
                success: (response) => {
                    $('.section_editSystemSettingModal').html(response);
                    $('.section_editSystemSettingModal #modal_editSetting').modal('show');
                    $(this).removeClass('disabled');
                },
                error: () => {
                    fstoast.error("{{ __('Can \'t show system setting.') }}");
                    $(this).removeClass('disabled');
                }
            });
        });
    }

    function hanleUpdateSetting() {
        $(document).on('submit', '#form_editSetting', function(e){
            e.preventDefault();

            let form = $(this);
            let formData = new FormData(form[0]);

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function() {
                    fstoast.success("{{ __('Update system setting success.') }}");
                    $('#form_editSetting button[type="submit"]').prop('disabled', false);
                    window.location.reload();
                },
                error: function() {
                    fstoast.error("{{ __('Update system setting fail.') }}");
                }
            });
        });
    }

    function handleEditGroupName() {
        $('.group-name').editable({
            success: function(response, newValue) {
                $('#group-'+response.id).text(response.name_display);
            }
        });
    }

    function handleCopySettingKey() {
        $('.copyable_settingKey').click(function() {
            copyToClipboard($(this).text());
            fstoast.success("{{ __('Đã sao chép !') }}");
        });
    }

    function initJsonEditor() {
        let instances = {};

        for (const $editor of [...$('.json_editor')]) {
            let editorId  = $($editor).attr('editor-id');
            let editorInput = $(`input[name=${editorId}]`);
            let editable = $($editor).attr('editor-editable');
            let editorMinlines = +($($editor).attr('editor-minlines')) || null;
            let editorMaxlines = +($($editor).attr('editor-minlines')) || null;

            editorInput = editorInput?.length
                ? editorInput
                : $(`[editor-input=${editorId}]`);

            let instance = ace.edit($editor, {
                mode: 'ace/mode/json',
                value: editorInput.val() != '[]' ? editorInput.val() : '{}',
                minLines: editorMinlines,
                maxLines: editorMaxlines,
            });
            instance.original = { value: editorInput.val() };
            instance.session.on('change', function() {
                editorInput.val(instance.getValue());
            });

            editorHelper(instance).editable(editable === 'enabled');

            instances[editorId] = instance;
        }

        return instances;
    }

    function editorHelper(instance) {
        return {
            editable: (editable) => {
                instance.setOptions({
                    theme: editable ? 'ace/theme/tomorrow' : 'ace/theme/clouds',
                    wrap: editable ? false : true,
                });
                instance.setReadOnly(!editable);
            },
            setValue: (value) => {
                instance.setOptions({ value: value != '[]' ? value : '{}' });
                instance.original = { value: value };
            },
            resetValue: () => {
                let originValue = instance.original.value;
                instance.setOptions({ value: originValue });
            }
        }
    };

    function getOriginalSettingValue(settingKey) {
        return $(`[data-origin][name=${settingKey}]`)
            .attr('data-origin') || null;
    }

    function setImportHint() {
        let settings = {
            "Group Name": [
                {
                    "key": "Setting Key",
                    "label": "Setting Label",
                    "value": "Setting Value",
                    "value_type": "Setting Value Type ('boolean', 'datetime', 'number', 'string', 'json')",
                    "order": "Setting Order Number"
                }
            ]
        };
        $('.class_hint_group').removeClass('d-none');
        $('#class_hint_content').html(JSON.stringify(settings, null, 4));
    }

    function inputmaskSetter($el, cb = () => undefined) {
        $el.inputmask({
            alias: 'numeric',
            groupSeparator: '.',
            autoGroup: true,
            digitsOptional: true,
            clearMaskOnLostFocus: false,
            digits: 2,
            allowMinus: false,
            rightAlign: false,
        });

        return cb($el);
    }

    function handleInputmask() {
        $.each($('.inputmask'), function(index, input) {
            let name = $(this).attr('name');
            let value = $(this).val();

            $(this).addClass('d-none');
            $(this).parent().prepend(
                $(`<input data-inputmask-ref=${name} class="form-control">`).val(value)
            );

            +value && inputmaskSetter($(`.display_settingValue[data-setting-key=${name}]`));
            inputmaskSetter($(`[data-inputmask-ref=${name}]`), ($el) => {
                $el.on('keyup', () => $(`[name=${name}]`).val($el.inputmask('unmaskedvalue')));
            });
        });
    }
</script>
