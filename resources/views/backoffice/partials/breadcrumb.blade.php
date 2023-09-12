
@section('breadcrumb')
@if(! empty($items))
<div class="k-content__head-breadcrumbs">
	<a href="#" class="k-content__head-breadcrumb-home"><i class="flaticon2-shelter"></i></a>
	@foreach ($items as $item)

		@php
			$rawLabel = data_get($item, 'label');
			$active = data_get($item, 'active', false);
			$ignoreTranslation = data_get($item, 'ignoreTranslation', false);
			$label = $ignoreTranslation ?  $rawLabel : __($rawLabel);
		@endphp

		@if (! $loop->last)
        <span class="k-content__head-breadcrumb-separator"></span>
        <a href="{{ data_get($item, 'href') }}" class="k-content__head-breadcrumb-link">{{ $label }}</a>
		@else
        <span class="k-content__head-breadcrumb-separator"></span>
        <a href="{{ data_get($item, 'href') }}" class="k-content__head-breadcrumb-link {{ $active ? 'k-content__head-breadcrumb-link--active' : '' }}">{{ $label }}</a>
		@endif
	@endforeach
</div>
@endif
@endsection
