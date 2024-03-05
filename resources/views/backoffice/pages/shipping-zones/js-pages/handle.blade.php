<script>
    $('[name="supported_provinces[]"]').on('changed.bs.select', function() {
        const codes = $(this).val();

        renderDistrictsByProvinces(codes);
    });

    function renderDistrictsByProvinces(provinces = []) {
        const element = $('[name="supported_districts[]"]');
        const districts = JSON.parse(element.attr('data-districts') || '[]');

        const originalValues = JSON.parse(element.attr('data-original-value') || '[]');

        const filteredDistricts = districts.filter(function(district) {
            return provinces.includes(district.province_code);
        });

        element.prop('disabled', !(filteredDistricts?.length || 0));
        element.html('');
        element.selectpicker('refresh');

        element.trigger('changed.bs.select');

        if (!filteredDistricts?.length) {
            return;
        }

        const options = provinces.map(function(code) {
            const provinceName = $(`.Supported_Provinces_Selector option[data-province-code="${code}"]`).attr('data-province-name');

            const group = $('<optgroup>').attr('label', provinceName);

            const options = filteredDistricts
                .filter((district) => district.province_code == code)
                .map(function(district) {
                    return $('<option>')
                        .attr('data-tokens', `${district.code} | ${district.province.full_name}`)
                        .attr('data-district-code', district.code)
                        .attr('data-district-name', district.full_name)
                        .val(district.code)
                        .text(`${district.full_name}`)
                });

            group.html(options);

            return group;
        });

        element.html(options);
        element.selectpicker('refresh');
        element.selectpicker('val', originalValues);
    }
</script>
