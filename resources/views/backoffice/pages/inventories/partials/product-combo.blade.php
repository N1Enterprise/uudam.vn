<div class="product_combo_repeater">
    <div data-repeater-list="product_combos">
        @if(empty(old('product_combos', [])) && optional($inventory->productCombos)->isEmpty())
        <div data-repeater-item class="k-repeater__item">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="">Product Combo</label>
                    <select name="product_combo_id" class="form-control">
                        <option value="">---{{ __('Select Product Combo') }}---</option>
                        @foreach($productCombos as $product)
                        <option  value="{{ $product->id }}">{{ $product->name }} ({{ format_price($product->sale_price) }} / {{ $product->unit }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-5">
                    <label for="quantity">Số lượng mua kèm với <b>1 sản phẩm</b></label>
                    <input type="number" name="quantity" class="form-control" min="1" value="1">
                </div>

                <div class="form-group col-md-1">
                    <button data-repeater-delete class="btn btn-secondary" type="button" style="margin-top: 27px;">
                        <i class="la la-close"></i>
                    </button>
                </div>
            </div>
        </div>
        @else
            @foreach (old('product_combos', $inventory->productCombos) as $productCombo)
            @php
                $productComboIndex = $loop->index;
            @endphp
            <div data-repeater-item class="k-repeater__item">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="">Product Combo</label>
                        <select name="product_combo_id" class="form-control">
                            <option value="">---{{ __('Select Product Combo') }}---</option>
                            @foreach($productCombos as $product)
                            <option data-test="{{ old("product_combos.$productComboIndex.product_combo_id") }}" {{ $product->id == old("product_combos.$productComboIndex.product_combo_id", data_get($productCombo, 'id')) ? 'selected' : '' }} value="{{ $product->id }}">{{ $product->name }} ({{ format_price($product->sale_price) }} / {{ $product->unit }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-5">
                        <label for="quantity">Số lượng mua kèm với <b>1 sản phẩm</b></label>
                        <input type="number" name="quantity" class="form-control" min="1" value="{{ old("product_combos.$productComboIndex.quantity", data_get($productCombo, 'pivot.quantity')) }}">
                    </div>

                    <div class="form-group col-md-1">
                        <button data-repeater-delete class="btn btn-secondary" type="button" style="margin-top: 27px;">
                            <i class="la la-close"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
    <div class="k-repeater__add-data">
        <span data-repeater-create="" class="btn btn-info btn-sm">
            <i class="la la-plus"></i> {{ __('Add') }}
        </span>
    </div>
</div>
