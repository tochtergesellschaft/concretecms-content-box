let mix = require('laravel-mix');

mix.webpackConfig({
    externals: {
        bootstrap: true
    }
}).sass('scss/block/view.scss', 'css/block/view.css');
