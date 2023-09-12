@section('style_datatable')
<link href="{{ asset('assets/vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('js_datatable')
<script src="{{ asset('assets/vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/common/datatable.js') }}?v={{ config('parameter.static_version') }}" type="text/javascript"></script>
@endsection
