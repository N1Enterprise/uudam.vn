<script>
    const ORDER_ADD_TO_CART = {
        cart_items: {},
        elements: {
            btn_add: $('#btn_add_to_cart'),
            cart_item: $('[name="inventory_id"]'),
            table: $('#items_in_cart_table'),
        },
        init: () => {
            ORDER_ADD_TO_CART.onAddToCart();
            ORDER_ADD_TO_CART.onSubmit();
        },
        onAddToCart: () => {
            ORDER_ADD_TO_CART.elements.btn_add.on('click', function() {
                const inventoryId = ORDER_ADD_TO_CART.elements.cart_item.val();

                const value = JSON.parse($(`[name="inventory_id"] option[data-inventory-id="${inventoryId}"]`).attr('data-value') || '{}');

                if (ORDER_ADD_TO_CART.cart_items[inventoryId]) {
                    fstoast.warning("{{ __('Sản phẩm đã được thêm') }}");
                    return;
                }

                const accepted = {
                    id: value.id,
                    image: value.image,
                    title: value.title,
                    final_price: value.final_price,
                    stock_quantity: value.stock_quantity,
                };

                ORDER_ADD_TO_CART.cart_items[inventoryId] = { ...accepted, changed: { quantity: 1, price: accepted.final_price } };
                ORDER_ADD_TO_CART.elements.cart_item.val('');
                ORDER_ADD_TO_CART.elements.cart_item.selectpicker('refresh');

                ORDER_ADD_TO_CART.renderCartItems(ORDER_ADD_TO_CART.cart_items);
                ORDER_ADD_TO_CART.recalculateTotalOfCart(ORDER_ADD_TO_CART.cart_items);
                ORDER_ADD_TO_CART.onChangeQuantity();
            });
        },
        onChangeQuantity: () => {
            $('[data-value="cart_quantity"]').on('change', function() {
                const value = $(this).val();
                const price = $(this).attr('data-price');
                const inventoryId = $(this).attr('data-inventory-id');

                console.log({ inventoryId });

                const finalPrice = parseFloat(price) * value;

                ORDER_ADD_TO_CART.cart_items[inventoryId] = {
                    ...ORDER_ADD_TO_CART.cart_items[inventoryId],
                    changed: { quantity: value, price: finalPrice }
                };

                ORDER_ADD_TO_CART.renderCartItems(ORDER_ADD_TO_CART.cart_items);
                ORDER_ADD_TO_CART.recalculateTotalOfCart(ORDER_ADD_TO_CART.cart_items);
                ORDER_ADD_TO_CART.onChangeQuantity();
            });
        },
        renderCartItems: (items) => {
            const itemsDom = Object.values(items).map(function(item, index) {
                return `
                    <tr>
                        <th>${item.id}</th>
                        <th>
                            <img src="${item.image}" width="50" alt="">
                        </th>
                        <th>${item.title}</th>
                        <th>
                            <input type="text" value="${fscommon.formatPrice(item.final_price)}" class="form-control" disabled>
                        </th>
                        <th>
                            <input type="hidden" name="cart_items[${index}][inventory_id]" value="${item.id}" />
                            <input type="number" name="cart_items[${index}][quantity]" data-value="cart_quantity" data-price="${item.final_price}" data-inventory-id="${item.id}" step="1" value="${ item.changed.quantity }" min="1" max="${item.stock_quantity}" class="form-control">
                        </th>
                        <th>
                            <input type="text" value="${fscommon.formatPrice(item.changed.price)}" class="form-control" disabled>
                        </th>
                        <th>
                            <button type="button" class="btn btn-danger btn-icon">
                                <i class="flaticon-delete"></i>
                            </button>
                        </th>
                    </tr>
                `;
            });

            ORDER_ADD_TO_CART.elements.table.find('tbody').html(itemsDom);
        },
        recalculateTotalOfCart: (items) => {
            const totalPrice = Object.values(items).reduce(function(prev, curr) {
                return prev += parseFloat(curr.changed.price);
            }, 0);

            const totalQuantity = Object.values(items).reduce(function(prev, curr) {
                return prev += parseFloat(curr.changed.quantity);
            }, 0);;

            ORDER_ADD_TO_CART.elements.table.find('tfoot [data-name="total_quantity"]').val(totalQuantity);
            ORDER_ADD_TO_CART.elements.table.find('tfoot [data-name="total_price"]').val(fscommon.formatPrice(totalPrice));
        },
        renderShippingOptions: () => {
            const { province_code, district_code, ward_code } = ADDRESS_MANAGEMENT.address_info;

            if (!province_code || !district_code || !ward_code ) {
                return;
            }

            const route = "{{ route('bo.api.shipping-options.available') }}";

            $.ajax({
                url: route,
                method: 'GET',
                data: {
                    status: 1,
                    province_code: province_code,
                    paginate: false
                },
                success: (shippingOptions) => {
                    const element = $('[name="shipping_option_id"]');

                    element.html('');
                    element.prop('disabled', !(shippingOptions?.length || 0));
                    element.selectpicker('refresh');
                    element.trigger('changed.bs.select');

                    const isSelectedFirst = shippingOptions?.length == 1;

                    const options = shippingOptions.map(function(option, index) {
                        return $('<option>')
                            .attr('data-option-name', option.name)
                            .val(option.id)
                            .text(option.name)
                    });

                    element.html(options);
                    element.selectpicker('refresh');
                },
                error: (err) => {
                    console.log({ err });
                },
            });
        },  
        onSubmit: () => {
            $('#form_create_order').on('submit', function(e) {
                e.preventDefault();

                const route = "{{ route('bo.web.orders.store') }}";

                $.ajax({
                    url: route,
                    method: 'POST',
                    data: $(this).serialize(),
                    success: (response) => {
                        window.location.href = "{{ route('bo.web.orders.edit', ['id' => ':id']) }}".replace(':id', response.id);
                        $('#form_create_order').find('[type="submit"]').prop('disabled', false);
                    },
                    error: () => {
                        $('#form_create_order').find('[type="submit"]').prop('disabled', false);
                    },
                });
            });
        },
    };

    const ADDRESS_MANAGEMENT = {
        address_info: {
            province_code: null,
            district_code: null,
            ward_code: null,
        },
        init: () => {
            ADDRESS_MANAGEMENT.onChangeProvince();
            ADDRESS_MANAGEMENT.onChangeDistrict();
            ADDRESS_MANAGEMENT.onChangeWard();
        },
        onChangeProvince: () => {
            $('[name="province_code"]').on('change', function() {
                const code = $(this).val();

                ADDRESS_MANAGEMENT.address_info.province_code = code;
                ADDRESS_MANAGEMENT.renderDistrictsByProvince(code);
                ORDER_ADD_TO_CART.renderShippingOptions();
            });
        },
        onChangeDistrict: () => {
            $('[name="district_code"]').on('change', function() {
                const code = $(this).val();

                ADDRESS_MANAGEMENT.address_info.district_code = code;
                ADDRESS_MANAGEMENT.renderWardsByDistrict(code);
                ORDER_ADD_TO_CART.renderShippingOptions();
            });
        },
        onChangeWard: () => {
            $('[name="ward_code"]').on('change', function() {
                const code = $(this).val();

                ADDRESS_MANAGEMENT.address_info.ward_code = code;
                ORDER_ADD_TO_CART.renderShippingOptions();
            });
        },
        renderDistrictsByProvince: (province) => {
            try {
                const element = $('[name="district_code"]');
                const districts = JSON.parse(element.attr('data-districts') || '[]');
                const originalValues = JSON.parse(element.attr('data-original-value') || '[]');

                const filteredDistricts = districts.filter(function(district) {
                    return province == district.province_code;
                });

                element.html('');
                element.prop('disabled', !(filteredDistricts?.length || 0));
                element.selectpicker('refresh');
                element.trigger('changed.bs.select');

                if (!filteredDistricts?.length) {
                    return;
                }

                const options = filteredDistricts
                    .map(function(district) {
                        return $('<option>')
                            .attr('data-tokens', `${district.code}`)
                            .attr('data-district-code', district.code)
                            .attr('data-district-name', district.full_name)
                            .val(district.code)
                            .text(`${district.full_name}`)
                    });

                element.html(options);
                element.selectpicker('refresh');
                element.selectpicker('val', originalValues);
            } catch (err) {
                // 
            }
        },
        renderWardsByDistrict: (district) => {
            try {
                const element = $('[name="ward_code"]');
                const wards = JSON.parse(element.attr('data-wards') || '[]');
                const originalValues = JSON.parse(element.attr('data-original-value') || '[]');

                const filteredWards = wards.filter(function(ward) {
                    return district == ward.district_code;
                });

                element.html('');
                element.prop('disabled', !(filteredWards?.length || 0));
                element.selectpicker('refresh');
                element.trigger('changed.bs.select');

                if (!filteredWards?.length) {
                    return;
                }

                const options = filteredWards
                    .map(function(ward) {
                        return $('<option>')
                            .attr('data-tokens', `${ward.code}`)
                            .attr('data-ward-code', ward.code)
                            .attr('data-ward-name', ward.full_name)
                            .val(ward.code)
                            .text(`${ward.full_name}`)
                    });

                element.html(options);
                element.selectpicker('refresh');
                element.selectpicker('val', originalValues);
            } catch (err) {
                // 
            }
        },
    };

    ADDRESS_MANAGEMENT.init();
    ORDER_ADD_TO_CART.init();
</script>
