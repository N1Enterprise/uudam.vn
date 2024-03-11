<div class="k-portlet">
    <div class="k-portlet__head">
        <div class="k-portlet__head-label">
            <h3 class="k-portlet__head-title">{{ __('Tìm kiếm') }}</h3>
        </div>
    </div>
    <!--begin::Form-->
    <form class="k-form k-form--label-right" data-datatable="table_deposit_transactions_index" id="search_table_deposit_transactions_index" method="GET">
        <div class="k-portlet__body">
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>{{ __('ID tiền gửi') }}</label>
                    <input type="text" class="form-control" name="id">
                </div>

                <div class="col-lg-4">
                    <label>{{ __('Thời gian gửi tiền') }}</label>
                    <div>
                        <div class="input-group pull-right" data-original-title="{{ __('Thời gian gửi tiền') }}" data-toggle="tooltip">
                            <input type="daterangepicker" class="form-control" placeholder="{{ __('Chọn khoản thời gian gửi tiền') }}" value="" name="created_at" readonly>
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
                    <label>{{ __('Khách hàng') }}</label>
                    <x-search-username-input placeholder="{{ __('Tên hoặc ID khách hàng') }}" name="user_username_or_user_id" id="user_username_or_user_id" />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-4">
                    <label>{{ __('Tùy chọn Thanh toán') }}</label>
                    <select class="form-control k_selectpicker" data-live-search="true" name="payment_option_id">
                        <option value="">-- {{ __('Chọn tùy chọn Thanh toán') }} --</option>
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
                    <label>{{ __('Trạng thái') }}</label>
                    <select name="status[]" class="form-control k_selectpicker" data-title="-- {{ __('Select Deposit Status') }} --" multiple>
                        @foreach ($depositStatusEnumLabels as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-4">
                    <label>{{ __('ID tham chiếu') }}</label>
                    <input type="text" class="form-control" name="reference_id">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-4">
                    <label>{{ __('Mã đơn hàng') }}</label>
                    <input type="text" class="form-control" name="order_code">
                </div>

                <div class="col-lg-4">
                    <label>{{ __('Trạng thái đơn hàng') }}</label>
                    <select name="order_status[]" class="form-control k_selectpicker" data-title="-- {{ __('Chọn trạng thái đơn hàng') }} --" multiple>
                        @foreach ($orderStatusEnumLabels as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-4">
                    <label>{{ __('Trạng thái thanh toán đơn hàng') }}</label>
                    <select name="order_payment_status[]" class="form-control k_selectpicker" data-title="-- {{ __('Chọn trạng thái thanh toán đơn hàng') }} --" multiple>
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
                        <input type="hidden" name="status" value="">

                        <button type="submit" class="btn btn-primary" id="btnSearch">{{ __('Tìm kiếm') }}</button>
                        <button type="reset" class="btn btn-secondary" onclick="setFilterParams()">{{ __('Làm mới') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
</div>
