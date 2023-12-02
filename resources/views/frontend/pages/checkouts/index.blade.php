@extends('frontend.layouts.checkout')

@section('style')
<link href="{{ asset('vendor/validate/styles.css') }}" rel="stylesheet" type="text/css" />
<style>
    input:disabled,
    select:disabled {
        background: #f9f9f9;
    }
</style>
@endsection

@section('content_body')
@include('frontend.pages.checkouts.partials.payment')
@include('frontend.pages.checkouts.partials.items')
@endsection

@section('js_scipt')
<script src="{{ asset('frontend/assets/js/common/main.js') }}" type="text/javascript"></script>
<script src="{{ asset('frontend/assets/js/utils/helpers.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/validate/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/validate/custom.js') }}" type="text/javascript"></script>
<script src="{{ mix('frontend/bundle/js/checkout/index.min.js') }}" type="text/javascript"></script>
@endsection
