const mix = require("laravel-mix");
const path = require("path");

const VuetifyLoaderPlugin = require("vuetify-loader/lib/plugin");
const CaseSensitivePathsPlugin = require("case-sensitive-paths-webpack-plugin");

var webpackConfig = {
    plugins: [new VuetifyLoaderPlugin(), new CaseSensitivePathsPlugin()]
};

mix.webpackConfig(webpackConfig);

mix.alias({
    "@": path.join(__dirname, "resources/js"),
    "~": path.join(__dirname, "resources/sass")
});

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
mix.js("resources/js/app.js", "js")
    .js("resources/js/error.js", "js")
    .vue()
    .css("resources/css/app.css", "css")
    .css("resources/css/error.css", "css")
    .sass("resources/sass/app.scss", "css")
    .setPublicPath("public");
