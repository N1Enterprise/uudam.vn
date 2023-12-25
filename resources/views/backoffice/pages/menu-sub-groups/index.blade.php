@extends('backoffice.layouts.master')

@php
	$title = __('Menu Sub Group');

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
                        {{ __('Menu Sub Group') }}
                    </h3>
                </div>
                @canAny(['menu-sub-groups.store'])
                <div class="k-portlet__head-toolbar">
                    <div class="k-portlet__head-toolbar-wrapper">
                        @can('menu-sub-groups.store')
                        <a href="{{ route('bo.web.menu-sub-groups.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                            <i class="la la-plus"></i>
                            {{ __('Create Menu Sub Group') }}
                        </a>
                        @endcan
                    </div>
                </div>
                @endcan
            </div>
            <div class="k-portlet__body">
                <table id="table_mennu_sub_groups_index" data-searching="true" data-request-url="{{ route('bo.api.menu-sub-groups.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                    <thead>
                        <tr>
                            <th data-property="id">{{ __('ID') }}</th>
                            <th data-property="name">{{ __('Name') }}</th>
                            <th data-orderable="false" data-property="menu_group.name">{{ __('Group') }}</th>
                            <th data-link="redirect_url" data-link-target="_blank" data-property="redirect_url">{{ __('Redirect Url') }}</th>
                            <th data-property="order">{{ __('Order') }}</th>
                            <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Status') }}</th>
                            <th data-orderable="false" data-badge data-name="display_on_frontend" data-property="display_on_frontend_name">{{ __('FE Display') }}</th>
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

            let confirmation = confirm("{{ __('Are you sure you want to delete this Menu Sub Group?') }}");

            if(!confirmation) {
                return;
            }

            $.ajax({
                url: $(this).attr('href'),
                method: 'delete',
                preventRedirectOnComplete: 1,
                success: function(res) {
                    $('#table_mennu_sub_groups_index').DataTable().ajax.reload()
                }
            });
        });
    }
</script>
@endsection
