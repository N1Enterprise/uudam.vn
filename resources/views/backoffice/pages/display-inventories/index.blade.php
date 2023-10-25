@extends('backoffice.layouts.master')

@php
	$title = __('Display Inventory');

	$breadcrumbs = [
		[
			'label' => $title,
		]
	];
@endphp

@section('header')
    {{ __($title) }}
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
    <div class="k-content__body	k-grid__item k-grid__item--fluid" id="k_content_body">
        @include('backoffice.pages.display-inventories.partials.index-search-form');
        <div class="k-portlet k-portlet--mobile">
            <div class="k-portlet__head">
                <div class="k-portlet__head-label">
                    <h3 class="k-portlet__head-title">
                        {{ __('Display Inventory') }}
                    </h3>
                </div>
                <div class="k-portlet__head-toolbar">
                    <div class="k-portlet__head-toolbar-wrapper">
                        @can('display-inventories.store')
                        <a href="javascript:void(0)" class="btn btn-brand btn-bold btn-upper btn-font-sm" data-toggle="modal" data-target="#modal_select_display_type">
                            <i class="la la-plus"></i>
                            {{ __('Create Display Inventory') }}
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="k-portlet__body">
                <table id="table_display_inventories_index" data-searching="true" data-request-url="{{ route('bo.api.display-inventories.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                    <thead>
                        <tr>
                            <th data-property="id">{{ __('ID') }}</th>
                            <th data-orderable="false" data-property="inventory.title">{{ __('Inventory') }}</th>
                            <th data-name="type" data-property="type_name">{{ __('Display Type') }}</th>
                            <th data-property="order">{{ __('Order') }}</th>
                            <th data-property="redirect_url">{{ __('Redirect URL') }}</th>
                            <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Status') }}</th>
                            <th data-property="created_at">{{ __('Created At') }}</th>
                            <th data-property="updated_at">{{ __('Updated At') }}</th>
                            <th class="datatable-action" data-property="actions">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@component('backoffice.partials.datatable') @endcomponent

@can('display-inventories.store')
@push('modals')
<div class="modal fade" id="modal_select_display_type" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="" id="form_select_display_type">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border:none;">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ __('Create Display Inventory') }}
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('Select Display Type') }}</label>
                        <select name="display_type" title="--{{ __('Select Display Type') }}--" class="form-control k_selectpicker">
                            @foreach ($displayInventoryTypeEnumLabels as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary" id="btn_select_display_type">{{ __('Submit') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endpush
@endcan

@section('js_script')
<script>
    onDelete();
    onSelectDisplayType();

    function onDelete() {
        $(document).on('click', '[data-action=delete]', function(e) {
            e.preventDefault();

            let confirmation = confirm("{{ __('Are you sure you want to delete this Display Inventory?') }}");

            if(!confirmation) {
                return;
            }

            $.ajax({
                url: $(this).attr('href'),
                method: 'delete',
                preventRedirectOnComplete: 1,
                success: function(res) {
                    $('#table_display_inventoris_index').DataTable().ajax.reload()
                }
            });
        });
    }

    function onSelectDisplayType() {
        $('#form_select_display_type').on('submit', function(e) {
            e.preventDefault();

            const type = $('#modal_select_display_type').find('[name="display_type"]').val();
            const route = "{{ route('bo.web.display-inventories.create', ':type') }}".replace(':type', type);

            window.location.href = route;
        });
    }
</script>
@endsection
