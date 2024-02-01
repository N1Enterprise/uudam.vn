<div class="k-portlet">
    <div class="k-portlet__head">
        <div class="k-portlet__head-label">
            <h3 class="k-portlet__head-title">{{ __('Tìm kiếm') }}</h3>
        </div>
    </div>
    <!--begin::Form-->
    <form class="k-form k-form--label-right" data-datatable="table_orders_index" id="search_table_orders_index" method="GET">
        <div class="k-portlet__body">
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>{{ __('Order Code') }}</label>
                    <input type="text" class="form-control" name="order_code">
                </div>

                <div class="col-lg-4">
                    <label>{{ __('UUID') }}</label>
                    <input type="text" class="form-control" name="uuid">
                </div>

                <div class="col-lg-4">
                    <label>{{ __('Company') }}</label>
                    <input type="text" class="form-control" name="company">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-4">
                    <label>{{ __('User Full Name') }}</label>
                    <input type="text" class="form-control" name="fullname">
                </div>

                <div class="col-lg-4">
                    <label>{{ __('User Email') }}</label>
                    <input type="text" class="form-control" name="email">
                </div>

                <div class="col-lg-4">
                    <label>{{ __('User Phone') }}</label>
                    <input type="text" class="form-control" name="phone">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-4">
                    <label>{{ __('Order Status') }}</label>
                    <select name="order_statuses[]" class="form-control k_selectpicker" data-title="{{ __('Select Order Status') }}" multiple>
                        @foreach ($orderStatusEnumLabels as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-4">
                    <label>{{ __('Payment Status') }}</label>
                    <select name="payment_status[]" class="form-control k_selectpicker" data-title="{{ __('Select Payment Status') }}" multiple>
                        @foreach ($paymentStatusEnumLabels as $key => $label)
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
