@if($label) <label>{{ $label }}</label> @endif
<div class="input-group">
    <span class="input-group-text">
        <label class="k-checkbox k-checkbox--single">
            <input name="search_exact" type="checkbox">
            <span></span>
        </label>
        <small>&nbsp;{{ __('Exact') }}</small>
    </span>
    <input type="text" data-original-title="{{ $placeholder }}" data-toggle="tooltip"  placeholder="{{ $placeholder }}" class="form-control" name="{{ $name }}" id="{{ $id }}">
</div>
