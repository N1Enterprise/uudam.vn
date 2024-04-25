<div class="row">
    <div class="col-md-12">
        <div class="k-portlet">
            <div class="k-portlet__head">
                <div class="k-portlet__head-label">
                    <h3 class="k-portlet__head-title">{{ __('Đặt điểm nổi bật') }}</h3>
                </div>
            </div>
            <div class="k-portlet__body">
                @include('backoffice.pages.inventories.partials.key-features')
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="k-portlet">
            <div class="k-portlet__head">
                <div class="k-portlet__head-label">
                    <h3 class="k-portlet__head-title">{{ __('Thôn tin chi tiết') }}</h3>
                </div>
            </div>
            <div class="k-portlet__body">
                <div class="form-group">
                    <label for="">{{ __('Meta') }}</label>
                    <div id="json_editor_meta" style="height: 200px"></div>
                    <input type="hidden" name="meta" value="{{ old('meta', display_json_value($inventory->meta)) }}">
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
        </div>
    </div>
</div>

