let mix = require('laravel-mix');
require("@tinypixelco/laravel-mix-wp-blocks");
const path = require("path");

require('laravel-mix-tailwind');

mix.setResourceRoot('../');
mix.setPublicPath(path.resolve('./'));

mix.webpackConfig({
    watchOptions: {
        ignored: [
            path.posix.resolve(__dirname, './node_modules'),
            path.posix.resolve(__dirname, './assets/css'),
            path.posix.resolve(__dirname, './assets/js')
        ]
    },
    // stats: {
    //     children: true,
    // }
});

mix.js('resources/js/tsmlxtras-admin.js', 'assets/js')
    .js('resources/js/tsmlxtras-frontend.js', 'assets/js')
    .sass('resources/sass/main.scss', 'assets/css')
    .sass('resources/sass/tsmlxtras-admin.scss', 'assets/css')
    .tailwind();

mix.block("resources/blocks/meetings-block/index.js", "includes/blocks/meetings-block/index.js");

if (mix.inProduction()) {
    mix.version();
} else {
    Mix.manifest.refresh = _ => void 0
}