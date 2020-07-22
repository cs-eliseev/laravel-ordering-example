const mix = require('laravel-mix');

mix.sass('resources/sass/app.scss', 'public/css')
    .js('resources/js/app.js', 'public/js')
    .copy([
        'node_modules/jquery/dist/jquery.min.js',
        'node_modules/bootstrap/dist/js/bootstrap.min.js',
        'node_modules/v-select2-component/dist/Select2.min.js',
        'node_modules/vue-bootstrap-datetimepicker/dist/vue-bootstrap-datetimepicker.min.js'
    ], 'public/js/')
    .extract(['vue', 'axios', 'lodash'], 'public/js/vendor.js');
