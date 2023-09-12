<script type="text/javascript">
    const ROLE_SETTING = {
        init: () => {
            ROLE_SETTING.onCheckAll();
            ROLE_SETTING.onCheckItem();
            ROLE_SETTING.onCheckAllForEachGroup();
            $('input[type=checkbox].permission-checkbox').trigger('change');
        },
        onCheckAll: () => {
            $('#checkable_checkall').on('change', function() {
                $('ul#m_nav input[type=checkbox]')
                    .prop('checked', $(this).is(':checked'))
                    .prop('indeterminate', false);
            });
        },
        onCheckItem: () => {
            $('input[type=checkbox]').on('change', function() {
                let parentCheckbox = $(`input[id="${$(this).attr('parent-key')}"]`);

                while(parentCheckbox.length) {
                    let parentKey = parentCheckbox.attr('id');
                    let hasUncheckedBoxes = $(`input[type=checkbox][parent-key="${parentKey}"]:not(:checked)`).length;
                    let hasCheckedBoxes = $(`input[type=checkbox][parent-key="${parentKey}"]:checked`).length;
                    let hasIndeterminateBoxes = $(`input[type=checkbox][parent-key="${parentKey}"]:indeterminate`).length;

                    if (hasCheckedBoxes && hasUncheckedBoxes) {
                        parentCheckbox.prop('indeterminate', true);
                        parentCheckbox.prop('checked', false);
                    } else if (hasCheckedBoxes && ! hasUncheckedBoxes) {
                        parentCheckbox.prop('indeterminate', false);
                        parentCheckbox.prop('checked', true);
                    } else if (!hasCheckedBoxes && hasUncheckedBoxes) {
                        parentCheckbox.prop('indeterminate', false);
                        parentCheckbox.prop('checked', false);
                    }

                    if (hasIndeterminateBoxes) {
                        parentCheckbox.prop('indeterminate', true);
                        parentCheckbox.prop('checked', false);
                    }

                    parentCheckbox = $(`input[id="${parentCheckbox.attr('parent-key')}"]`)
                }
            })
        },
        onCheckAllForEachGroup: () => {
            $('input.collapser-input').on('change', function() {
                $(this).closest('li.collapser')
                    .find('ul.collapse input[type=checkbox]')
                    .prop('checked', $(this).is(':checked'))
                    .prop('indeterminate', false)
            })
        },
    };


    ROLE_SETTING.init();
</script>
