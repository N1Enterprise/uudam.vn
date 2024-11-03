<div class="k-portlet">
    <div class="k-portlet__head">
        <div class="k-portlet__head-label">
            <h3 class="k-portlet__head-title">{{ __('Tìm kiếm') }}</h3>
        </div>
    </div>
    <!--begin::Form-->
    <form class="k-form k-form--label-right" data-datatable="table_mennus_index" id="search_table_menu_index" method="GET">
        <div class="k-portlet__body">
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>{{ __('Loại') }}</label>
                    <select name="type" class="form-control k_selectpicker">
                        <option value="">{{ __('Chọn loại') }}</option>
                        @foreach ($menuTypeEnumLabels as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6">
                    <label>{{ __('Sản phẩm kho') }}</label>
                    <select name="inventory_id" title="-- {{ __('Chọn sản phẩm') }} --" class="form-control k_selectpicker" data-live-search="true">
                        @foreach($inventories as $inventory)
                        <option value="{{ $inventory->id }}">{{ $inventory->title }} (SKU: {{ $inventory->sku }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-6">
                    <label>{{ __('Bộ sưu tập') }}</label>
                    <select name="collection_id" title="-- {{ __('Chọn bộ sưu tập') }} --" class="form-control k_selectpicker" data-live-search="true">
                        @foreach($collections as $collection)
                        <option value="{{ $collection->id }}">{{ $collection->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-6">
                    <label>{{ __('Bài viết') }}</label>
                    <select name="post_id" title="-- {{ __('Chọn Post') }} --" class="form-control k_selectpicker" data-live-search="true">
                        @foreach($posts as $post)
                        <option value="{{ $post->id }}">{{ $post->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-6">
                    <label>{{ __('Catalog') }}</label>
                    <select name="menu_catalogs[]" title="-- {{ __('Chọn nhóm') }} --" class="form-control k_selectpicker" data-size="5" multiple required data-live-search="true">
                        @foreach($menuGroups as $menuGroup)
                        <optgroup label="{{ $menuGroup->name }}">
                            @foreach($menuGroup->menuSubGroups as $subGroup)
                            <option value="{{ $subGroup->id }}">({{ $subGroup->id }}) {{ $subGroup->name }}</option>
                            @endforeach
                        </optgroup>
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
                        <button type="reset" class="btn btn-secondary">{{ __('Làm mới') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
</div>
