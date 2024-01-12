// ==== ADDRESS_FOR_CHECKOUT LOGIC ==== //
$(() => {
    const ADDRESS_FOR_CHECKOUT = {
        elements: {
            shipping_province: $('#customer_shipping_province'),
            shipping_district: $('#customer_shipping_district'),
            shipping_ward: $('#customer_shipping_ward'),
        },
        init: () => {
            ADDRESS_FOR_CHECKOUT.loadProvinces();
            ADDRESS_FOR_CHECKOUT.onChangeProvince();
            ADDRESS_FOR_CHECKOUT.onChangeDistrict();
        },
        buildHTMLOptions: (data, emptyLabel = '') => {
            if (! data?.length) {
                return `<option value="" selected>${emptyLabel}</option>`;
            }

            const options = data.map((item) => `<option value="${item.code}">${item.full_name}</option>`);
            
            return [`<option value="" selected>${emptyLabel}</option>`, ...options].join('');
        },
        onChangeProvince: () => {
            ADDRESS_FOR_CHECKOUT.elements.shipping_province.on('change', function() {
                const code = $(this).val();

                ADDRESS_FOR_CHECKOUT.loadDistrictByProvinceCode(code);
            });
        },
        onChangeDistrict: () => {
            ADDRESS_FOR_CHECKOUT.elements.shipping_district.on('change', function() {
                const code = $(this).val();

                ADDRESS_FOR_CHECKOUT.loadWardsByProvinceCode(code);
            });
        },
        loadProvinces: () => {
            $.ajax({
                url: LOCALIZATION_ROUTES.api_provinces,
                method: 'GET',
                beforeSend: () => {
                    ADDRESS_FOR_CHECKOUT.elements.shipping_province.prop('disabled', true);
                    ADDRESS_FOR_CHECKOUT.elements.shipping_district.prop('disabled', true);
                    ADDRESS_FOR_CHECKOUT.elements.shipping_ward.prop('disabled', true);
                },
                success: (response) => {
                    ADDRESS_FOR_CHECKOUT.elements.shipping_province.html(ADDRESS_FOR_CHECKOUT.buildHTMLOptions(response?.data, 'Chọn tỉnh / thành'));
                    ADDRESS_FOR_CHECKOUT.elements.shipping_province.prop('disabled', false);
                }
            });
        },
        loadDistrictByProvinceCode: (code)  => {
            $.ajax({
                url: LOCALIZATION_ROUTES.api_districts_by_province.replace(':province', code),
                method: 'GET',
                beforeSend: () => {
                    ADDRESS_FOR_CHECKOUT.elements.shipping_province.prop('disabled', true);
                    ADDRESS_FOR_CHECKOUT.elements.shipping_district.prop('disabled', true);
                    ADDRESS_FOR_CHECKOUT.elements.shipping_ward.prop('disabled', true);
                },
                success: (response) => {
                    ADDRESS_FOR_CHECKOUT.elements.shipping_district.html(ADDRESS_FOR_CHECKOUT.buildHTMLOptions(response?.data, 'Chọn quận / huyện'));
                    ADDRESS_FOR_CHECKOUT.elements.shipping_province.prop('disabled', false);
                    ADDRESS_FOR_CHECKOUT.elements.shipping_district.prop('disabled', false);
                }
            });
        },
        loadWardsByProvinceCode: (code) => {
            $.ajax({
                url: LOCALIZATION_ROUTES.api_wards_by_district.replace(':district', code),
                method: 'GET',
                beforeSend: () => {
                    ADDRESS_FOR_CHECKOUT.elements.shipping_province.prop('disabled', true);
                    ADDRESS_FOR_CHECKOUT.elements.shipping_district.prop('disabled', true);
                    ADDRESS_FOR_CHECKOUT.elements.shipping_ward.prop('disabled', true);
                },
                success: (response) => {
                    ADDRESS_FOR_CHECKOUT.elements.shipping_ward.html(ADDRESS_FOR_CHECKOUT.buildHTMLOptions(response?.data, 'Chọn phường / xã'));
                    ADDRESS_FOR_CHECKOUT.elements.shipping_province.prop('disabled', false);
                    ADDRESS_FOR_CHECKOUT.elements.shipping_district.prop('disabled', false);
                    ADDRESS_FOR_CHECKOUT.elements.shipping_ward.prop('disabled', false);
                }
            });
        },
    };

    const ADDRESS_FOR_NEW = {
        elements: {
            shipping_province: $('#address_new_shipping_province'),
            shipping_district: $('#address_new_shipping_district'),
            shipping_ward: $('#address_new_shipping_ward'),
            modal_new_address: $('.modal-add-address')
        },
        init: () => {
            ADDRESS_FOR_NEW.loadProvinces();
            ADDRESS_FOR_NEW.onChangeProvince();
            ADDRESS_FOR_NEW.onChangeDistrict();
            ADDRESS_FOR_NEW.onShowModal();
            ADDRESS_FOR_NEW.onCloseModal();
        },
        onShowModal: () => {
            $('.show-modal-add-address').on('click', function() {
                ADDRESS_FOR_NEW.elements.modal_new_address.attr('open', true);
            });
        },
        onCloseModal: () => {
            $('.modal-add-address [data-overlay-close]').on('click', function() {
                ADDRESS_FOR_NEW.elements.modal_new_address.removeAttr('open');
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
        loadProvinces: () => {
            $.ajax({
                url: LOCALIZATION_ROUTES.api_provinces,
                method: 'GET',
                beforeSend: () => {
                    ADDRESS_FOR_NEW.elements.shipping_province.prop('disabled', true);
                    ADDRESS_FOR_NEW.elements.shipping_district.prop('disabled', true);
                    ADDRESS_FOR_NEW.elements.shipping_ward.prop('disabled', true);
                },
                success: (response) => {
                    console.log({ response });
                    ADDRESS_FOR_NEW.elements.shipping_province.html(ADDRESS_FOR_NEW.buildHTMLOptions(response?.data, 'Chọn tỉnh / thành'));
                    ADDRESS_FOR_NEW.elements.shipping_province.prop('disabled', false);
                }
            });
        },
        loadDistrictByProvinceCode: (code)  => {
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
                }
            });
        },
        loadWardsByProvinceCode: (code) => {
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
                }
            });
        },
    };

    ADDRESS_FOR_NEW.init();
    ADDRESS_FOR_CHECKOUT.init();
});

$(() => {
    $('[data-form="create-address"]').validate({
        rules: {
            name: {
                required: true,
                minlength: 2,
                maxlength: 255,
            },
            email: {
                required: true,
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
                required: false,
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
                maxlength: 'Không lớn hơn 255 ký tự',
                minlength: 'Địa chỉ nhận bạn quá ngắn'
            },
        },
        submitHandler: function(form) {
            console.log({ form });
        }
    });
});