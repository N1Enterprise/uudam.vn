<div class="k-portlet">
    <div class="k-portlet__head">
        <div class="k-portlet__head-label">
            <h3 class="k-portlet__head-title">{{ __('Search') }}</h3>
        </div>
    </div>
    <!--begin::Form-->
    <form class="k-form k-form--label-right" data-datatable="table_inventories_index" id="form_inventories_index" method="GET">
        <div class="k-portlet__body">
            <div class="row">
                <div class="form-group col-lg-4">
                    <label>{{ __('Product') }} *</label>
                    <select name="product_id" title="--{{ __('Select Product') }}--" class="form-control k_selectpicker" data-size="5" data-live-search="true">
                        @foreach($categories as $category)
                        <optgroup label="{{ $category->name }}">
                            @foreach($category->products as $product)
                            <option value="{{ $product->id }}" data-product-type="{{ $product->type }}" data-categories='@json($product->categories->pluck('id')->toArray())'>{{ $product->name }} ({{ $product->type_name }})</option>
                            @endforeach
                        </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-4">
                    <label>{{ __('Status') }} *</label>
                    <select name="status" class="form-control k_selectpicker">
                        <option value="">--{{ __('Select status') }}--</option>
                        @foreach ($statusLabels as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-lg-4">
                    <label>{{ __('FE Display') }} *</label>
                    <select name="display_on_frontend" class="form-control k_selectpicker">
                        <option value="">--{{ __('Select status') }}--</option>
                        @foreach ($statusLabels as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-lg-4">
                    <label>{{ __('FE Search') }} *</label>
                    <select name="allow_frontend_search" class="form-control k_selectpicker">
                        <option value="">--{{ __('Select status') }}--</option>
                        @foreach ($statusLabels as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="k-portlet__foot">
            <div class="k-form__actions">
                <div class="row">
                    <div class="col-lg-6">
                        <input type="hidden" name="order_status" value="">

                        <button type="submit" class="btn btn-primary" id="btnSearch">{{ __('Search') }}</button>
                        <button type="reset" class="btn btn-secondary" onclick="setFilterParams()">{{ __('Reset') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
</div>
