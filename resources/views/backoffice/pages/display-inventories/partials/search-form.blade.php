<div class="k-portlet">
    <div class="k-portlet__head">
        <div class="k-portlet__head-label">
            <h3 class="k-portlet__head-title">{{ __('Search') }}</h3>
        </div>
    </div>
    <!--begin::Form-->
    <form class="k-form k-form--label-right" data-datatable="table_display_inventories_index" id="search_display_inventories_index" method="GET">
        <div class="k-portlet__body">
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>{{ __('Inventory') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="la la-user"></i></span>
                        </div>
                        <input type="text" class="form-control" name="inventory_title">
                    </div>
                </div>
                <div class="col-lg-4">
                    <label>{{ __('Display Type') }}</label>
                    <div class="form-group">
                        <select name="type" title="--{{ __('Select Display Type') }}--" class="form-control k_selectpicker">
                            <option value="">--- {{ __('Select Display Type') }} ---</option>
                            @foreach($displayInventoryTypeEnumLabels as $key => $label)
                            <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $label }}</option>
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
                        <button type="submit" class="btn btn-primary" id="btnSearch">{{ __('Search') }}</button>
                        <button type="reset" class="btn btn-secondary" onclick="setFilterParams()">{{ __('Reset') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
</div>
