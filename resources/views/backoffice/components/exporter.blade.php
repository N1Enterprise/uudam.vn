<a href="javascript:;" class="{{ $class }}" id="{{ $exporter }}" >
    <i class="{{ $icon }}"></i>
    {{ $label }}
</a>

@push('js_pages')
<script>
    const exporter      = "{{ $exporter }}";
    const limitExport   = "{{ config('stevephamhi_core.export.export_limit') }}";
    const errorLimitMsg = "{{ __('The limit export is '.config('stevephamhi_core.export.export_limit').' items.') }}";

    $("a#{{ $exporter }}").on('click', function(e) {
        const datatableID = '{{ $datatable }}';

        if ($('{{ $datatable }}').DataTable().page.info().recordsTotal > limitExport) {
            fstoast.error(errorLimitMsg);
            return;
        }

        let dtUrl       = $(datatableID).DataTable().ajax.url();
        let queryString = dtUrl.split('?')[1] ?? '';
        let queryParams = {};

        if (!isEmpty(queryString)){
            queryString.split('&')
                .map(p => {
                    let splitted = p.split('=')
                    let field     = decodeURIComponent(splitted[0])
                    let val      = decodeURIComponent(splitted[1])

                    if (field.includes('[]')) {
                        field = field.replace('[]', '')
                        queryParams[field] = (queryParams[field] ?? []).concat([val]);
                    } else {
                        queryParams[field] = val;
                    }
                });
        }

        let url      = $("#{{ $exporter }}_export_form").attr('action');
        let dtParams = $(datatableID).DataTable().ajax.params();
        let params   = Object.assign({}, queryParams, dtParams);

        var data = {
            "form" : params,
            'page' : $('#page').val()
        };

        $.ajax({
            url,
            method: 'GET',
            data: data,
            success: function(response) {
                $("#redirect").val(response);
                $('#{{ $exporter }}_export_modal').modal('show');
            },
            beforeSend: function(response) {
                fscommon.blockPageUI();
            }
        });
    });

    $(document).on('submit', '#{{ $exporter }}_export_form', function(e) {
        e.preventDefault();
        window.location.href = $("#redirect").val();
    });
</script>
@endpush

@push('modals')
<div class="modal fade" id="{{ $exporter }}_export_modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 30%!important" role="document">
        <div class="modal-content" style="border:none;">
			<form id="{{ $exporter }}_export_form" action="{{ $exportUrl ?? route("bo.web.${exporter}.export.csv") }}" method="get">
				<div class="modal-header" style="background-color: #5867dd;">
					<h5 class="modal-title" style="color: white;">{{ __('Export File is being processing...') }}</h5>
				</div>
				<div class="modal-body" style="background-color: white;">
					<div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
						{{__("Report exporting process has begun. Once complete, you can download the report by clicking the 'Download' button at Export History list. Redirect to 'Export History' page?")}}
					</div>
					<input type="hidden" id="page" value="{{ $exportPage ?? $exporter }}">
					<input type="hidden" id="redirect" value="">
				</div>
				<div class="modal-footer" style="border-top: none;">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" style="width: 20%;">{{ __('No') }}</button>
					<button type="submit" class="btn btn-primary" style="width: 20%;">{{ __('Yes') }}</button>
				</div>
			</form>
        </div>
    </div>
</div>
@endpush
