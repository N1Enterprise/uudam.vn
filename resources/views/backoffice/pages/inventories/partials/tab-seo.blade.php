<div class="row">
    <div class="col-md-12">
        <div class="k-portlet">
            <div class="k-portlet__head">
                <div class="k-portlet__head-label">
                    <h3 class="k-portlet__head-title">{{ __('THÔNG TIN KHÁC & SEO') }}</h3>
                </div>
            </div>
            <div class="k-portlet__body">
                <div class="form-group">
                    <label>
                        <span>{{ __('[SEO] Từ khoá') }}</span>
                        <small>(* Cách nha bằng dấu phẩy)</small>
                    </label>
                    <input
                        type="text"
                        class="form-control {{ $errors->has('meta_keywords') ? 'is-invalid' : '' }}"
                        name="meta_keywords"
                        placeholder="{{ __('Nhập [SEO] từ khoá') }}"
                        value="{{ old('meta_keywords', $inventory->meta_keywords) }}"
                    >
                    @error('meta_keywords')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>{{ __('[SEO] Tiêu đề') }}</label>
                    <input
                        type="text"
                        class="form-control {{ $errors->has('meta_title') ? 'is-invalid' : '' }}"
                        name="meta_title"
                        placeholder="{{ __('Nhập [SEO] tiêu đề') }}"
                        value="{{ old('meta_title', $inventory->meta_title) }}"
                    >
                    @error('meta_title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>{{ __('[SEO] Mô tả') }}</label>
                    <input
                        type="text"
                        class="form-control {{ $errors->has('meta_description') ? 'is-invalid' : '' }}"
                        name="meta_description"
                        placeholder="{{ __('Nhập [SEO] tiêu đề') }}"
                        value="{{ old('meta_description', $inventory->meta_description) }}"
                    >
                    @error('meta_description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
