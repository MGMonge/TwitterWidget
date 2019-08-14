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

const mix = require('laravel-mix')

mix.setPublicPath('./')
    .js('resources/js/app.js', 'assets')
    .less('resources/less/app.less', 'assets')

if (mix.inProduction()) {
    mix.version()
}