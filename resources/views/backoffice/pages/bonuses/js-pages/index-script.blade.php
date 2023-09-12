<script>
    $('.datatable').find('th.datatable-action').attr('data-action-icon-pack', JSON.stringify({
        activate: '<button class="btn btn-font-accent btn-icon">A</button>',
        deactivate: '<button class="btn btn-font-danger btn-icon">D</button>',
        clone: '<i class="la la-clone"></i>',
    }))

    $(document).ready(function() {
        $(document).on('click', '[data-action=deactivate], [data-action=activate]', function(e) {
            e.preventDefault();

            let confirmResult = confirm("{{ __('Are you sure?') }}")

            if(confirmResult) {
                $.ajax({
                    url: $(this).attr('href'),
                    method: 'put',
                    preventRedirectOnComplete: true,
                }).done(function(response) {
                    $('#index_bonus_table').DataTable().ajax.reload()
                });
            }
        })
    });

    function renderStatusCallback(data, type, full, meta) {

        let renderValue = data;

        if (full?.finish_status != 1) {
            renderValue = full?.finish_status_name;
        }

        return $('<div>').append(generateBadgeElement(renderValue)).html();
    }
</script>
