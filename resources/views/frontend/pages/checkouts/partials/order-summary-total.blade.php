<div class="order-summary-section order-summary-section-total-lines payment-lines" data-order-summary-section="payment-lines">
    <table class="total-line-table">
        <thead>
            <tr>
                <th scope="col">
                    <span class="visually-hidden">Mô tả</span>
                </th>
                <th scope="col">
                    <span class="visually-hidden">Giá</span>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="total-line total-line-subtotal">
                <td class="total-line-name">Tạm tính</td>
                <td class="total-line-price">
                    <span class="order-summary-emphasis" data-checkout-subtotal-price-target="{{ $cart->total_price }}">{{ format_price($cart->total_price) }}</span>
                </td>
            </tr>
            <tr class="total-line total-line-shipping">
                <td class="total-line-name">Phí vận chuyển</td>
                <td class="total-line-price">
                    <span class="order-summary-emphasis" data-checkout-total-shipping-target=""> — </span>
                </td>
            </tr>
        </tbody>
        <tfoot class="total-line-table-footer">
            <tr class="total-line">
                <td class="total-line-name payment-due-label">
                    <span class="payment-due-label-total">Tổng cộng</span>
                </td>
                <td class="total-line-name payment-due">
                    <span class="payment-due-currency">VND</span>
                    <span class="payment-due-price" data-checkout-payment-due-target=""> - </span>
                    <span class="checkout_version" display:none="" data_checkout_version="43"></span>
                </td>
            </tr>
        </tfoot>
    </table>
</div>