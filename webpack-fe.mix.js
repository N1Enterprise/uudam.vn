require('laravel-mix-merge-manifest');
require('laravel-mix-purgecss');

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
    .js('resources/src/frontend/js/home-deferload.js', 'public/frontend/bundle/js/home-deferload.min.js')
    .js('resources/src/frontend/js/checkout-index.js', 'public/frontend/bundle/js/checkout-index.min.js')
    .js('resources/src/frontend/js/profile-user-info.js', 'public/frontend/bundle/js/profile-user-info.min.js')
    .js('resources/src/frontend/js/profile-change-password.js', 'public/frontend/bundle/js/profile-change-password.min.js')
    .js('resources/src/frontend/js/authentication.js', 'public/frontend/bundle/js/authentication.min.js')
    .js('resources/src/frontend/js/component-search.js', 'public/frontend/bundle/js/component-search.min.js')
    .js('resources/src/frontend/js/cart-index.js', 'public/frontend/bundle/js/cart-index.min.js')

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
    .css('resources/src/frontend/css/latest-661.css', 'public/frontend/bundle/css/latest-661.min.css')
    .css('resources/src/frontend/css/latest-669.css', 'public/frontend/bundle/css/latest-669.min.css')
    .css('resources/src/frontend/css/component-cart.css', 'public/frontend/bundle/css/component-cart.min.css')
    .css('resources/src/frontend/css/component-cart-drawer.css', 'public/frontend/bundle/css/component-cart-drawer.min.css')
    .css('resources/src/frontend/css/component-cart-items.css', 'public/frontend/bundle/css/component-cart-items.min.css')


    .options({
        processCssUrls: false,
        postCss: [require('autoprefixer')],
        autoprefixer: { remove: false },
        clearConsole: true, // in watch mode, clears console after every build
      })
    .purgeCss({
        safelist: {
            standard: [/-active$/, /-enter$/, /-leave-to$/, /show$/, /^el-/],
        },
    })
    .mergeManifest();
