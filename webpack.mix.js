const mix = require('laravel-mix');

mix.webpackConfig({
    resolve: {
        alias: {
            fancybox: '@fancyapps/fancybox',
            'owl.carousel': 'owl.carousel',
            sweetalert2: 'sweetalert2',
            ziggy: path.resolve('vendor/tightenco/ziggy/dist')
        }
    }
});

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/show-game.js', 'public/js')
    .js('resources/js/comments.js', 'public/js')
    .js('resources/js/nav-bar.js', 'public/js')
    .js('resources/js/menu-user.js', 'public/js')
    .js('resources/js/ziggy.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .autoload({
        jquery: ['$', 'jQuery', 'window.jQuery']
    })
    .sourceMaps();
