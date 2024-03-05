<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header" style="padding-bottom: 0px;">
			<div>
				<h5 class="modal-title">{{ __('Chi tiết thanh toán gửi tiền') }}
					<span class="k-menu__link-badge" style="margin-left: 5px;">
						<span class="badge badge-pill badge-secondary copy-text-click" style="font-size: 70%;">{{ $transaction->id }}</span>
					</span>
				</h5>
				<div class="">
					<label>
						{{ __('ID tham chiếu') }}: <span class="copy-text-click">{{ $transaction->reference_id }}</span>
					</label>
				</div>
			</div>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form id="deposit-transaction" data-form="deposit-transaction">
                <div class="form-group row">
					<div class="col-lg-4">
						<label>{{ __('Tên khách hàng') }}</label>
						<div class="input-group">
							<div class="input-group-prepend"><span class="input-group-text"><i class="la la-user"></i></span></div>
							<input type="text" class="form-control" disabled="disabled" value="{{ optional($transaction->user)->name }}">
						</div>
					</div>
					<div class="col-lg-4">
						<label>{{ __('Số tiền') }}</label>
						<input type="text" data-input-format="currency:{{ $transaction->currency_code }}" class="form-control" disabled="disabled" value="{{ $transaction->toMoney('amount')->format() }}">
					</div>
					<div class="col-lg-4">
						<label class="">{{ __('Trạng thái') }}</label>
						<input type="text" class="form-control" disabled="disabled" value="{{ $transaction->status_name }}">
					</div>
				</div>

                <div class="form-group row">
					<div class="col-lg-4">
						<label class="">{{ __('Tuỳ chọn thanh toán') }}</label>
                        <div class="input-group">
                            <input type="text" class="payment-option-name-text form-control" disabled="disabled" value="{{ optional($transaction->paymentOption)->name }}" data-payment-option-id="{{ optional($transaction->paymentOption)->getKey() }}">
                        </div>
					</div>
					<div class="col-lg-4">
						<label class="">{{ __('Loại tuỳ chọn thanh toán') }}</label>
						<input type="text" class="form-control" disabled="disabled" value="{{ optional($transaction->paymentOption)->type_name }}">
					</div>
					<div class="col-lg-4">
						<label>{{ __('ID tham chiếu') }}</label>
						<input type="text" data-input-format="datetime" class="form-control" disabled="disabled" value="{{ $transaction->reference_id }}">
					</div>
				</div>

                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>{{ __('Ngày tạo') }}</label>
                        <input type="text" data-input-format="datetime" class="form-control" disabled="disabled" value="{{ format_datetime($transaction->created_at, 'Y/m/d') }}">
                    </div>
                    <div class="col-lg-4">
                        <label>{{ __('Thời gian xử lý') }}</label>
                        <input type="text" data-input-format="datetime" class="form-control" disabled="disabled" value="{{ format_datetime($transaction->updated_at, 'Y/m/d') }}">
                    </div>
                </div>

                @if($transaction->order_id)
                <div class="k-section">
                    <div class="k-section__info k-section__title mb-2">
                        <b>{{ __('THÔNG TIN ĐƠN HÀNG') }}</b>
                        <a href="{{ route('bo.web.orders.edit', optional($transaction->order)->id) }}" target="_blank">
                            <i id="load_panel_update_playerbank" class="p-2 flaticon2-edit-interface-symbol-of-pencil-tool"></i>
                        </a>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-lg-4">
						<label class="">{{ __('ID đơn hàng') }}</label>
                        <div class="input-group">
                            <input type="text" class="form-control" disabled="disabled" value="{{ optional($transaction->order)->id }}">
                        </div>
					</div>

                    <div class="col-lg-4">
						<label class="">{{ __('Mã đơn hàng') }}</label>
                        <div class="input-group">
                            <input type="text" class="form-control" disabled="disabled" value="{{ optional($transaction->order)->order_code }}">
                        </div>
					</div>

                    <div class="col-lg-4">
						<label class="">{{ __('Ngày mua hàng') }}</label>
                        <div class="input-group">
                            <input type="text" class="form-control" disabled="disabled" value="{{ format_datetime(optional($transaction->order)->created_at, 'Y/m/d') }}">
                        </div>
					</div>
                </div>
                @endif

                <div class="form-group row">
					<div class="col-lg-12">
						<label class="">{{ __('Ghi chú') }}</label>
						<textarea {{ $transaction->isPending() ? '' : 'disabled' }} class="form-control" cols="30" rows="4">{{ $transaction->note }}</textarea>
					</div>
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Đóng') }}</button>
			@if ($transaction->isPending())
			<button type="button" data-form="#deposit-transaction" data-datatable="table_deposit_transactions_index" data-method="put" data-url="{{ route('bo.api.deposit-transactions.decline', $transaction->getKey()) }}" class="btn btn-danger actionBtn">{{ __('Decline') }}</button>
			<button type="button" data-form="#deposit-transaction" data-datatable="table_deposit_transactions_index" data-method="put" data-url="{{ route('bo.api.deposit-transactions.approve', $transaction->getKey()) }}" class="btn btn-primary actionBtn">{{ __('Approve') }}</button>
			@endif
		</div>
	</div>
</div>
