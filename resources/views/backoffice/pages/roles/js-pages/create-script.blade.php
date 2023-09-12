<script type="text/javascript">
    const ROLE_SETTING = {
        init: () => {
            ROLE_SETTING.onCheckAll();
            ROLE_SETTING.onCheckItem();
            ROLE_SETTING.onCheckAllForEachGroup();
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
                const parentKey = $(this).attr('parent-key');
                const childCheckboxes = $(`input[type=checkbox][parent-key="${parentKey}"]`);
                const numChildCheckboxes = childCheckboxes.length;
                const numCheckedChildCheckboxes = childCheckboxes.filter(':checked').length;

                if (numCheckedChildCheckboxes === 0) {
                    $(`input[id="${parentKey}"]`).prop('indeterminate', false).prop('checked', false);
                } else if (numCheckedChildCheckboxes === numChildCheckboxes) {
                    $(`input[id="${parentKey}"]`).prop('indeterminate', false).prop('checked', true);
                } else {
                    $(`input[id="${parentKey}"]`).prop('indeterminate', true).prop('checked', false);
                }
            });
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
