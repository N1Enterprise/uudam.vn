@extends('backoffice.layouts.master')

@php
	$title = __('Đánh giá sản phẩm');

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
    @include('backoffice.pages.product-reviews.partials.search-form')
    <div class="k-portlet k-portlet--mobile">
        <div class="k-portlet__head">
            <div class="k-portlet__head-label">
                <h3 class="k-portlet__head-title">
                    {{ __('Danh sách đánh giá sản phẩm') }}
                </h3>
            </div>
            @canAny(['product-reviews.store'])
            <div class="k-portlet__head-toolbar">
                <div class="k-portlet__head-toolbar-wrapper">
                    @can('product-reviews.store')
                    <a href="{{ route('bo.web.product-reviews.create') }}" class="btn btn-brand btn-bold btn-upper btn-font-sm">
                        <i class="la la-plus"></i>
                        {{ __('Tạo đánh giá') }}
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
                        <th data-property="user_name" data-render-callback="renderCallbackUserName">{{ __('Tên khách hàng') }}</th>
                        <th data-property="user_phone">{{ __('Số điện thoại') }}</th>
                        <th data-property="user_email">{{ __('E-mail') }}</th>
                        <th data-property="product.name" data-render-callback="renderCallbackProductName">{{ __('Tên sản phẩm') }}</th>
                        <th data-orderable="false" data-badge data-name="rating_type" data-property="rating_type_name">{{ __('Loại xếp hạng') }}</th>
                        <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Trạng thái') }}</th>
                        <th data-orderable="false" data-property="created_by.name">{{ __('Người tạo') }}</th>
                        <th data-orderable="false" data-property="updated_by.name">{{ __('Người cập nhật') }}</th>
                        <th data-property="created_at">{{ __('Ngày tạo') }}</th>
                        <th data-property="updated_at">{{ __('Ngày cập nhật') }}</th>
                        <th class="datatable-action" data-property="actions">{{ __('Hành động') }}</th>
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

            let confirmation = confirm("{{ __('Bạn có chắc chắn muốn xóa Đánh giá sản phẩm này ?') }}");

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
