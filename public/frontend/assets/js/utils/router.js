var boHost = utils_helper.boDataShared().bo_host;
var feHost = utils_helper.boDataShared().fe_host;

const HOME_ROUTES = {
    web_home: feHost
};

const AUTHENTICATION_ROUTES = {
    home: boHost,
    api_oauth_signin: boHost + '/fe/api/user/oauth/signin',
};

const HOME_PAGE_DISPLAY_ITEM_ROUTES = {
    api_display_item_inventory: boHost + '/fe/api/user/display-item/:id/inventories',
    api_display_item_collection: boHost + '/fe/api/user/display-item/:id/collections',
    api_display_item_post: boHost + '/fe/api/user/display-item/:id/posts',
    api_display_item_blog: boHost + '/fe/api/user/display-item/:id/blogs',
    api_display_item_banner_100: boHost + '/fe/api/user/display-item/:id/banners-100',
    api_display_item_banner_50: boHost + '/fe/api/user/display-item/:id/banners-50',
};

const CATALOG_ROUTES = {
    web_product_detail: boHost + '/products/:slug',
    web_collection_detail: boHost + '/collections/:slug',
    web_post_detail: boHost + '/posts/:slug',
    api_search_inventories: boHost + '/fe/api/user/search/inventories'
};

const CART_ROUTES = {
  api_update_quantity: boHost + '/fe/api/user/carts/:id/item-update-quantity',
  api_delete: boHost + '/fe/api/user/carts/:id/delete',
  api_cart_info: boHost + '/fe/api/user/carts-info',
  api_store_cart: boHost + '/fe/api/user/add-to-cart',
};

const SEARCH_ROUTES = {
    api_suggest: boHost + '/fe/api/user/search/suggest'
};

const POST_ROUTES = {
    web_detail: boHost + '/posts/:slug',
};

const PRODUCT_ROUTES = {
    web_detail: boHost + '/products/:slug',
};

const COLLECTION_ROUTES = {
    web_detail: boHost + '/collections/:slug',
    api_linked_inventories: boHost + '/fe/api/user/collections/:id/linked-inventories',
};

const BLOG_ROUTES = {
    web_detail: boHost + '/blogs/:slug',
};

const VIDEO_ROUTES = {
    web_detail: boHost + '/videos/:slug',
};

const LOCALIZATION_ROUTES = {
    api_provinces: boHost + '/fe/api/localization/provinces',
    api_districts_by_province: boHost + '/fe/api/localization/:province/districts',
    api_wards_by_district: boHost + '/fe/api/localization/:district/wards',
    api_address_detail: boHost + '/fe/api/user/localization/address/:code',
};

const CHECKOUT_ROUTES = {
    api_user_checkout_provider_shipping_free: boHost + '/fe/api/user/checkout/:cartUuid/shipping-fee',
    web_user_checkout_with_payment_success: boHost + '/checkout/:cart_uuid/status/?transaction_id=:transaction_id'
};
