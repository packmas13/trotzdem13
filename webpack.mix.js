const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js")
    .vue()
    .postCss("resources/css/style.css", "public/css", [
        require("postcss-import"),
        require("tailwindcss"),
        require("autoprefixer"),
    ])
    .webpackConfig(require("./webpack.config"));

if (mix.inProduction()) {
    mix.version().then(() => {
        const convertToFileHash = require("laravel-mix-make-file-hash");
        convertToFileHash({
            publicPath: "public",
            manifestFilePath: "public/mix-manifest.json",
        });
    });
} else {
    // eslint-disable-next-line no-undef
    if (process.argv.includes("--hot")) {
        // hot module reload
        mix.webpackConfig({
            devServer: {
                open: true,
                host: "0.0.0.0", // host machine ip
                port: 8080,
                proxy: {
                    "/": "http://localhost:8000",
                },
            },
        });
    } else {
        mix.browserSync({ proxy: "localhost:8000", notify: false });
    }
}
