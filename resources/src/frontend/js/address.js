const ADDRESS_FOR_NEW = {
    elements: {
        shipping_province: $('#address_new_shipping_province'),
        shipping_district: $('#address_new_shipping_district'),
        shipping_ward: $('#address_new_shipping_ward'),
        modal: $('.modal-add-address'),
        edit_btn: $('[address-editable-btn]'),
    },
    province_loaded: false,
    district_loaded: false,
    ward_loaded: false,
    init: () => {
        ADDRESS_FOR_NEW.loadProvinces();
        ADDRESS_FOR_NEW.onChangeProvince();
        ADDRESS_FOR_NEW.onChangeDistrict();
        ADDRESS_FOR_NEW.onCreate();
        ADDRESS_FOR_NEW.onCloseModal();
        ADDRESS_FOR_NEW.onEdit();
        ADDRESS_FOR_NEW.onMarkAsDefault();
        ADDRESS_FOR_NEW.onUseCurrentLocation();
    },
    parseBrowserTrackingLocation: (location) => {
        const { address } = location;

        const amenity       = address?.amenity || '';
        const road          = address?.road || '';
        const quarter       = address?.quarter || '';
        const village       = address?.village || '';
        const suburb        = address?.suburb || '';
        const citydistrict  = address?.city_district || '';
        const city          = address?.city || '';
        const postcode      = address?.postcode || '';
        const country       = 'Việt Nam';

        console.log('[TRACKING RESPONSE] Geo location: ', {
            amenity,
            road,
            quarter,
            village,
            suburb,
            citydistrict,
            city,
            postcode,
            country,
        });

        return {
            road_name: [amenity, road].filter(item => !!item).join(', '),
            ward_name: quarter || village,
            district_name: suburb || citydistrict,
            province_name: city,
            country_name: country,
            postcode: postcode,
        }
    },
    onUseCurrentLocation: () => {
        $('[use-current-location-to-set-address]').on('click', function() {
            if (navigator.geolocation) {
                const options = {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0,
                };

                $('.address-overlay').addClass('show');

                function success(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    const reverseGeocodingAPI = 'https://nominatim.openstreetmap.org/reverse?format=json&lat=' + latitude + '&lon=' + longitude;

                    fetch(reverseGeocodingAPI)
                        .then(response => response.json())
                        .then(async location => {

                            const parsedLocation = ADDRESS_FOR_NEW.parseBrowserTrackingLocation(location);

                            const roadName     = parsedLocation.road_name;
                            const wardName     = parsedLocation.ward_name;
                            const districtName = parsedLocation.district_name;
                            const provinceName = parsedLocation.province_name;
                            const countryName  = parsedLocation.country_name;
                            const postcode     = parsedLocation.postcode;

                            $.ajax({
                                url: LOCALIZATION_ROUTES.api_get_address_by_locations_names,
                                method: 'GET',
                                data: {
                                    province_name:provinceName,
                                    district_name: districtName,
                                    ward_name: wardName
                                },
                                success: (data) => {
                                    const { ward, district, province } = data;

                                    const wardCode     = ward?.code || '';
                                    const districtCode = district?.code || '';
                                    const provinceCode = province?.code || '';

                                    const myDisplayName = [roadName, ward?.full_name || '', district?.full_name || '', province?.full_name || '', postcode, countryName]
                                        .filter(item => !!item)
                                        .join(', ');

                                    $('#address-form [name="address_line"]').val(myDisplayName);

                                    ADDRESS_FOR_NEW.loadProvinces(({ data }) => {
                                        ADDRESS_FOR_NEW.elements.modal.find('[name="province_code"]').val(provinceCode);

                                        ADDRESS_FOR_NEW.loadDistrictByProvinceCode(provinceCode, ({ data }) => {
                                            ADDRESS_FOR_NEW.elements.modal.find('[name="district_code"]').val(districtCode);

                                            ADDRESS_FOR_NEW.loadWardsByProvinceCode(districtCode, () => {
                                                ADDRESS_FOR_NEW.elements.modal.find('[name="ward_code"]').val(wardCode);
                                            });
                                        });
                                    });

                                    $('.address-overlay').removeClass('show');
                                }
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            toastr.warning('Định vị địa lý không được hỗ trợ bởi trình duyệt này');
                            $('.address-overlay').removeClass('show');
                        });
                }

                function error(err) {
                    console.warn(`ERROR(${err.code}): ${err.message}`);
                    toastr.warning('Định vị địa lý không được hỗ trợ bởi trình duyệt này');
                    $('.address-overlay').removeClass('show');
                }

                navigator.geolocation.getCurrentPosition(success, error, options);

            } else {
                toastr.warning('Định vị địa lý không được hỗ trợ bởi trình duyệt này');
                $('.address-overlay').removeClass('show');
            }
        });
    },
    onEdit: () => {
        ADDRESS_FOR_NEW.elements.edit_btn.on('click', function() {
            const code = $(this).attr('data-address-code');

            $('.address-overlay').addClass('show');

            ADDRESS_FOR_NEW.fetchAddressById(code, (address) => {
                ADDRESS_FOR_NEW.updateModalTextByAction(true);
                ADDRESS_FOR_NEW.elements.modal.find('[name="name"]').val(address.name);
                ADDRESS_FOR_NEW.elements.modal.find('[name="email"]').val(address.email);
                ADDRESS_FOR_NEW.elements.modal.find('[name="phone"]').val(address.phone);
                ADDRESS_FOR_NEW.elements.modal.find('[name="address_line"]').val(address.address_line);

                ADDRESS_FOR_NEW.loadProvinces(({ data }) => {
                    ADDRESS_FOR_NEW.elements.modal.find('[name="province_code"]').val(address.province_code);

                    ADDRESS_FOR_NEW.loadDistrictByProvinceCode(address.province_code, ({ data }) => {
                        ADDRESS_FOR_NEW.elements.modal.find('[name="district_code"]').val(address.district_code);

                        ADDRESS_FOR_NEW.loadWardsByProvinceCode(address.district_code, () => {
                            ADDRESS_FOR_NEW.elements.modal.find('[name="ward_code"]').val(address.ward_code);
                            handleWhenAddLoaded();
                        });
                    });
                });

                function handleWhenAddLoaded() {
                    ADDRESS_FOR_NEW.elements.modal.find('[name="is_default"]').prop('checked', address.is_default);
                    ADDRESS_FOR_NEW.elements.modal.attr('open', true);
                }
            });

            $('.address-overlay').removeClass('show');
        });
    },
    onCreate: () => {
        $('.show-modal-add-address').on('click', function() {
            const userData = JSON.parse($('[data-authenticated-user]').attr('data-authenticated-user') || '{}');
            ADDRESS_FOR_NEW.elements.modal.find('[name="name"]').val(userData?.name);
            ADDRESS_FOR_NEW.elements.modal.find('[name="email"]').val(userData?.email);
            ADDRESS_FOR_NEW.elements.modal.find('[name="phone"]').val(userData?.phone_number);

            ADDRESS_FOR_NEW.updateModalTextByAction(false);
            ADDRESS_FOR_NEW.elements.modal.attr('open', true);
            $('.address-overlay').removeClass('show');
        });
    },
    onCloseModal: () => {
        $('.modal-add-address [data-overlay-close]').on('click', function() {
            ADDRESS_FOR_NEW.updateModalTextByAction(null);
            ADDRESS_FOR_NEW.elements.modal.removeAttr('open');
            $('.address-overlay').removeClass('show');
        });
    },
    buildHTMLOptions: (data, emptyLabel = '') => {
        if (! data?.length) {
            return `<option value="" selected>${emptyLabel}</option>`;
        }

        const options = data.map((item) => `<option value="${item.code}">${item.full_name}</option>`);

        return [`<option value="" selected>${emptyLabel}</option>`, ...options].join('');
    },
    onChangeProvince: () => {
        ADDRESS_FOR_NEW.elements.shipping_province.on('change', function() {
            const code = $(this).val();

            ADDRESS_FOR_NEW.loadDistrictByProvinceCode(code);
        });
    },
    onChangeDistrict: () => {
        ADDRESS_FOR_NEW.elements.shipping_district.on('change', function() {
            const code = $(this).val();

            ADDRESS_FOR_NEW.loadWardsByProvinceCode(code);
        });
    },
    loadProvinces: (callback = () => undefined) => {
        $.ajax({
            url: LOCALIZATION_ROUTES.api_provinces,
            method: 'GET',
            beforeSend: () => {
                ADDRESS_FOR_NEW.elements.shipping_province.prop('disabled', true);
                ADDRESS_FOR_NEW.elements.shipping_district.prop('disabled', true);
                ADDRESS_FOR_NEW.elements.shipping_ward.prop('disabled', true);
            },
            success: (response) => {
                ADDRESS_FOR_NEW.elements.shipping_province.html(ADDRESS_FOR_NEW.buildHTMLOptions(response?.data, 'Chọn tỉnh / thành'));
                ADDRESS_FOR_NEW.elements.shipping_province.prop('disabled', false);
                return callback({ data: response });
            }
        });
    },
    loadDistrictByProvinceCode: (code, callback = () => undefined)  => {
        ADDRESS_FOR_NEW.elements.shipping_district.html(ADDRESS_FOR_NEW.buildHTMLOptions([], 'Chọn quận / huyện'));
        ADDRESS_FOR_NEW.elements.shipping_ward.html(ADDRESS_FOR_NEW.buildHTMLOptions([], 'Chọn phường / xã'));

        $.ajax({
            url: LOCALIZATION_ROUTES.api_districts_by_province.replace(':province', code),
            method: 'GET',
            beforeSend: () => {
                ADDRESS_FOR_NEW.elements.shipping_province.prop('disabled', true);
                ADDRESS_FOR_NEW.elements.shipping_district.prop('disabled', true);
                ADDRESS_FOR_NEW.elements.shipping_ward.prop('disabled', true);
            },
            success: (response) => {
                ADDRESS_FOR_NEW.elements.shipping_district.html(ADDRESS_FOR_NEW.buildHTMLOptions(response?.data, 'Chọn quận / huyện'));
                ADDRESS_FOR_NEW.elements.shipping_province.prop('disabled', false);
                ADDRESS_FOR_NEW.elements.shipping_district.prop('disabled', false);
                return callback({ code, data: response });
            }
        });
    },
    loadWardsByProvinceCode: (code, callback = () => undefined) => {
        $.ajax({
            url: LOCALIZATION_ROUTES.api_wards_by_district.replace(':district', code),
            method: 'GET',
            beforeSend: () => {
                ADDRESS_FOR_NEW.elements.shipping_province.prop('disabled', true);
                ADDRESS_FOR_NEW.elements.shipping_district.prop('disabled', true);
                ADDRESS_FOR_NEW.elements.shipping_ward.prop('disabled', true);
            },
            success: (response) => {
                ADDRESS_FOR_NEW.elements.shipping_ward.html(ADDRESS_FOR_NEW.buildHTMLOptions(response?.data, 'Chọn phường / xã'));
                ADDRESS_FOR_NEW.elements.shipping_province.prop('disabled', false);
                ADDRESS_FOR_NEW.elements.shipping_district.prop('disabled', false);
                ADDRESS_FOR_NEW.elements.shipping_ward.prop('disabled', false);
                return callback({ code, data: response });
            }
        });
    },
    fetchAddressById: (code, callback = () => undefined) => {
        $.ajax({
            url: LOCALIZATION_ROUTES.api_address_detail.replace(':code', code),
            method: 'GET',
            beforeSend: () => {
                ADDRESS_FOR_NEW.elements.edit_btn.addClass('prevent');
            },
            success: (response) => {
                return callback(response);
            },
        });
    },
    updateModalTextByAction: (editable = false) => {
        if (editable === null) {
            ADDRESS_FOR_NEW.elements.modal.find('[data-form-title-text]').text('');
            ADDRESS_FOR_NEW.elements.modal.find('[data-button-submit-text]').text('');
            ADDRESS_FOR_NEW.elements.modal.find('[data-form]').attr('data-form', '');
            ADDRESS_FOR_NEW.elements.modal.find('[name="name"]').val('');
            ADDRESS_FOR_NEW.elements.modal.find('[name="email"]').val('');
            ADDRESS_FOR_NEW.elements.modal.find('[name="phone"]').val('');
            ADDRESS_FOR_NEW.elements.modal.find('[name="address_line"]').val('');
            ADDRESS_FOR_NEW.elements.modal.find('[name="province_code"]').val('');
            ADDRESS_FOR_NEW.elements.modal.find('[name="district_code"]').val('');
            ADDRESS_FOR_NEW.elements.modal.find('[name="ward_code"]').val('');
            ADDRESS_FOR_NEW.elements.modal.find('[name="is_default"]').prop('checked', true);
            return;
        }

        if (editable) {
            ADDRESS_FOR_NEW.elements.modal.find('[data-form-title-text]').text('Chỉnh sửa địa chỉ');
            ADDRESS_FOR_NEW.elements.modal.find('[data-button-submit-text]').text('Cập nhật');
            ADDRESS_FOR_NEW.elements.modal.find('[data-form]').attr('data-form', 'edit-address');
        } else {
            ADDRESS_FOR_NEW.elements.modal.find('[data-form-title-text]').text('Thêm địa chỉ');
            ADDRESS_FOR_NEW.elements.modal.find('[data-button-submit-text]').text('Thêm mới');
            ADDRESS_FOR_NEW.elements.modal.find('[data-form]').attr('data-form', 'create-address');
        }
    },
    onMarkAsDefault: () => {
        $('.mark-as-default-address').on('click', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('href'),
                method: $(this).attr('data-method'),
                data: {},
                beforeSend: () => {
                    $(this).text('Đang cập nhật');
                    $(this).addClass('prevent');
                },
                success: () => {
                    location.reload();
                },
                error: () => {
                    toastr.error('Cập nhật không thành công');
                    $(this).removeClass('prevent');
                    $(this).text('Đặt làm mặt định');
                },
            });
        });
    },
};


ADDRESS_FOR_NEW.init();

$(document).ready(function() {
    $('#address-form').validate({
        rules: {
            name: {
                required: true,
                minlength: 2,
                maxlength: 255,
            },
            email: {
                required: false,
                maxlength: 255,
                validate_email: true,
            },
            phone: {
                required: true,
                minlength: 8,
                maxlength: 13,
                validate_phone: true
            },
            province_code: {
                required: true,
            },
            district_code: {
                required: true,
            },
            ward_code: {
                required: true,
            },
            address_line: {
                required: true,
                minlength: 2,
                maxlength: 255,
            },
            is_default: {
                required: false,
            }
        },
        messages: {
            name: {
                required: 'Vui lòng nhập họ và tên',
                maxlength: 'Không lớn hơn 255 ký tự',
                minlength: 'Tên bạn quá ngắn'
            },
            email: {
                required: 'Vui lòng nhập e-mail',
                maxlength: 'Không lớn hơn 255 ký tự',
                validate_email: "E-mail không hợp lệ"
            },
            province_code: {
                required: 'Vui lòng tỉnh / thành',
            },
            district_code: {
                required: 'Vui lòng quận / huyện',
            },
            ward_code: {
                required: 'Vui lòng phường / xã',
            },
            phone: {
                required: 'Vui lòng nhập số điện thoại',
                maxlength: 'Không lớn hơn 13 ký tự',
                minlength: 'Số điện thoại quá ngắn',
                validate_phone: "Số điện thoại không hợp lệ"
            },
            address_line: {
                required: 'Vui lòng nhập địa chỉ',
                maxlength: 'Không lớn hơn 255 ký tự',
                minlength: 'Địa chỉ nhận bạn quá ngắn'
            },
        },
        submitHandler: function(form) {
            const formData = $(form).serialize();
            const route    = $(form).attr('action');
            const method   = $(form).attr('method');
            const $self    = $(form);

            const redirectUrl = $(form).attr('data-redirect');
            const originalButtonText = $self.find('[data-button-submit-text]').text();

            $.ajax({
                url: route,
                method: method,
                data: formData,
                beforeSend: () => {
                    $self.find('button[type="submit"]').prop('disabled', true);
                    $self.find('[data-button-submit-text]').text('Đang xử lý...');
                },
                success: (response) => {
                    toastr.success(method == 'POST' ? 'Thêm thành công,' : 'Cập nhật thành công.');

                    if (redirectUrl) {
                        return window.location.href = redirectUrl;
                    }

                    window.location.reload();
                },
                error: () => {
                    $self.find('button[type="submit"]').prop('disabled', false);
                    $self.find('[data-button-submit-text]').text(originalButtonText);

                    toastr.error(method == 'POST' ? 'Thêm không thành công,' : 'Cập nhật không thành công.');
                },
            });
        }
    });
});
