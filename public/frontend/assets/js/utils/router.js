var boHost = utils_helper.boDataShared().bo_host;

const AUTHENTICATION_ROUTES = {
    home: boHost,
    api_oauth_signin: boHost + '/fe/api/user/oauth/signin',
};

const HOME_PAGE_DISPLAY_ITEM_ROUTES = {
    api_display_item_inventory: boHost + '/fe/api/user/display-item/:id/inventory',
    api_display_item_collection: boHost + '/fe/api/user/display-item/:id/collection',
};

const CATALOG_ROUTES = {
    web_product_detail: boHost + '/products/:slug',
    web_collection_detail: boHost + '/collections/:slug',
};