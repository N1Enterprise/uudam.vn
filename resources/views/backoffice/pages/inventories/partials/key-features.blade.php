
<div class="key_features_repeater">
    <div data-repeater-list="key_features">
        @if(empty(old('key_features', [])))
        <div data-repeater-item class="k-repeater__item">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="title" class="form-control" value="">
                    <div class="input-group-append">
                        <button data-repeater-delete class="btn btn-secondary" type="button">
                            <i class="la la-close"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @else
            @foreach (old('key_features') as $keyFeature)
            <div data-repeater-item class="k-repeater__item">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="title" class="form-control" value="{{ data_get($keyFeature, 'title') }}">
                        <div class="input-group-append">
                            <button data-repeater-delete class="btn btn-secondary" type="button">
                                <i class="la la-close"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
    <div class="k-repeater__add-data">
        <span data-repeater-create="" class="btn btn-info btn-sm">
            <i class="la la-plus"></i> {{ __('Add') }}
        </span>
    </div>
</div>
