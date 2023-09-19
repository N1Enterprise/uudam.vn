@extends('backoffice.layouts.master')

@php
	$title = __('Inventory');

	$breadcrumbs = [
		[
			'label' => $title,
		],
		[
			'label' => __('Add Inventory'),
		]
	];
@endphp

@section('header')
	{{ __($title) }}
@endsection

@component('backoffice.partials.breadcrumb', ['items' => $breadcrumbs]) @endcomponent

@section('content_body')
@endsection
