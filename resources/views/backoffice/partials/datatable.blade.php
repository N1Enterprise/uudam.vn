@section('style_datatable')
<link href="{{ asset('backoffice/assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('js_datatable')
<script src="{{ asset('backoffice/assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('backoffice/js/common/datatable.js') }}?v={{ config('parameter.static_version') }}" type="text/javascript"></script>
@endsection
