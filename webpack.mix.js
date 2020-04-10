const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

 mix.options({
 	   processCssUrls: false
    })
    // .sourceMaps(true, 'source-map')
    .js('admincp_core/assets/js/auth.js', 'public/admincp_assets/js')
    .sass('admincp_core/assets/sass/auth.scss', 'public/admincp_assets/css');

 mix.options({
 	   processCssUrls: false
    })
    // .sourceMaps(true, 'source-map')
    .js('admincp_core/assets/js/cms.js', 'public/admincp_assets/js')
    .sass('admincp_core/assets/sass/cms.scss', 'public/admincp_assets/css');

 /*
 * Copy images folder from resources to public
 */

 mix.copyDirectory([
     'admincp_core/assets/images',
 ], 'public/admincp_assets/images');

 /*
 * Copy App Assets from /dist to public/tpl/dist
 */

 // mix.copyDirectory([
 //     'resources/views/dist/assets',
 // ], 'public');
