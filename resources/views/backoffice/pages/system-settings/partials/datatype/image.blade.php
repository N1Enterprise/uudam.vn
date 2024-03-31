<div class="section_settingValue" data-setting-key="{{ data_get($setting, 'key') }}">
    <span class="display_settingValue {{ !data_get($setting, 'value') ? 'text-secondary value-bordered' : '' }}" data-setting-key="{{ data_get($setting, 'key') }}">
        {{ data_get($setting, 'value') ? data_get($setting, 'value') : __('N/A') }}
    </span>
</div>
@can('system-settings.update')
<div class="section_settingAction w-100" data-setting-key="{{ data_get($setting, 'key') }}">
    <div class="row-custom d-flex">
        <div class="col-md-6-custom mr-2" style="flex: 1;">
            <div class="upload_image_custom position-relative">
                <input type="text" data-image-ref-path="primary" data-image-ref-index="0" class="form-control image_primary_image_url" name="primary_image[path]" placeholder="{{ __('Tải ảnh lên hoặc nhập URL ảnh') }}" style="padding-right: 104px;">
                <div data-image-ref-wrapper="primary" data-image-ref-index="0" class="d-none w-100 position-absolute d-none" style="top: 50%; left: 4px; transform: translateY(-50%); height: 90%; background-color: #fff;">
                    <div class="d-flex align-items-center h-100">
                        <img data-image-ref-img="primary" data-image-ref-index="0" src="" alt="Image preview" class="mr-2" style="height: 100%; width: 100px;">
                        <span data-image-ref-delete="primary" data-image-ref-index="0" style="font-size: 16px; cursor: pointer;">&times;</span>
                    </div>
                </div>
                <label for="image_primary_image" class="btn position-absolute btn-secondary upload_image_custom_append_icon btn-sm d-flex">
                    <input type="file" id="image_primary_image" data-image-ref-path="file" data-image-ref-index="0" name="primary_image[file]" class="d-none image_primary_image_file">
                    <i class="flaticon2-image-file"></i>
                    <span>{{ __('Tải lên') }}</span>
                </label>
            </div>
            <input type="hidden" class="form-control @anyerror('primary_image, primary_image.file, primary_image.path') is-invalid @endanyerror">
            @anyerror('primary_image, primary_image.file, primary_image.path')
            {{ $displayMessages() }}
            @endanyerror
        </div>
        <div class="col-md-6-custom">
            <div class="image_primary_image_review">
                <div data-image-ref-review-wrapper="primary" data-image-ref-index="0" class="d-none" style="width: 70px; height: 70px; border: 1px solid #ccc;">
                    <img data-image-ref-review-img="primary" data-image-ref-index="0" style="width: 100%; height: 100%;" src="" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
@endcan
