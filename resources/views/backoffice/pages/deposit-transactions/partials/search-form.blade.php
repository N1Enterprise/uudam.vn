<div class="k-portlet">
    <div class="k-portlet__head">
        <div class="k-portlet__head-label">
            <h3 class="k-portlet__head-title">{{ __('Search') }}</h3>
        </div>
    </div>
    <!--begin::Form-->
    <form class="k-form k-form--label-right" data-datatable="table_deposit_transactions_index" id="search_table_deposit_transactions_index" method="GET">
        <div class="k-portlet__body">
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>{{ __('Deposit ID') }}</label>
                    <input type="text" class="form-control" name="id">
                </div>

                <div class="col-lg-4">
                    <label>{{ __('Deposit Date Time') }}</label>
                    <div>
                        <div class="input-group pull-right" data-original-title="{{ __('Deposit Date Time') }}" data-toggle="tooltip">
                            <input type="daterangepicker" class="form-control" placeholder="{{ __('Select Deposit Time') }}" value="" name="created_at" readonly>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="la la-calendar-check-o"></i>
                                </span>
                            </div>
                            <input type="hidden" data-daterangepicker-catch="start" name="created_at_range[]">
                            <input type="hidden" data-daterangepicker-catch="end" name="created_at_range[]">
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <label>{{ __('User Info') }}</label>
                    <x-search-username-input placeholder="{{ __('User Username Or User ID') }}" name="user_username_or_user_id" id="user_username_or_user_id" />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">
                    <label>{{ __('Select Payment option') }}</label>
                    <select class="form-control k_selectpicker" data-live-search="true" name="payment_option_id">
                        <option value="">{{ __('Select Payment option') }}</option>
                        @foreach($paymentOptions as $group => $item)
                        <optgroup label="{{ $group }}">
                            @foreach($item as $option)
                            <option data-subtext="{{ optional($option->paymentProvider)->name }}" value="{{ $option->id }}">{{ $option->name }}</option>
                            @endforeach
                        </optgroup>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-4">
                    <label>{{ __('Status') }}</label>
                    <select name="status[]" class="form-control k_selectpicker" data-title="{{ __('Select Deposit Status') }}" multiple>
                        @foreach ($depositStatusEnumLabels as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-4">
                    <label>{{ __('Reference ID') }}</label>
                    <input type="text" class="form-control" name="reference_id">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-4">
                    <label>{{ __('Order Code') }}</label>
                    <input type="text" class="form-control" name="order_code">
                </div>

                <div class="col-lg-4">
                    <label>{{ __('Order Status') }}</label>
                    <select name="order_status[]" class="form-control k_selectpicker" data-title="{{ __('Select Order Status') }}" multiple>
                        @foreach ($orderStatusEnumLabels as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-4">
                    <label>{{ __('Order Payment Status') }}</label>
                    <select name="order_payment_status[]" class="form-control k_selectpicker" data-title="{{ __('Select Payment Status') }}" multiple>
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
                        <button type="submit" class="btn btn-primary" id="btnSearch">{{ __('Search') }}</button>
                        <button type="reset" class="btn btn-secondary" onclick="setFilterParams()">{{ __('Reset') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
</div>
