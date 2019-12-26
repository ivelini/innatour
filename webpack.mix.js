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

mix.copy('resources/adminTheme/global_assets/css', 'public/global_assets/css');
mix.copy('resources/adminTheme/layout_1/LTR/default/seed/assets', 'public/assets');
