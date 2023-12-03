/** @class App\Enum\OrderStatusEnum */
const ORDER_STATUS_ENUM = {
    WAITING_FOR_PAYMENT: 1,
    PAYMENT_ERROR: 2,
    PROCESSING: 3,
    DELIVERY: 4,
    COMPLETED: 5,
    CANCELED: 6,
    REFUNDED: 7,
}

export { ORDER_STATUS_ENUM };
