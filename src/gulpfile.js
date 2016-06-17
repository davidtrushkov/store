var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass([
        'app.scss'
    ], 'public/sass/app.scss')

    .styles([
        'mdb.css'
    ], 'public/css/mdb.css')

    .styles([
        'bootstrap.min.css'
    ], 'public/css/bootstrap.min.css')

    .styles ([
        'sweetalert.css'
    ], 'public/css/sweetalert.css')

    .styles ([
        'lity.css'
    ], 'public/css/lity.css')

    .styles ([
        'froala_editor.min.css'
    ], 'public/css/froala_editor.min.css')

    .styles ([
        'froala_style.min.css'
    ], 'public/css/froala_style.css')

    .styles ([
        'jquery.typeahead.min.css'
    ], 'public/css/typeahead.css')
    
    .styles ([
            'main.css'
        ], 'public/css/main.css');

});

elixir(function(mix) {
    mix.less([
        'app.less'
    ], 'public/less/app.less')

    .less([
        'admin.less'
    ], 'public/less/admin.less');
});


elixir(function(mix) {
    mix.scripts([
        'app.js'
    ], 'public/js/app.js')

    .scripts([
        'libs/jquery.js'
    ], 'public/js/libs/jquery.js')

    .scripts([
        'libs/bootstrap.min.js'
    ], 'public/js/libs/bootstrap.min.js')

    .scripts([
        'libs/mdb.js'
    ], 'public/js/libs/mdb.js')

    .scripts([
        'libs/sweetalert.min.js'
    ], 'public/js/libs/sweetalert.js')

    .scripts([
        'libs/dropzone.js'
    ], 'public/js/libs/dropzone.js')

    .scripts([
        'libs/lity.js'
    ], 'public/js/libs/lity.js')

    .scripts([
        'libs/typeahead.js'
    ], 'public/js/libs/typeahead.js')

    .scripts([
        'libs/moment.js'
    ], 'public/js/libs/moment.js')

    .scripts([
        'libs/Chart.js'
    ], 'public/js/libs/Chart.js');

});
