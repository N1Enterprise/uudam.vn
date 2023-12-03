@extends('backoffice.layouts.master')

@php
	$title = __('Product Review');

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
    @include('backoffice.pages.product-reviews.partials.search-form');
    <div class="k-portlet k-portlet--mobile">
        <div class="k-portlet__head">
            <div class="k-portlet__head-label">
                <h3 class="k-portlet__head-title">
                    {{ __('Product Review') }}
                </h3>
            </div>
            @canAny(['product-reviews.store'])
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    @can('product-reviews.store')
                    <a href="{{ route('bo.web.product-reviews.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                        <i class="la la-plus"></i>
                        {{ __('Create Product Review') }}
                    </a>
                    @endcan
                </div>
            </div>
            @endcan
        </div>
        <div class="k-portlet__body">
            <table id="table_product_reviews_index" data-searching="true" data-request-url="{{ route('bo.api.product-reviews.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th data-property="id">{{ __('ID') }}</th>
                        <th data-property="user_name" data-render-callback="renderCallbackUserName">{{ __('User Name') }}</th>
                        <th data-property="user_phone">{{ __('User Phone') }}</th>
                        <th data-property="user_email">{{ __('User Email') }}</th>
                        <th data-property="product.name" data-render-callback="renderCallbackProductName">{{ __('Product Name') }}</th>
                        <th data-orderable="false" data-badge data-name="rating_type" data-property="rating_type_name">{{ __('Rating Type') }}</th>
                        <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Status') }}</th>
                        <th data-orderable="false" data-property="created_by.name">{{ __('Created By') }}</th>
                        <th data-orderable="false" data-property="updated_by.name">{{ __('Updated By') }}</th>
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

    function renderCallbackProductName(data, type, full) {
        const href = $('<a>', {
            href: "{{ route('bo.web.products.edit', ':id') }}".replace(':id', full.id),
            target: '_blank',
            text: data
        });

        return href.prop('outerHTML');
    }

    function renderCallbackUserName(data, type, full) {
        const div = $('<div>').append(`
            <span>${data}</span> ${full.is_real_user ? '<b>[REAL]</b>' : ''}
        `);

        return div.prop('outerHTML');
    }

    function onDelete() {
        $(document).on('click', '[data-action=delete]', function(e) {
            e.preventDefault();

            let confirmation = confirm("{{ __('Are you sure you want to delete this Product Review?') }}");

            if(!confirmation) {
                return;
            }

            $.ajax({
                url: $(this).attr('href'),
                method: 'delete',
                preventRedirectOnComplete: 1,
                success: function(res) {
                    $('#table_product_reviews_index').DataTable().ajax.reload()
                }
            });
        });
    }
</script>
@endsection
