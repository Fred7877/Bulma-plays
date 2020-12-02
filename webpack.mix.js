const mix = require('laravel-mix');

mix.webpackConfig({
    resolve: {
        alias: {
            'fancybox': '@fancyapps/fancybox',
            'owl.carousel': 'owl.carousel',
            'sweetalert2': 'sweetalert2',
        }
    }
});

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/show-game.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .autoload({
        jquery: ['$', 'jQuery', 'window.jQuery']
    })
    .sourceMaps();
