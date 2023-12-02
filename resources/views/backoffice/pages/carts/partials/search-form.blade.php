<div class="k-portlet">
    <div class="k-portlet__head">
        <div class="k-portlet__head-label">
            <h3 class="k-portlet__head-title">{{ __('Search') }}</h3>
        </div>
    </div>
    <!--begin::Form-->
    <form class="k-form k-form--label-right" data-datatable="table_carts_index" id="search_table_cart_index" method="GET">
        <div class="k-portlet__body">
            <div class="form-group row">
                <div class="col-lg-4">
                    <label>{{ __('User Username / E-mail') }}</label>
                    <input type="text" class="form-control" name="user_username_or_email">
                </div>

                <div class="col-lg-4">
                    <label>{{ __('User Phone Number') }}</label>
                    <input type="text" class="form-control" name="user_phone_number">
                </div>

                <div class="col-lg-4">
                    <label>{{ __('Order Code') }}</label>
                    <input type="text" class="form-control" name="order_code">
                </div>
            </div>
        </div>
        <div class="k-portlet__foot">
            <div class="k-form__actions">
                <div class="row">
                    <div class="col-lg-6">
                        <input type="hidden" name="order_status" value="">

                        <button type="submit" class="btn btn-primary" id="btnSearch">{{ __('Search') }}</button>
                        <button type="reset" class="btn btn-secondary">{{ __('Reset') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--end::Form-->
</div>
