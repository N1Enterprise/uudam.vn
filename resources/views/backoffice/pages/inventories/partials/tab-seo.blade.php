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
                    <label for="">{{ __('Meta') }}</label>
                    <div id="json_editor_meta" style="height: 200px"></div>
                    <input type="hidden" name="meta" value="{{ old('meta', display_json_value($inventory->meta)) }}">
                </div>

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

                <div class="form-group row">
                    <label class="col-2 col-form-label">{{ __('Hiển thị FE') }}</label>
                    <div class="col-3">
                        <span class="k-switch">
                            <label>
                                <input type="checkbox" {{ boolean(old('display_on_frontend', $inventory->display_on_frontend)) ? 'checked' : '' }} value="1" name="display_on_frontend" />
                                <span></span>
                            </label>
                        </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label">{{ __('Tìm kiếm FE') }}</label>
                    <div class="col-3">
                        <span class="k-switch">
                            <label>
                                <input type="checkbox" {{ boolean(old('allow_frontend_search', $inventory->allow_frontend_search)) ? 'checked' : '' }} value="1" name="allow_frontend_search" />
                                <span></span>
                            </label>
                        </span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label">{{ __('Hoạt động') }}</label>
                    <div class="col-3">
                        <span class="k-switch">
                            <label>
                                <input type="checkbox" {{ boolean(empty($inventory->id) ? 1 : old('status', $inventory->status) ) ? 'checked' : '' }} value="1" name="status" />
                                <span></span>
                            </label>
                        </span>
                    </div>
                </div>
            </div>

            <div class="k-portlet__foot">
                <div class="k-form__actions d-flex justify-content-end">
                    <button type="redirect" class="btn btn-secondary mr-2">{{ __('Huỷ') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Lưu') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
