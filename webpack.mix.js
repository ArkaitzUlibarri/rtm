const { mix } = require('laravel-mix');

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

mix.js('resources/assets/js/views/main.js', 'public/js')
   .js('resources/assets/js/views/alarms.js', 'public/js')
   .js('resources/assets/js/views/configuration.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .extract([
		'jquery',
		'vue',
		'vue-select',
		'axios',
		'moment',
		'eonasdan-bootstrap-datetimepicker'
	]);