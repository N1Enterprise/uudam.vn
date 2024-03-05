<div class="k-portlet">
    <div class="k-portlet__head">
        <div class="k-portlet__head-label">
            <h3 class="k-portlet__head-title">{{ __('Tìm kiếm') }}</h3>
        </div>
    </div>
    <!--begin::Form-->
    <form class="k-form k-form--label-right" data-datatable="table-shipping-rates-index" id="search-shipping-rates-index" method="GET">
        <div class="k-portlet__body">
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>{{ __('Khu vực vận chuyển') }}</label>
                    <div class="form-group">
                        <select name="shipping_zone_id" title="-- {{ __('Chọn khu vực vận chuyển') }} --" class="form-control k_selectpicker">
                            <option value="shipping_zone_id">--- {{ __('Chọn khu vực vận chuyển') }} ---</option>
                            @foreach($shippingZones as $shippingZone)
                            <option value="{{ $shippingZone->id }}">{{ $shippingZone->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <label>{{ __('Thể loại') }}</label>
                    <div class="form-group">
                        <select name="type" title="-- {{ __('Chọn loại') }} --" class="form-control k_selectpicker">
                            <option value="">--- {{ __('Chọn loại') }} ---</option>
                            @foreach($shippingRateTypeEnumLabels as $key => $label)
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
