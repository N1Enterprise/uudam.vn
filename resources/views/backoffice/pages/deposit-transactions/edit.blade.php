<div class="modal-dialog modal-lg" role="document">
	<div class="modal-content">
		<div class="modal-header" style="padding-bottom: 0px;">
			<div>
				<h5 class="modal-title">
                    {{ __('Deposit Detail') }}
					<span class="k-menu__link-badge" style="margin-left: 5px;">
						<span class="badge badge-pill badge-secondary copy-text-click" style="font-size: 70%;">{{ $transaction->id }}</span>
					</span>
				</h5>
				<div class="">
					<label>
						{{ __('Ref id') }}: <span class="copy-text-click">{{ $transaction->reference_id }}</span>
					</label>
				</div>
			</div>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form id="depositTransactionForm">
				<div class="form-group row">
					<div class="col-lg-4">
						<label>{{ __('User Username') }}</label>
						<div class="input-group">
							<div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="la la-user"></i>
                                </span>
                            </div>
							<input type="text" class="form-control" disabled="disabled" value="{{ optional($transaction->user)->username }}">
						</div>
					</div>
					<div class="col-lg-4">
						<label>{{ __('Deposit Amount') }}</label>
						<input type="text" data-input-format="currency:{{ $transaction->currency_code }}" class="form-control" disabled="disabled" value="{{ $transaction->amount }}">
					</div>
					<div class="col-lg-4">
						<label class="">{{ __('Status') }}</label>
						<input type="text" class="form-control" disabled="disabled" value="{{ $transaction->status_name }}">
					</div>
				</div>

				<div class="form-group row">
					<div class="col-lg-4">
						<label class="">{{ __('Payment Option Name') }}</label>
                        <div class="input-group">
                            <input type="text" class="payment-option-name-text form-control" disabled="disabled" value="{{ optional($transaction->paymentOption)->name }}" data-payment-option-id="{{ optional($transaction->paymentOption)->getKey() }}">
                        </div>
					</div>
					<div class="col-lg-4">
						<label class="">{{ __('Payment Option Type') }}</label>
						<input type="text" class="form-control" disabled="disabled" value="{{ optional($transaction->paymentOption)->type_name }}">
					</div>
					<div class="col-lg-4">
						<label>{{ __('Reference Id') }}</label>
						<input type="text" data-input-format="datetime" class="form-control" disabled="disabled" value="{{ $transaction->reference_id }}">
					</div>

				</div>
				<div class="form-group row">
				<div class="col-lg-4">
						<label>{{ __('Created At') }}</label>
						<input type="text" data-input-format="datetime" class="form-control" disabled="disabled" value="{{ $transaction->created_at_iso }}">
					</div>
					<div class="col-lg-4">
						<label>{{ __('Processed At') }}</label>
						<input type="text" data-input-format="datetime" class="form-control" disabled="disabled" value="{{ $transaction->updated_at_iso }}">
					</div>
					@if($transaction->currency->isCrypto())
                    <div class="col-lg-4">
                        <label class="">{{ __('Network') }}</label>
                        <input type="text" class="form-control" disabled="disabled" value="{{ $transaction->blockchain_network }}">
                    </div>
                    @endif
				</div>

				<div class="form-group row">
					@if(optional($transaction->paymentOption)->isLocalBank())
					<div class="col-lg-4">
						<label class="">{{ __('User Bank Account Name') }}</label>
						<input type="text" class="form-control" disabled="disabled" value="{{ $transaction->bank_transfer_account_name }}">
					</div>
					<div class="col-lg-4">
						<label class="">{{ __('User Bank Account Number') }}</label>
						<input type="text" class="form-control" disabled="disabled" value="{{ $transaction->bank_transfer_account_number }}">
					</div>
					@endif
				</div>

				@if($transaction->bank_transfer_bank_slip_document)
				<div class="form-group row">
					<div class="col-lg-6">
						<label class="">{{ __('Bank Slip') }}</label>
						<img id="documentImage" height="200" class="w-100 modal-image" src="{{ $transaction->bank_slip_temporary_url }}" alt="">
					</div>
				</div>
				@endif
				<div class="form-group row">
					<div class="col-lg-12">
						<label class="">{{ __('Note') }}</label>
						<textarea {{ $transaction->isPending() ? '' : 'disabled' }} class="form-control" name="" id="" cols="30" rows="4">{{ $transaction->note }}</textarea>
					</div>
				</div>
				@csrf
			</form>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
			@if ($transaction->isPending())
			<button type="button" data-form="#depositTransactionForm" data-datatable="index_deposit_transaction_table" data-method="put" data-url="{{ route('bo.api.deposit-transactions.decline', $transaction->getKey()) }}" class="btn btn-danger actionBtn">{{ __('Decline') }}</button>
			<button type="button" data-form="#depositTransactionForm" data-datatable="index_deposit_transaction_table" data-method="put" data-url="{{ route('bo.api.deposit-transactions.approve', $transaction->getKey()) }}" class="btn btn-primary actionBtn">{{ __('Approve') }}</button>
			@endif
		</div>
	</div>
</div>
