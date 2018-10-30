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

// mix.js('resources/js/app.js', 'public/js')
//    .sass('resources/sass/app.scss', 'public/css');

mix.styles([
    'resources/plantilla/css/coreui-icons.css',
    'resources/plantilla/css/flag-icon.css',
    'resources/plantilla/css/font-awesome.css',
    'resources/plantilla/css/pace.css',
    'resources/plantilla/css/simple-line-icons.css',
    'resources/plantilla/css/style.css'
], 'public/css/plantilla.css')

mix.scripts([
    'resources/plantilla/js/bootstrap.bundle.js',
    'resources/plantilla/js/bootstrap.js',
    'resources/plantilla/js/charts.js',
    'resources/plantilla/js/colors.js',
    'resources/plantilla/js/core.js',
    'resources/plantilla/js/coreui.js',
    'resources/plantilla/js/coreui-utilities.js',
    'resources/plantilla/js/jquery.js',
    'resources/plantilla/js/jquery.slim.js',
    'resources/plantilla/js/main.js',
    'resources/plantilla/js/pace.js',
    'resources/plantilla/js/perfect-scrollbar.common.js',
    'resources/plantilla/js/perfect-scrollbar.esm.js',
    'resources/plantilla/js/perfect-scrollbar.js',
    'resources/plantilla/js/popovers.js',
    'resources/plantilla/js/popper.js',
    'resources/plantilla/js/popper-utils.js',
    'resources/plantilla/js/tooltips.js',
    'resources/plantilla/js/widgets.js',
    'resources/plantilla/js/sweetalert2.all.js'
], 'public/js/plantilla.js')
.js('resources/js/app.js','public/js/app.js');