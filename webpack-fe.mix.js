const mix = require('laravel-mix');
let productionSourceMaps = true;
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
    .js('resources/src/frontend/js/home/index.js', 'public/frontend/bundle/js/home/index.min.js')
    .js('resources/src/frontend/js/checkout/index.js', 'public/frontend/bundle/js/checkout/index.min.js')
    .js('resources/src/frontend/js/profile/user-info.js', 'public/frontend/bundle/js/profile/user-info.min.js')
    .js('resources/src/frontend/js/profile/change-password.js', 'public/frontend/bundle/js/profile/change-password.min.js')
    .js('resources/src/frontend/js/authentication/index.js', 'public/frontend/bundle/js/authentication/index.min.js')
    .js('resources/src/frontend/js/helpers/find-by-tags.js', 'public/frontend/bundle/js/helpers/find-by-tags.min.js')
    .js('resources/src/frontend/js/search/index.js', 'public/frontend/bundle/js/search/index.min.js')
    .sourceMaps(productionSourceMaps, 'source-map');
