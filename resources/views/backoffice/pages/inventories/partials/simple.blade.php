<div class="simple">
    <div class="form-group">
        <label>{{ __('Image') }}
            <i
                data-toggle="tooltip"
                class="flaticon-questions-circular-button"
                data-title="The image of the simple"
            ></i>
        </label>
        <div class="row">
            <div class="col-md-6">
                <div class="upload_image_custom position-relative">
                    <input type="text" data-image-ref-path="variant" data-image-ref-index="0" class="form-control variant_image_path" name="image[path]" placeholder="{{ __('Upload Image or Input URL') }}" style="padding-right: 104px;" value="{{ old('image.path', data_get($inventory, 'image', data_get($product, 'primary_image'))) }}">
                    <div data-image-ref-wapper="variant" data-image-ref-index="0" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                        <div class="d-flex align-items-center h-100">
                            <img data-image-ref-img="variant" data-image-ref-index="0" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                            <span data-image-ref-delete="variant" data-image-ref-index="0" aria-hidden="true" style="font-size: 16px; cursor: pointer;">&times;</span>
                        </div>
                    </div>
                    <label for="variant_image_file_0" class="variant_image_file_wapper btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                        <input type="file" name="image[file]" data-image-ref-file="variant" data-image-ref-index="0" id="variant_image_file_0" class="d-none variant_image_file">
                        <i class="flaticon2-image-file"></i>
                        <span>{{ __('Upload') }}</span>
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-start">
                    <div class="image_variant_image_review">
                        <div data-image-ref-review-wapper="variant" data-image-ref-index="0" class="d-none" style="width: 100px; height: 100px; border: 1px solid #ccc;">
                            <img data-image-ref-review-img="variant" data-image-ref-index="0" style="width: 100%; height: 100%;" src="" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">{{ __('SKU') }}
                    <i
                        data-toggle="tooltip"
                        class="flaticon-questions-circular-button"
                        data-title="SKU (Stock Keeping Unit) is the seller specific identifier. It will help to manage your inventory"
                    ></i>
                </label>
                <input type="text" class="form-control {{ $errors->has('sku') ? 'is-invalid' : '' }}" name="sku" value="{{ old('sku', $inventory->sku) }}" required>
                @error('sku')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('Condition') }} *
                    <i
                        data-toggle="tooltip"
                        class="flaticon-questions-circular-button"
                        data-title="What is the current condition of the product?"
                    ></i>
                </label>
                <select name="condition" class="form-control k_selectpicker {{ $errors->has("condition") ? 'is-invalid' : '' }}">
                    @foreach($inventoryConditionEnumLabels as $key => $label)
                    <option value="{{ $key }}" {{ old('condition', $inventory->condition) == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error("condition")
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('Purchase price') }}
                    <i
                        data-toggle="tooltip"
                        class="flaticon-questions-circular-button"
                        data-title="Recommended field. This will helps to calculate profits and generate reports"
                    ></i>
                </label>
                <x-number-input
                    allow-minus="false"
                    key="purchase_price"
                    name="purchase_price"
                    class="form-control {{ $errors->has('purchase_price') ? 'is-invalid' : '' }}"
                    value='{{ old("purchase_price", $inventory->purchase_price) }}'
                />
                @error("purchase_price")
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">{{ __('Stock quantity') }} *
                    <i
                        data-toggle="tooltip"
                        class="flaticon-questions-circular-button"
                        data-title="Number of items you have on your warehouse"
                    ></i>
                </label>
                <input
                    type="text"
                    name="stock_quantity"
                    value="{{ old("stock_quantity", $inventory->stock_quantity) }}"
                    class="form-control {{ $errors->has("stock_quantity") ? 'is-invalid' : '' }}"
                    placeholder="{{ __('Enter stock quantity') }}"
                >
                @error("stock_quantity")
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ __('Sale Price') }} *
                    <i
                        data-toggle="tooltip"
                        class="flaticon-questions-circular-button"
                        data-title="The price without any tax. Tax will be calculated autometically based on shipping zone."
                    ></i>
                </label>
                <x-number-input
                    allow-minus="false"
                    key="sale_price"
                    name="sale_price"
                    class="form-control {{ $errors->has('sale_price') ? 'is-invalid' : '' }}"
                    value='{{ old("sale_price", $inventory->sale_price) }}'

                />
                @error("sale_price")
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group variant_offer_price">
                <label>{{ __('Offer price') }}
                    <i
                        data-toggle="tooltip"
                        class="flaticon-questions-circular-button"
                        data-title="The offer price will be effected between the offer start and end dates"
                    ></i>
                </label>
                <x-number-input
                    allow-minus="false"
                    key="offer_price"
                    name="offer_price"
                    class="form-control {{ $errors->has('offer_price') ? 'is-invalid' : '' }}"
                    value='{{ old("offer_price", $inventory->offer_price) }}'
                />
                @error("offer_price")
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>
