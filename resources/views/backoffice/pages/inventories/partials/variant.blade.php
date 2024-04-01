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
                        <div data-toggle="collapse" data-target="#variant_{{ $loop->index }}">
                            <b>
                                <span>[{{ $parentIndex + 1 }}]</span>
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

                    <div class="collapse repeater-body" id="variant_{{ $loop->index }}">
                        <div class="form-group">
                            <label>{{ __('Hình ảnh') }}
                                <i
                                    data-toggle="tooltip"
                                    class="flaticon-questions-circular-button"
                                    data-title="Hình ảnh của biến thể."
                                ></i>
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="upload_image_custom position-relative">
                                        <input type="text" data-image-ref-path="variant" data-image-ref-index="{{ $loop->index }}" class="form-control variant_image_path" name="variants[image][{{ $loop->index }}][path]" placeholder="{{ __('Tải lên hình ảnh hoặc URL đầu vào') }}" style="padding-right: 104px;" value="{{ old("variants.image.$loop->index.path", data_get($inventory, 'image', data_get($product, 'primary_image'))) }}">
                                        <div data-image-ref-wrapper="variant" data-image-ref-index="{{ $loop->index }}" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                                            <div class="d-flex align-items-center h-100">
                                                <img data-image-ref-img="variant" data-image-ref-index="{{ $loop->index }}" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                                                <span data-image-ref-delete="variant" data-image-ref-index="{{ $loop->index }}" style="font-size: 16px; cursor: pointer;">&times;</span>
                                            </div>
                                        </div>
                                        <label for="variant_image_file_{{ $loop->index }}" class="variant_image_file_wapper btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                                            <input type="file" name="variants[image][{{ $loop->index }}][file]" data-image-ref-file="variant" data-image-ref-index="{{ $loop->index }}" id="variant_image_file_{{ $loop->index }}" class="d-none variant_image_file">
                                            <i class="flaticon2-image-file"></i>
                                            <span>{{ __('Tải lên') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div class="image_variant_image_review">
                                            <div data-image-ref-review-wrapper="variant" data-image-ref-index="{{ $loop->index }}" class="d-none" style="width: 100px; height: 100px; border: 1px solid #ccc;">
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
                                    <label for="">{{ __('Weight') }}</label>
                                    <div class="input-group">
                                        <x-number-input
                                            name="variants[weight][{{ $loop->index }}]"
                                            key="variants[weight][{{ $loop->index }}]"
                                            class='form-control {{ $errors->has("variants.weight.$loop->index") ? "is-invalid" : "" }}'
                                            placeholder="{{ __('10,01') }}"
                                            value='{{ old("variants.weight.$loop->index", $inventory->weight) }}'
                                        />
                                        <div class="input-group-append"><span class="input-group-text">{{ __('gam(g)') }}</span></div>
                                    </div>
                                    @error("variants.sku.{{ $loop->index }}")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                            data-title="SKU (Đơn vị lưu kho) là mã nhận dạng cụ thể của người bán. Nó sẽ giúp quản lý hàng tồn kho của bạn"
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
                                    <label>{{ __('Tình trạng') }} *
                                        <i
                                            data-toggle="tooltip"
                                            class="flaticon-questions-circular-button"
                                            data-title="Tình trạng hiện tại của sản phẩm là gì?"
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
                                    <label for="">{{ __('Số lượng') }} *
                                        <i
                                            data-toggle="tooltip"
                                            class="flaticon-questions-circular-button"
                                            data-title="Số lượng mặt hàng bạn có trong kho của mình"
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
                                    <label>{{ __('Giá mua') }}
                                        <i
                                            data-toggle="tooltip"
                                            class="flaticon-questions-circular-button"
                                            data-title="Trường được đề xuất. Điều này sẽ giúp tính toán lợi nhuận và tạo báo cáo"
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
                                    <label>{{ __('Giá bán') }} *
                                        <i
                                            data-toggle="tooltip"
                                            class="flaticon-questions-circular-button"
                                            data-title="Giá chưa có thuế. Thuế sẽ được tính tự động dựa trên khu vực vận chuyển."
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
                                    <label>{{ __('Giá khuyến mãi') }}
                                        <i
                                            data-toggle="tooltip"
                                            class="flaticon-questions-circular-button"
                                            data-title="Giá ưu đãi sẽ được thực hiện giữa ngày bắt đầu và ngày kết thúc ưu đãi"
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
