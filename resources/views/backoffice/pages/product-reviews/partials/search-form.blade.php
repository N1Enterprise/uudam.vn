<div class="k-portlet">
    <div class="k-portlet__head">
        <div class="k-portlet__head-label">
            <h3 class="k-portlet__head-title">{{ __('Tìm kiếm') }}</h3>
        </div>
    </div>
    <!--begin::Form-->
    <form class="k-form k-form--label-right" data-datatable="table_product_reviews_index" id="search_product_reviews_index" method="GET">
        <div class="k-portlet__body">
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>{{ __('Product') }}</label>
                    <select name="product_id" title="--{{ __('Select Product') }}--" class="form-control k_selectpicker" data-size="5" data-live-search="true">
                        @foreach($categories as $category)
                        <optgroup label="{{ $category->name }}">
                            @foreach($category->products as $product)
                            <option data-tokens="{{ $product->id }} | {{ $product->name }} | {{ $product->slug }}" value="{{ $product->id }}" >{{ $product->name }}</option>
                            @endforeach
                        </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-4">
                    <label>{{ __('Trạng thái') }}</label>
                    <div class="form-group">
                        <select name="status[]" title="--{{ __('Select Status') }}--" class="form-control k_selectpicker" multiple>
                            @foreach($productReviewStatusEnumLabels as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-lg-4">
                    <label>{{ __('Rating Type') }}</label>
                    <div class="form-group">
                        <select name="rating_type[]" title="--{{ __('Select Rating Type') }}--" class="form-control k_selectpicker" multiple>
                            @foreach($productReviewRatingEnumLabels as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="k-portlet__foot">
            <div class="k-form__actions">
                <div class="row">
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-primary" id="btnSearch">{{ __('Tìm kiếm') }}</button>
                        <button type="reset" class="btn btn-secondary" onclick="setFilterParams()">{{ __('Làm mới') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
</div>
