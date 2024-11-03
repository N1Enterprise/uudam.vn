<div class="k-portlet">
    <div class="k-portlet__head">
        <div class="k-portlet__head-label">
            <h3 class="k-portlet__head-title">{{ __('Tìm kiếm') }}</h3>
        </div>
    </div>
    <!--begin::Form-->
    <form class="k-form k-form--label-right" data-datatable="table_inventories_index" id="form_inventories_index" method="GET">
        <div class="k-portlet__body">
            <div class="row">
                <div class="form-group col-lg-4">
                    <label>{{ __('Sản phẩm') }}</label>
                    <select name="product_id" title="-- {{ __('Chọn sản phẩm') }} --" class="form-control k_selectpicker" data-size="5" data-live-search="true">
                        @foreach($categories as $category)
                        <optgroup label="{{ $category->name }} ({{ $category->categoryGroup->name }})">
                            @foreach($category->products as $product)
                            <option
                                value="{{ $product->id }}"
                                data-product-type="{{ $product->type }}"
                                data-tokens="{{ (string) $product->id }} | {{ $product->name }} | {{ $category->name }} | {{ $category->categoryGroup->name }}"
                                data-categories='@json($product->categories->pluck('id')->toArray())'>{{ $product->name }} ({{ $product->type_name }})</option>
                            @endforeach
                        </optgroup>
                        @endforeach
                    </select>
                </div>
                {{-- <div class="form-group col-lg-4">
                    <label>{{ __('Sắp xếp theo') }}</label>
                    <select name="sort_by" title="-- {{ __('Lọc sản phẩn') }} --" class="form-control k_selectpicker">
                        <option value="">-- {{ __('Chọn cách lọc') }} --</option>
                        <option value="best_selling:desc">{{ __('Bán chạy đến ít bán') }}</option>
                        <option value="best_selling:asc">{{ __('Ít bán đến bán chạy') }}</option>
                        <option value="sale_price:desc">{{ __('Giá cao đến thấp') }}</option>
                        <option value="sale_price:asc">{{ __('Giá thấp đến cao') }}</option>
                    </select>
                </div> --}}
            </div>
            <div class="row">
                <div class="form-group col-lg-4">
                    <label>{{ __('Trạng thái') }}</label>
                    <select name="status" class="form-control k_selectpicker">
                        <option value="">-- {{ __('Chọn trạng thái') }} --</option>
                        @foreach ($statusLabels as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-lg-4">
                    <label>{{ __('Hiển thị FE') }}</label>
                    <select name="display_on_frontend" class="form-control k_selectpicker">
                        <option value="">-- {{ __('Chọn trạng thái') }} --</option>
                        @foreach ($statusLabels as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-lg-4">
                    <label>{{ __('Tìm kiếm FE') }}</label>
                    <select name="allow_frontend_search" class="form-control k_selectpicker">
                        <option value="">-- {{ __('Chọn trạng thái') }} --</option>
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

                        <button type="submit" class="btn btn-primary" id="btnSearch">{{ __('Tìm kiếm') }}</button>
                        <button type="reset" class="btn btn-secondary" onclick="setFilterParams()">{{ __('Làm mới') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
</div>
