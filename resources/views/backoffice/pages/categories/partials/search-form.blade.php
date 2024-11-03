<div class="k-portlet">
    <div class="k-portlet__head">
        <div class="k-portlet__head-label">
            <h3 class="k-portlet__head-title">{{ __('Tìm kiếm') }}</h3>
        </div>
    </div>
    <!--begin::Form-->
    <form class="k-form k-form--label-right" data-datatable="table_categories_index" id="form_categories_index" method="GET">
        <div class="k-portlet__body">
            <div class="row">
                <div class="col-md-4 form-group">
                    <label>{{ __('Nhóm danh mục') }}</label>
                    <select name="category_group_id" title="-- {{ __('Chọn nhóm danh mục') }} --" class="form-control k_selectpicker" data-size="5" data-live-search="true">
                        @foreach($categoryGroups as $categoryGroup)
                        <option value="{{ $categoryGroup->id }}">{{ $categoryGroup->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-4 form-group">
                    <label>{{ __('Trạng thái') }}</label>
                    <select name="status" class="form-control k_selectpicker">
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
