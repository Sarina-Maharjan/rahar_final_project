const mix = require('laravel-mix');

mix
  .js('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .minify('public/js/app.js')
  .minify('public/css/app.css');
