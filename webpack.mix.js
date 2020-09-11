const mix = require('laravel-mix');

mix.js('resources/js/backend/app.js', 'public/_backend/js')
   .sass('resources/sass/backend/app.scss', 'public/_backend/css');
