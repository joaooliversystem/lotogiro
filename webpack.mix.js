const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/views/admin/layouts/assets/js/AdminLTE.js', 'public/admin/layouts/js/master.js')
    .sass('resources/views/admin/layouts/assets/scss/AdminLTE.scss', 'public/admin/layouts/css/master.css')
    .sass('resources/views/admin/layouts/assets/scss/AdminLTE-pages.scss', 'public/admin/layouts/css/login.css');

