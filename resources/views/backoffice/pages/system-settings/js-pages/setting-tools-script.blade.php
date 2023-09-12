@push('js_pages')
<script>
    handleClearCache();
    handleCreateGroup();
    handleCreateSettingKey();
    handleImportSetting();
    handleExportSetting();
    handleChangeSearch();
    handleAutoAppendSearchFromUrl();

    function handleClearCache() {
        const btnClearCache = $("#btn_clearCache");

        btnClearCache.on('click', function() {
            let confirmMsg = "{{ __('Confirm Clear Cache.') }}";
            let route = "{{ route('bo.api.system-settings.clear-cache') }}";

            if (confirm(confirmMsg)) {
                $.ajax({
                    url: route,
                    type: 'POST',
                    beforeSend: function() {
                        fscommon.disableButton(btnClearCache);
                    },
                    success: function() {
                        fstoast.success("{{ __('Clear Cache succeed!') }}");
                        fscommon.enableButton(btnClearCache);
                    },
                    error: function() {
                        fstoast.error("{{ __('Clear Cache fail!') }}");
                        fscommon.enableButton(btnClearCache);
                    }
                });
            }
        });
    }

    function handleCreateGroup() {
        const fromStoreGroup   = $("#from_storeGroup");
        const buttonStoreGroup = $("#button_storeGroup");

        fromStoreGroup.on('submit', function(e) {
            e.preventDefault();
            let route = fromStoreGroup.attr('action');
            let formData = {
                name: $(this).find("[name=name]").val(),
                order: $(this).find("[name=order]").val(),
            };

            $.ajax({
                url: route,
                type: 'POST',
                data: formData,
                success: function() {
                    fstoast.success("{{ __('Create Group succeed!') }}");
                    window.location.reload();
                },
                error: function() {
                    buttonStoreGroup.prop('disabled', false);
                    fstoast.error("{{ __('Create Group fail!') }}");
                }
            });
        });
    }

    function handleCreateSettingKey() {
        const fromStoreSettingKey   = $("#form_storeSettingKey");
        const buttonStoreSettingKey = $("#button_storeSettingKey");

        fromStoreSettingKey.on('submit', function(e) {
            e.preventDefault();
            let route = fromStoreSettingKey.attr('action');
            let formData = {
                group_id: $(this).find("[name=group_id]").val(),
                key: $(this).find("[name=key]").val(),
                label: $(this).find("[name=label]").val(),
                value_type: $(this).find("[name=value_type]").val(),
            };

            $.ajax({
                url: route,
                type: 'POST',
                data: formData,
                success: function() {
                    fstoast.success("{{ __('Create Setting Key succeed!') }}");
                    let params = new URLSearchParams(location.search);
                    params.set('tab', formData.group_id);
                    params.set('keyname', formData.key);
                    let newURL = location.pathname + '?' + params.toString();
                    window.history.pushState({ path: newURL }, '', newURL);
                    window.location.reload();
                },
                error: function() {
                    buttonStoreSettingKey.prop('disabled', false);
                    fstoast.error("{{ __('Create Setting Key fail!') }}");
                }
            });
        });
    }

    function handleImportSetting() {
        const formImportSettings   = $('#form_importSettings');
        const buttonImportSettings = $('#button_importSettings');

        formImportSettings.on('submit', function(e) {
            e.preventDefault();
            let route = formImportSettings.attr('action');
            let formData = {
                setting: $('[editor-input=import-system-setting]').val(),
                option: $(this).find("[name=option]:checked").val(),
            };

            $.ajax({
                url: route,
                type: 'POST',
                data: formData,
                success: function() {
                    fstoast.success("{{ __('Import Settings succeed!') }}");
                    window.location.reload();
                },
                error: function() {
                    buttonImportSettings.prop('disabled', false);
                    fstoast.error("{{ __('Import Settings fail!') }}");
                }
            });
        });
    }

    function handleExportSetting() {
        const btnExportSetting = $("#btn_export_setting");

        btnExportSetting.on('click', function() {
            let groups = JSON.parse($("#data_jsonGroup").attr('data-groups') ?? '{}');
            let jsonData = {};

            for(let groupIndex in groups) {
                let settings = [];
                if(groups[groupIndex]['system_settings']) {
                    for(let settingIndex in groups[groupIndex]['system_settings']) {
                        settings.push({
                            "key": groups[groupIndex]['system_settings'][settingIndex]['key'],
                            "label": groups[groupIndex]['system_settings'][settingIndex]['label'],
                            "value": groups[groupIndex]['system_settings'][settingIndex]['value'],
                            "value_type": groups[groupIndex]['system_settings'][settingIndex]['value_type'],
                            "order": groups[groupIndex]['system_settings'][settingIndex]['order'],
                        });
                    }
                }
                jsonData[groups[groupIndex]['name']] = settings;
            }

            setTimeout(function () {
                let dataStr = JSON.stringify(jsonData, null, 4);
                let dataUri = 'data:application/json;charset=utf-8,'+ encodeURIComponent(dataStr);
                let exportFileDefaultName = 'system-setting.json';
                let linkElement = document.createElement('a');
                linkElement.setAttribute('href', dataUri);
                linkElement.setAttribute('download', exportFileDefaultName);
                linkElement.click();
            });
        });
    }

    function handleChangeSearch() {
        let groups = JSON.parse($("#data_jsonGroup").attr('data-groups') ?? '{}');
        let timer;

        $('#input_searchSystemSetting').on('input', function() {
            clearTimeout(timer);
            let searchText = $(this).val().trim();

            if (!searchText) {
                // Show all system settings
                $('.system-setting-item').removeClass('d-none');
                $('.group-tab-item').removeClass('d-none');
                $('.sticky-top').removeClass('d-none');

                // Activate first tab and pane
                $('.group-tab-item').first().find('a').trigger('click');
                $('.system-setting-tab-pane').removeClass('active show');
                $('.system-setting-tab-pane').first().addClass('active show');
                return;
            }

            timer = setTimeout(function() {
                let selectedGroups = [];

                for (let groupIndex in groups) {
                    let systemSettings = groups[groupIndex]['system_settings'];

                    for (let settingIndex in systemSettings) {
                        let setting = systemSettings[settingIndex];
                        let key = setting['key'].toLowerCase();
                        let label = setting['label'] ? setting['label'].toLowerCase() : '';

                        if (key.includes(searchText) || label.includes(searchText)) {
                            selectedGroups.push(groups[groupIndex]['id']);
                            $('#' + setting['key'] + '_section').removeClass('d-none');
                        } else {
                            $('#' + setting['key'] + '_section').addClass('d-none');
                        }
                    }
                }

                selectedGroups = [...new Set(selectedGroups)]; // Remove duplicate group ids

                // Remove active class and hide all group tab right side
                $('.group-tab-item').removeClass('active').addClass('d-none');

                // Not active, hide system setting left side
                $('.system-setting-tab-pane').removeClass('active show');

                if (selectedGroups.length) {
                    $('.sticky-top').removeClass('d-none');

                    // Show group tab pane right side
                    for (let groupId of selectedGroups) {
                        $(`#group-tab-${groupId}`).removeClass('d-none');
                    }

                    // Activate first group searched (selectedGroups)
                    // Activate, show system setting left side
                    $(`#group-tab-${selectedGroups[0]}`).find('.section_groupSettingItem').trigger('click');
                    $(`#tab_${selectedGroups[0]}`).addClass('active show');
                } else {
                    $('.sticky-top').addClass('d-none');
                }
            }, 500);
        });
    }

    function handleAutoAppendSearchFromUrl() {
        const url = new URL(window.location.href);
        let urlParams = new URLSearchParams(window.location.search);
        let keyValue = urlParams.get('keyname');
        urlParams.delete('keyname');
        url.search = urlParams.toString();
        window.history.replaceState(null, 'keyname', url.toString());

        keyValue?.trim() && $('#input_searchSystemSetting').val(keyValue?.toLowerCase()).trigger('input');
    }
</script>
@endpush
