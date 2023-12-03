<div class="k-portlet">
    <div class="k-portlet__head">
        <div class="k-portlet__head-label">
            <h3 class="k-portlet__head-title">{{ __('Search') }}</h3>
        </div>
    </div>
    <!--begin::Form-->
    <form class="k-form k-form--label-right" data-datatable="table-shipping-rates-index" id="search-shipping-rates-index" method="GET">
        <div class="k-portlet__body">
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>{{ __('Shipping Zone') }}</label>
                    <div class="form-group">
                        <select name="shipping_zone_id" title="--{{ __('Select Shipping Zone') }}--" class="form-control k_selectpicker">
                            <option value="shipping_zone_id">--- {{ __('Select Shipping Zone') }} ---</option>
                            @foreach($shippingZones as $shippingZone)
                            <option value="{{ $shippingZone->id }}">{{ $shippingZone->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <label>{{ __('Carrier') }}</label>
                    <div class="form-group">
                        <select name="carrier_id" title="--{{ __('Select Carrier') }}--" class="form-control k_selectpicker">
                            <option value="">--- {{ __('Select Carrier') }} ---</option>
                            @foreach($carriers as $carrier)
                            <option value="{{ $carrier->id }}">{{ $carrier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <label>{{ __('Type') }}</label>
                    <div class="form-group">
                        <select name="type" title="--{{ __('Select Type') }}--" class="form-control k_selectpicker">
                            <option value="">--- {{ __('Select Type') }} ---</option>
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
                        <button type="submit" class="btn btn-primary" id="btnSearch">{{ __('Search') }}</button>
                        <button type="reset" class="btn btn-secondary" onclick="setFilterParams()">{{ __('Reset') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
</div>
