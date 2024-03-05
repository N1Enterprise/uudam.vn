<div class="k-portlet">
    <div class="k-portlet__head">
        <div class="k-portlet__head-label">
            <h3 class="k-portlet__head-title">{{ __('Tìm kiếm') }}</h3>
        </div>
    </div>
    <!--begin::Form-->
    <form class="k-form k-form--label-right" data-datatable="table_attribute_values_index" id="form_attribute_values_index" method="GET">
        <div class="k-portlet__body">
            <div class="row">
                <div class="form-group col-lg-4">
                    <label>{{ __('Thuộc tính') }}</label>
                    <select name="attribute_id" title="-- {{ __('Chọn thuộc tính') }} --" class="form-control k_selectpicker" data-size="5" data-live-search="true">
                        @foreach ($attributes as $attribute)
                        <option value="{{ data_get($attribute, 'id') }}">{{ data_get($attribute, 'name') }}</option>
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
