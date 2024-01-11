// ==== LOCALIZATION LOGIC ==== //
$(() => {
    const LOCALIZATION = {
        elements: {
            shipping_province: $('#customer_shipping_province'),
            shipping_district: $('#customer_shipping_district'),
            shipping_ward: $('#customer_shipping_ward'),
        },
        init: () => {
            LOCALIZATION.loadProvinces();
            LOCALIZATION.onChangeProvince();
            LOCALIZATION.onChangeDistrict();
        },
        buildHTMLOptions: (data, emptyLabel = '') => {
            if (! data?.length) {
                return `<option value="" selected>${emptyLabel}</option>`;
            }

            const options = data.map((item) => `<option value="${item.code}">${item.full_name}</option>`);
            
            return [`<option value="" selected>${emptyLabel}</option>`, ...options].join('');
        },
        onChangeProvince: () => {
            LOCALIZATION.elements.shipping_province.on('change', function() {
                const code = $(this).val();

                LOCALIZATION.loadDistrictByProvinceCode(code);
            });
        },
        onChangeDistrict: () => {
            LOCALIZATION.elements.shipping_district.on('change', function() {
                const code = $(this).val();

                LOCALIZATION.loadWardsByProvinceCode(code);
            });
        },
        loadProvinces: () => {
            $.ajax({
                url: LOCALIZATION_ROUTES.api_provinces,
                method: 'GET',
                beforeSend: () => {
                    LOCALIZATION.elements.shipping_province.prop('disabled', true);
                    LOCALIZATION.elements.shipping_district.prop('disabled', true);
                    LOCALIZATION.elements.shipping_ward.prop('disabled', true);
                },
                success: (response) => {
                    LOCALIZATION.elements.shipping_province.html(LOCALIZATION.buildHTMLOptions(response?.data, 'Chọn tỉnh / thành'));
                    LOCALIZATION.elements.shipping_province.prop('disabled', false);
                }
            });
        },
        loadDistrictByProvinceCode: (code)  => {
            $.ajax({
                url: LOCALIZATION_ROUTES.api_districts_by_province.replace(':province', code),
                method: 'GET',
                beforeSend: () => {
                    LOCALIZATION.elements.shipping_province.prop('disabled', true);
                    LOCALIZATION.elements.shipping_district.prop('disabled', true);
                    LOCALIZATION.elements.shipping_ward.prop('disabled', true);
                },
                success: (response) => {
                    LOCALIZATION.elements.shipping_district.html(LOCALIZATION.buildHTMLOptions(response?.data, 'Chọn quận / huyện'));
                    LOCALIZATION.elements.shipping_province.prop('disabled', false);
                    LOCALIZATION.elements.shipping_district.prop('disabled', false);
                }
            });
        },
        loadWardsByProvinceCode: (code) => {
            $.ajax({
                url: LOCALIZATION_ROUTES.api_wards_by_district.replace(':district', code),
                method: 'GET',
                beforeSend: () => {
                    LOCALIZATION.elements.shipping_province.prop('disabled', true);
                    LOCALIZATION.elements.shipping_district.prop('disabled', true);
                    LOCALIZATION.elements.shipping_ward.prop('disabled', true);
                },
                success: (response) => {
                    LOCALIZATION.elements.shipping_ward.html(LOCALIZATION.buildHTMLOptions(response?.data, 'Chọn phường / xã'));
                    LOCALIZATION.elements.shipping_province.prop('disabled', false);
                    LOCALIZATION.elements.shipping_district.prop('disabled', false);
                    LOCALIZATION.elements.shipping_ward.prop('disabled', false);
                }
            });
        },
    };

    LOCALIZATION.init();
});