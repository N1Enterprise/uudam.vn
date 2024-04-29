require('laravel-mix-merge-manifest');
// require('laravel-mix-purgecss');

const mix = require('laravel-mix');
const path = require('path');

/*
|--------------------------------------------------------------------------
| Mix Asset Management
|--------------------------------------------------------------------------
|
| Mix provides a clean, fluent API for defining some Webpack build steps
| for your Laravel application. By default, we are compiling the Sass
| file for your application, as well as bundling up your JS files.
|
*/
// Enable BrowseSync for run hot only
if (process.argv.includes('--hot')) {
    mix.browserSync({
        proxy: 'localhost:8080',
        open: false,
    });
}

// If Laravel Mix is inside folder /webpack/, reconfigure public path
if (path.resolve(__dirname, '..').indexOf('webpack-client') >= 0) {
    mix.setPublicPath('../');
}

mix.webpackConfig({
    output: {
        chunkFilename: 'assets/js/[name].min.js',
        publicPath: '/',
    },
});

mix
    .js('resources/src/frontend/js/app.js', 'public/frontend/bundle/js/app.min.js')
    .js('resources/src/frontend/js/home-deferload.js', 'public/frontend/bundle/js/home-deferload.min.js')
    .js('resources/src/frontend/js/home-index.js', 'public/frontend/bundle/js/home-index.min.js')
    .js('resources/src/frontend/js/checkout-index.js', 'public/frontend/bundle/js/checkout-index.min.js')
    .js('resources/src/frontend/js/profile-user-info.js', 'public/frontend/bundle/js/profile-user-info.min.js')
    .js('resources/src/frontend/js/profile-change-password.js', 'public/frontend/bundle/js/profile-change-password.min.js')
    .js('resources/src/frontend/js/authentication.js', 'public/frontend/bundle/js/authentication.min.js')
    .js('resources/src/frontend/js/component-search.js', 'public/frontend/bundle/js/component-search.min.js')
    .js('resources/src/frontend/js/flash-sale.js', 'public/frontend/bundle/js/flash-sale.min.js')
    .js('resources/src/frontend/js/cart-index.js', 'public/frontend/bundle/js/cart-index.min.js')
    .js('resources/src/frontend/js/menu-drawer.js', 'public/frontend/bundle/js/menu-drawer.min.js')
    .js('resources/src/frontend/js/predictive-search.js', 'public/frontend/bundle/js/predictive-search.min.js')
    .js('resources/src/frontend/js/user-order-cart.js', 'public/frontend/bundle/js/user-order-cart.min.js')
    .js('resources/src/frontend/js/product-index.js', 'public/frontend/bundle/js/product-index.min.js')
    .js('resources/src/frontend/js/collection-index.js', 'public/frontend/bundle/js/collection-index.min.js')
    .js('resources/src/frontend/js/address.js', 'public/frontend/bundle/js/address.min.js')

    .css('resources/src/frontend/css/reset.css', 'public/frontend/bundle/css/reset.min.css')
    .css('resources/src/frontend/css/base.css', 'public/frontend/bundle/css/base.min.css')
    .css('resources/src/frontend/css/buddha-megamenu2.css', 'public/frontend/bundle/css/buddha-megamenu2.min.css')
    .css('resources/src/frontend/css/component-mega-menu.css', 'public/frontend/bundle/css/component-mega-menu.min.css')
    .css('resources/src/frontend/css/section-footer.css', 'public/frontend/bundle/css/section-footer.min.css')
    .css('resources/src/frontend/css/component-menu-drawer.css', 'public/frontend/bundle/css/component-menu-drawer.min.css')
    .css('resources/src/frontend/css/component-list-social.css', 'public/frontend/bundle/css/component-list-social.min.css')
    .css('resources/src/frontend/css/component-search.css', 'public/frontend/bundle/css/component-search.min.css')
    .css('resources/src/frontend/css/component-predictive-search.css', 'public/frontend/bundle/css/component-predictive-search.min.css')
    .css('resources/src/frontend/css/quick-add.css', 'public/frontend/bundle/css/quick-add.min.css')
    .css('resources/src/frontend/css/main.css', 'public/frontend/bundle/css/main.min.css')
    .css('resources/src/frontend/css/profile-index.css', 'public/frontend/bundle/css/profile-index.min.css')
    .css('resources/src/frontend/css/latest-199.css', 'public/frontend/bundle/css/latest-199.min.css')
    .css('resources/src/frontend/css/component-cart.css', 'public/frontend/bundle/css/component-cart.min.css')
    .css('resources/src/frontend/css/component-cart-drawer.css', 'public/frontend/bundle/css/component-cart-drawer.min.css')
    .css('resources/src/frontend/css/component-cart-items.css', 'public/frontend/bundle/css/component-cart-items.min.css')
    .css('resources/src/frontend/css/blog-index.css', 'public/frontend/bundle/css/blog-index.min.css')
    .css('resources/src/frontend/css/component-article-card.css', 'public/frontend/bundle/css/component-article-card.min.css')
    .css('resources/src/frontend/css/component-card.css', 'public/frontend/bundle/css/component-card.min.css')
    .css('resources/src/frontend/css/component-pagination.css', 'public/frontend/bundle/css/component-pagination.min.css')
    .css('resources/src/frontend/css/section-main-blog.css', 'public/frontend/bundle/css/section-main-blog.min.css')
    .css('resources/src/frontend/css/component-collection-hero.css', 'public/frontend/bundle/css/component-collection-hero.min.css')
    .css('resources/src/frontend/css/template-collection.css', 'public/frontend/bundle/css/template-collection.min.css')
    .css('resources/src/frontend/css/component-price.css', 'public/frontend/bundle/css/component-price.min.css')
    .css('resources/src/frontend/css/component-rte.css', 'public/frontend/bundle/css/component-rte.min.css')
    .css('resources/src/frontend/css/component-facets.css', 'public/frontend/bundle/css/component-facets.min.css')
    .css('resources/src/frontend/css/component-loading-overlay.css', 'public/frontend/bundle/css/component-loading-overlay.min.css')
    .css('resources/src/frontend/css/recommendation.css', 'public/frontend/bundle/css/recommendation.min.css')
    .css('resources/src/frontend/css/maintenance-index.css', 'public/frontend/bundle/css/maintenance-index.min.css')
    .css('resources/src/frontend/css/blog-news-index.css', 'public/frontend/bundle/css/blog-news-index.min.css')
    .css('resources/src/frontend/css/product-index.css', 'public/frontend/bundle/css/product-index.min.css')
    .css('resources/src/frontend/css/component-slider-2.css', 'public/frontend/bundle/css/component-slider-2.min.css')
    .css('resources/src/frontend/css/spr.css', 'public/frontend/bundle/css/spr.min.css')
    .css('resources/src/frontend/css/product-attribute.css', 'public/frontend/bundle/css/product-attribute.min.css')
    .css('resources/src/frontend/css/component-slideshow.css', 'public/frontend/bundle/css/component-slideshow.min.css')
    .css('resources/src/frontend/css/home-index.css', 'public/frontend/bundle/css/home-index.min.css')
    .css('resources/src/frontend/css/section-image-banner.css', 'public/frontend/bundle/css/section-image-banner.min.css')
    .css('resources/src/frontend/css/component-slider-1.css', 'public/frontend/bundle/css/component-slider-1.min.css')
    .css('resources/src/frontend/css/section-featured-blog.css', 'public/frontend/bundle/css/section-featured-blog.min.css')
    .css('resources/src/frontend/css/section-multicolumn.css', 'public/frontend/bundle/css/section-multicolumn.min.css')
    .css('resources/src/frontend/css/component-slider.css', 'public/frontend/bundle/css/component-slider.min.css')
    .css('resources/src/frontend/css/flashsale.css', 'public/frontend/bundle/css/flashsale.min.css')
    .css('resources/src/frontend/css/variable.css', 'public/frontend/bundle/css/variable.min.css')
    .css('resources/src/frontend/css/mobile-menu.css', 'public/frontend/bundle/css/mobile-menu.min.css')
    // .css('resources/src/frontend/css/master.css', 'public/frontend/bundle/css/master.min.css')

    // .css('resources/src/frontend/css/pages/blog.css', 'public/frontend/bundle/css/pages/blog.min.css')
    // .css('resources/src/frontend/css/pages/cart.css', 'public/frontend/bundle/css/pages/cart.min.css')
    // .css('resources/src/frontend/css/pages/checkout.css', 'public/frontend/bundle/css/pages/checkout.min.css')
    // .css('resources/src/frontend/css/pages/collection.css', 'public/frontend/bundle/css/pages/collection.min.css')
    // .css('resources/src/frontend/css/pages/home.css', 'public/frontend/bundle/css/pages/home.min.css')
    // .css('resources/src/frontend/css/pages/page.css', 'public/frontend/bundle/css/pages/page.min.css')
    // .css('resources/src/frontend/css/pages/product.css', 'public/frontend/bundle/css/pages/product.min.css')
    // .css('resources/src/frontend/css/pages/profile.css', 'public/frontend/bundle/css/pages/profile.min.css')
    // .css('resources/src/frontend/css/pages/search.css', 'public/frontend/bundle/css/pages/search.min.css')


    .options({
        processCssUrls: false,
        postCss: [require('autoprefixer')],
        autoprefixer: { remove: false },
        clearConsole: true, // in watch mode, clears console after every build
      })
    // .purgeCss({
    //     safelist: {
    //         standard: [/-active$/, /-enter$/, /-leave-to$/, /show$/, /^el-/],
    //     },
    // })
    .mergeManifest();
