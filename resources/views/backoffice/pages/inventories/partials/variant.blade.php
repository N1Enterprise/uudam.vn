<div class="variants">
    <div class="variants_repeater">
        <div data-repeater-list-custom="variants">
            @foreach($combinations as $combination)
                @php
                    $parentIndex = $loop->index;
                @endphp
            <div data-repeater-item-custom class="k-repeater__item" data-repeater-index="{{ $loop->index }}">
                <div class="repeater-wrapper">
                    <div class="repeater-head position-relative">
                        <div data-toggle="collapse" data-target="#variant_{{ $loop->index }}" aria-expanded="{{ $errors->isEmpty() && empty($inventory) ? 'false' : 'true' }}" aria-controls="variant_{{ $loop->index }}">
                            <b>
                                @foreach($combination as $attrId => $attrValue)
                                    <input type="hidden" name="variants[attribute][{{ $parentIndex }}][{{ $attrId }}]" value="{{ key($attrValue) }}">
                                    {{ $attributes[$attrId] .' : '. current($attrValue) }}
                                    {{ ($attrValue !== end($combination))?'; ':'' }}
                                @endforeach
                            </b>
                        </div>

                        <div class="repeater-control">
                            <button type="button" data-repeater-delete-custom class="btn btn-secondary btn-icon" style="width: 30px!important; height: 30px!important;">
                                <i class="la la-close"></i>
                            </button>
                        </div>
                    </div>

                    <div class="{{ $errors->isEmpty() && empty($inventory) ? 'collapse' : 'collapsed' }} repeater-body" id="variant_{{ $loop->index }}">
                        <div class="form-group">
                            <label>{{ __('Image') }}
                                <i
                                    data-toggle="tooltip"
                                    class="flaticon-questions-circular-button"
                                    data-title="The image of the variant"
                                ></i>
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="upload_image_custom position-relative">
                                        <input type="text" data-image-ref-path="variant" data-image-ref-index="{{ $loop->index }}" class="form-control variant_image_path" name="variants[image][{{ $loop->index }}][path]" placeholder="{{ __('Upload Image or Input URL') }}" style="padding-right: 104px;" value="{{ old("variants.image.$loop->index.path", data_get($inventory, 'image', data_get($product, 'primary_image'))) }}">
                                        <div data-image-ref-wapper="variant" data-image-ref-index="{{ $loop->index }}" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                                            <div class="d-flex align-items-center h-100">
                                                <img data-image-ref-img="variant" data-image-ref-index="{{ $loop->index }}" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                                                <span data-image-ref-delete="variant" data-image-ref-index="{{ $loop->index }}" aria-hidden="true" style="font-size: 16px; cursor: pointer;">&times;</span>
                                            </div>
                                        </div>
                                        <label for="variant_image_file_{{ $loop->index }}" class="variant_image_file_wapper btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                                            <input type="file" name="variants[image][{{ $loop->index }}][file]" data-image-ref-file="variant" data-image-ref-index="{{ $loop->index }}" id="variant_image_file_{{ $loop->index }}" class="d-none variant_image_file">
                                            <i class="flaticon2-image-file"></i>
                                            <span>{{ __('Upload') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="image_variant_image_review">
                                            <div data-image-ref-review-wapper="variant" data-image-ref-index="{{ $loop->index }}" class="d-none" style="width: 100px; height: 100px; border: 1px solid #ccc;">
                                                <img data-image-ref-review-img="variant" data-image-ref-index="{{ $loop->index }}" style="width: 100%; height: 100%;" src="" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">{{ __('Sku') }} *
                                        <i
                                            data-toggle="tooltip"
                                            class="flaticon-questions-circular-button"
                                            data-title="SKU (Stock Keeping Unit) is the seller specific identifier. It will help to manage your inventory"
                                        ></i>
                                    </label>
                                    <input
                                        type="text"
                                        name="variants[sku][{{ $loop->index }}]"
                                        value="{{ old("variants.sku.$loop->index", $inventory->sku) }}"
                                        class="form-control {{ $errors->has("variants.sku.$loop->index") ? 'is-invalid' : '' }}"
                                        placeholder="{{ __('Enter sku') }}"
                                    >
                                    @error("variants.sku.{{ $loop->index }}")
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
                                    <select name="variants[condition][{{ $loop->index }}]" class="form-control k_selectpicker {{ $errors->has("variants.condition.$loop->index") }}">
                                        @foreach($inventoryConditionEnumLabels as $key => $label)
                                        <option value="{{ $key }}" {{ old("variants[condition][$loop->index]", $inventory->condition) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error("variants.condition.{{ $loop->index }}")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
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
                                        name="variants[stock_quantity][{{ $loop->index }}]"
                                        value="{{ old("variants.stock_quantity.$loop->index", $inventory->stock_quantity) }}"
                                        class="form-control {{ $errors->has("variants.stock_quantity.$loop->index") ? 'is-invalid' : '' }}"
                                        placeholder="{{ __('Enter stock quantity') }}"
                                    >
                                    @error("variants.stock_quantity.{{ $loop->index }}")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

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
                                        key="purchase_price_{{ $loop->index }}"
                                        name="variants[purchase_price][{{ $loop->index }}]"
                                        class="form-control {{ $errors->has('variants.purchase_price.'.$loop->index) ? 'is-invalid' : '' }}"
                                        value='{{ old("variants.purchase_price.$loop->index", $inventory->purchase_price) }}'
                                    />
                                    @error("variants.purchase_price.{{ $loop->index }}")
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
                                        key="sale_price_{{ $loop->index }}"
                                        name="variants[sale_price][{{ $loop->index }}]"
                                        class="form-control {{ $errors->has('variants.sale_price.'.$loop->index) ? 'is-invalid' : '' }}"
                                        value='{{ old("variants.sale_price.$loop->index", $inventory->sale_price) }}'
                                    />
                                    @error("variants.sale_price.{{ $loop->index }}")
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
                                        key="offer_price_{{ $loop->index }}"
                                        name="variants[offer_price][{{ $loop->index }}]"
                                        class="form-control {{ $errors->has('variants.offer_price.'.$loop->index) ? 'is-invalid' : '' }}"
                                        value='{{ old("variants.offer_price.$loop->index", $inventory->offer_price) }}'
                                    />
                                    @error("variants.offer_price.{{ $loop->index }}")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
