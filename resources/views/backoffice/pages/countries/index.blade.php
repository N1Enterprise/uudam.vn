@extends('backoffice.layouts.master')

@php
	$title = __('Countries');

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
                    {{ __('Countries') }}
                </h3>
            </div>
        </div>
        <div class="k-portlet__body">
            <table id="table_countries_index" data-searching="true" data-request-url="{{ route('bo.api.countries.index') }}" class="datatable table table-striped table-bordered table-hover table-checkable">
                <thead>
                    <tr>
                        <th data-property="id">{{ __('ID') }}</th>
                        <th data-property="name">Name</th>
                        <th data-property="iso3">Iso3</th>
                        <th data-property="numeric_code">Numeric Code</th>
                        <th data-property="iso2">Iso2</th>
                        <th data-orderable="false" data-badge data-name="status" data-property="status_name">{{ __('Status') }}</th>
                        <th data-property="phonecode">Phone Code</th>
                        <th data-property="capital">Capital</th>
                        <th data-property="currency">Currency</th>
                        <th data-property="currency_name">Currency Name</th>
                        <th data-property="currency_symbol">Currency Symbol</th>
                        <th data-property="tld">TLD</th>
                        <th data-property="native">Native</th>
                        <th data-property="region">Region</th>
                        <th data-property="subregion">Sub Region</th>
                        <th data-property="timezones">Time Zones</th>
                        <th data-property="translations">Translations</th>
                        <th data-property="latitude">Latitude</th>
                        <th data-property="longitude">Longitude</th>
                        <th data-property="emoji">Emoji</th>
                        <th data-property="emojiU">EmojiU</th>
                        <th data-property="flag">Flag</th>
                        <th data-property="wikiDataId">Wiki Data Id</th>
                        <th data-property="created_at">{{ __('Created At') }}</th>
                        <th data-property="updated_at">{{ __('Updated At') }}</th>
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
