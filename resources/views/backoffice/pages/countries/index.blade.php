@extends('backoffice.layouts.master')

@php
	$title = __('Quốc gia');

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
    <div class="k-portlet k-portlet--mobile">
        <div class="k-portlet__head">
            <div class="k-portlet__head-label">
                <h3 class="k-portlet__head-title">
                    {{ __('Danh sách quốc gia') }}
                </h3>
            </div>
        </div>
        <div class="k-portlet__body">
            <table id="table_countries_index" data-searching="true" data-request-url="{{ route('bo.api.countries.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th data-property="id">{{ __('ID') }}</th>
                        <th data-property="name">{{ __('Tên') }}</th>
                        <th data-property="iso3">{{ __('ISO3') }}</th>
                        <th data-property="numeric_code">{{ __('Mã số') }}</th>
                        <th data-property="iso2">{{ __('ISO2') }}</th>
                        <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Trạng thái') }}</th>
                        <th data-property="phonecode">{{ __('Mã điện thoại') }}</th>
                        <th data-property="capital">{{ __('Thủ đô') }}</th>
                        <th data-property="currency">{{ __('Tiền tệ') }}</th>
                        <th data-property="currency_name">{{ __('Tên tiền tệ') }}</th>
                        <th data-property="currency_symbol">{{ __('Ký hiệu tiền tệ') }}</th>
                        <th data-property="tld">{{ __('TLD') }}</th>
                        <th data-property="native">{{ __('Native') }}</th>
                        <th data-property="region">{{ __('Region') }}</th>
                        <th data-property="subregion">{{ __('Sub Region') }}</th>
                        <th data-property="timezones">{{ __('Time Zones') }}</th>
                        <th data-property="translations">{{ __('Translations') }}</th>
                        <th data-property="latitude">{{ __('Vĩ độ') }}</th>
                        <th data-property="longitude">{{ __('Kinh độ') }}</th>
                        <th data-property="emoji">{{ __('Emoji') }}</th>
                        <th data-property="emojiU">{{ __('EmojiU') }}</th>
                        <th data-property="flag">{{ __('Flag') }}</th>
                        <th data-property="wikiDataId">{{ __('Wiki Data Id') }}</th>
                        <th data-property="created_at">{{ __('Ngày tạo') }}</th>
                        <th data-property="updated_at">{{ __('Ngày cập nhật') }}</th>
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
    function renderLogoImage(data, type, full) {
        const image = $('<img>', {
            src: data,
            width: 80,
            height: 80,
        });

        return image.prop('outerHTML');
    }
</script>
@endsection
