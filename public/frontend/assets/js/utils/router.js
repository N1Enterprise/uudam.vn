var boHost = utils_helper.boDataShared().bo_host;

const AUTHENTICATION_ROUTES = {
    home: boHost,
    api_oauth_signin: boHost + '/fe/api/user/oauth/signin',
};

const HOME_PAGE_DISPLAY_ITEM_ROUTES = {
    api_display_item_inventory: boHost + '/fe/api/user/display-item/:id/inventories',
    api_display_item_collection: boHost + '/fe/api/user/display-item/:id/collections',
    api_display_item_post: boHost + '/fe/api/user/display-item/:id/posts',
};

const CATALOG_ROUTES = {
    web_product_detail: boHost + '/products/:slug',
    web_collection_detail: boHost + '/collections/:slug',
    web_post_detail: boHost + '/posts/:slug',
    
    api_search_inventories: boHost + '/fe/api/user/search/inventories'
};