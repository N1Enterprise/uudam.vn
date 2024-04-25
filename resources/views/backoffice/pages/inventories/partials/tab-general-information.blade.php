<div class="row">
    <div class="col-md-12">
        <div class="k-portlet">
            <div class="k-portlet__head">
                <div class="k-portlet__head-label">
                    <h3 class="k-portlet__head-title">{{ __('SẢN PHẨM') }}</h3>
                </div>
            </div>
            <div class="k-portlet__body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="thumnail" style="width: 100%; height: 170px; padding: 3px; border: 1px solid #bbbbbb;">
                            <img src="{{ $product->primary_image }}" class="w-100 h-100" style="object-fit: cover;" alt="Primary image">
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="row">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="" class="d-flex justify-content-between">
                                        <span>{{ __('Tên') }} *</span>
                                        <a href="{{ route('bo.web.products.edit', $product->id) }}" target="_blank">
                                            <i class="flaticon-eye"></i>
                                            <span>{{ __('Chi tiết') }}</span>
                                        </a>
                                    </label>
                                    <input type="text" class="form-control" value="[{{ $product->id }}] [{{ $product->code }}] {{ $product->name }}" required disabled>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('Thương hiệu') }} *</label>
                                    <input type="text" class="form-control" value="{{ $product->branch }}" required disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="">{{ __('Danh mục') }} *</label>
                                    <input type="text" class="form-control" value="{{ implode(', ', $product->categories->pluck('name')->toArray()) }}" required disabled>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">{{ __('Trạng thái') }} *</label>
                                    <input type="text" class="form-control" value="{{ $product->status_name }}" required disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="k-portlet">
            <div class="k-portlet__head">
                <div class="k-portlet__head-label">
                    <h3 class="k-portlet__head-title">{{ __('SẢN PHẨM KHO') }}</h3>
                </div>
            </div>

            <div class="k-portlet__body">
                @if ($inventory->id)
                <div class="form-group">
                    <label for="">{{ __('Xem chi tiết') }} *</label>

                    <div>
                        <a href="{{ route('fe.web.products.index', ['slug' => data_get($inventory, 'slug'), 'sku' => data_get($inventory, 'sku')]) }}" target="_blank">
                            {{ route('fe.web.products.index', ['slug' => data_get($inventory, 'slug'), 'sku' => data_get($inventory, 'sku')]) }}
                        </a>

                        <button type="button" data-copy-clipboard data-copy-clipboard-content="{{ route('fe.web.products.index', ['slug' => data_get($inventory, 'slug'), 'sku' => data_get($inventory, 'sku')]) }}" class="btn btn-sm btn-outline-primary ml-2">{{ __('COPY') }}</button>
                    </div>
                </div>
                @endif

                <div class="form-group">
                    <label for="">{{ __('Tiêu đề') }} *</label>
                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="{{ old('title', data_get($inventory, 'title', $product->name)) }}"
                        data-reference-slug="slug"
                        required
                    >
                </div>

                {{-- @if ($inventory->id)
                <div class="form-group">
                    <label for="">{{ __('Đường dẫn') }} *</label>
                    <input
                        type="text"
                        name="slug"
                        class="form-control"
                        value="{{ old('slug', data_get($inventory, 'slug')) }}"
                        required
                    >
                </div>
                @endif --}}

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('Có sẵn từ') }}
                                <i
                                    data-toggle="tooltip"
                                    data-title="Ngày mà hàng sẽ có sẵn. Mặc định = ngay lập tức"
                                    class="flaticon-questions-circular-button"
                                ></i>
                            </label>
                            <input
                                type="datetimepicker"
                                class="form-control @error('available_from') is-invalid @enderror"
                                name="available_from"
                                value="{{ old('available_from', data_get($inventory, 'available_from', date('Y-m-d h:i:s', strtotime(now())))) }}"
                            >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('Số lượng đặt hàng tối thiểu') }}
                                <i
                                    data-toggle="tooltip"
                                    class="flaticon-questions-circular-button"
                                    data-title="Số lượng cho phép nhận đặt hàng. Phải là một giá trị số nguyên. Mặc định = 1"
                                ></i>
                            </label>
                            <input
                                type="number"
                                class="form-control"
                                name="min_order_quantity"
                                value="{{ old('min_order_quantity', data_get($inventory, 'min_order_quantity')) }}"
                            >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('Khối lượng(g)') }}</label>
                            <div class="input-group">
                                <x-number-input
                                    name="weight"
                                    key="weight"
                                    class='form-control {{ $errors->has("weight") ? "is-invalid" : "" }}'
                                    placeholder="{{ __('10,01') }}"
                                    value='{{ old("weight", $inventory->weight) }}'
                                />
                                <div class="input-group-append"><span class="input-group-text">{{ __('gam(g)') }}</span></div>
                            </div>
                            @error('weight')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('Fake số lượng bán') }}
                                <i
                                    data-toggle="tooltip"
                                    class="flaticon-questions-circular-button"
                                    data-title="{{ __('Số lượng đã bán này chỉ dành cho khách hàng sử dụng.') }}"
                                ></i>
                            </label>
                            <input
                                type="number"
                                class="form-control"
                                name="init_sold_count"
                                min="0"
                                value="{{ old('init_sold_count', data_get($inventory, 'init_sold_count')) }}"
                            >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('Ngày bắt đầu ưu đãi') }}
                                <i
                                    data-toggle="tooltip"
                                    class="flaticon-questions-circular-button"
                                    data-title="Một khuyến mãi phải có ngày bắt đầu. Bắt buộc nếu trường giá ưu đãi được cung cấp"
                                ></i>
                            </label>
                            <input
                                type="datetimepicker"
                                class="form-control @error('offer_start') is-invalid @enderror"
                                name="offer_start"
                                value="{{ old('offer_start', $inventory->offer_start) }}"
                            >
                            @error('offer_start')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">{{ __('Ngày kết thúc ưu đãi') }}</label>
                            <input
                                type="datetimepicker"
                                class="form-control @error('offer_end') is-invalid @enderror"
                                name="offer_end"
                                value="{{ old('offer_end', $inventory->offer_end) }}"
                            >
                            @error('offer_end')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <x-content-editor id="condition_note" label="{{ __('Điều kiện mua kèm') }}" name="condition_note" value="{{ old('condition_note', data_get($inventory, 'condition_note')) }}" />
                </div>
            </div>
        </div>
    </div>
</div>
