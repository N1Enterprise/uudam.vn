@extends('backoffice.layouts.master')

@php
	$title = __('Menu');

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
        @include('backoffice.partials.message')
        <div class="k-portlet k-portlet--mobile">
            <div class="k-portlet__head">
                <div class="k-portlet__head-label">
                    <h3 class="k-portlet__head-title">
                        {{ __('Menu') }}
                    </h3>
                </div>
                @canAny(['menus.store'])
                <div class="k-portlet__head-toolbar">
                    <div class="k-portlet__head-toolbar-wrapper">
                        @can('menus.store')
                        <a href="{{ route('bo.web.menus.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                            <i class="la la-plus"></i>
                            {{ __('Create Menu') }}
                        </a>
                        @endcan
                    </div>
                </div>
                @endcan
            </div>
            <div class="k-portlet__body">
                <table id="table_mennus_index" data-searching="true" data-request-url="{{ route('bo.api.menus.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                    <thead>
                        <tr>
                            <th data-property="id">{{ __('ID') }}</th>
                            <th data-property="name">{{ __('Name') }}</th>
                            <th data-orderable="false" data-badge data-name="type" data-property="type_name">{{ __('Type') }}</th>
                            <th data-property="order">{{ __('Order') }}</th>
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

@section('js_script')
<script>
    onDelete();

    function onDelete() {
        $(document).on('click', '[data-action=delete]', function(e) {
            e.preventDefault();

            let confirmation = confirm("{{ __('Are you sure you want to delete this Menu?') }}");

            if(!confirmation) {
                return;
            }

            $.ajax({
                url: $(this).attr('href'),
                method: 'delete',
                preventRedirectOnComplete: 1,
                success: function(res) {
                    $('#table_mennus_index').DataTable().ajax.reload()
                }
            });
        });
    }
</script>
@endsection
