<div class="simple">
    <div class="form-group">
        <label>{{ __('Hỉnh ảnh') }}
            <i
                data-toggle="tooltip"
                class="flaticon-questions-circular-button"
                data-title="Hình ảnh của sản phẩm"
            ></i>
        </label>
        <div class="row">
            <div class="col-md-6">
                <div class="upload_image_custom position-relative">
                    <input type="text" data-image-ref-path="variant" data-image-ref-index="0" class="form-control variant_image_path" name="image[path]" placeholder="{{ __('Tải lên hình ảnh hoặc URL đầu vào') }}" style="padding-right: 104px;" value="{{ old('image.path', data_get($inventory, 'image', data_get($product, 'primary_image'))) }}">
                    <div data-image-ref-wrapper="variant" data-image-ref-index="0" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                        <div class="d-flex align-items-center h-100">
                            <img data-image-ref-img="variant" data-image-ref-index="0" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                            <span data-image-ref-delete="variant" data-image-ref-index="0" style="font-size: 16px; cursor: pointer;">&times;</span>
                        </div>
                    </div>
                    <label for="variant_image_file_0" class="variant_image_file_wapper btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                        <input type="file" name="image[file]" data-image-ref-file="variant" data-image-ref-index="0" id="variant_image_file_0" class="d-none variant_image_file">
                        <i class="flaticon2-image-file"></i>
                        <span>{{ __('Tải lên') }}</span>
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-start">
                    <div class="image_variant_image_review">
                        <div data-image-ref-review-wrapper="variant" data-image-ref-index="0" class="d-none" style="width: 100px; height: 100px; border: 1px solid #ccc;">
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
                <label for="">{{ __('SKU') }} *
                    <i
                        data-toggle="tooltip"
                        class="flaticon-questions-circular-button"
                        data-title="SKU (Đơn vị lưu kho) là mã nhận dạng cụ thể của người bán. Nó sẽ giúp quản lý hàng tồn kho của bạn."
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
                <label>{{ __('Tình trạng') }} *
                    <i
                        data-toggle="tooltip"
                        class="flaticon-questions-circular-button"
                        data-title="Tình trạng hiện tại của sản phẩm là gì?"
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
                <label for="">{{ __('Số lượng') }} *
                    <i
                        data-toggle="tooltip"
                        class="flaticon-questions-circular-button"
                        data-title="Số lượng mặt hàng bạn có trong kho của mình"
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
                <label>{{ __('Giá khuyến mãi') }}
                    <i
                        data-toggle="tooltip"
                        class="flaticon-questions-circular-button"
                        data-title="Giá ưu đãi sẽ được thực hiện giữa ngày bắt đầu và ngày kết thúc ưu đãi"
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

    <div class="row">
        <div class="col-md-12 mb-3">
            <b>{{ __('Kênh bán hàng liên kết') }}</b>
        </div>

        @foreach ($affiliateSalesChannels as $channel)
            @php $channelKey = data_get($channel, 'key'); @endphp
            <div class="col-md-12">
                <div class="form-group">
                    <label for="">{{ data_get($channel, 'name') }}</label>
                    <input
                        type="text"
                        name="sale_channels[{{ $channelKey }}]"
                        value="{{ old("sale_channels.$channelKey", data_get($inventory, ['sale_channels', $channelKey])) }}"
                        class="form-control {{ $errors->has("sale_channels.$channelKey") ? 'is-invalid' : '' }}"
                        placeholder="{{ __('Link liên kết kênh bán ') . data_get($channel, 'name') }}"
                    >

                    <a class="btn btn-sm btn-outline-primary mt-2" target="_blank" href="{{ old("sale_channels.$channelKey", data_get($inventory, ['sale_channels', $channelKey])) }}">{{ data_get($channel, 'name') }}</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
