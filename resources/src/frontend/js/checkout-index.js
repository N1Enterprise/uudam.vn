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

    ADDRESS_FOR_CHECKOUT.init();
});
