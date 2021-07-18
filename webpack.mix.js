const mix = require("laravel-mix");

// const VuetifyLoaderPlugin = require("vuetify-loader/lib/plugin");
const CaseSensitivePathsPlugin = require("case-sensitive-paths-webpack-plugin");

var webpackConfig = {
    plugins: [new CaseSensitivePathsPlugin()]
};

mix.webpackConfig(webpackConfig);

// mix.listen("configReady", webpackConfig => {
//     // Exclude vuetify folder from default sass/scss rules
//     const sassConfig = webpackConfig.module.rules.find(
//         rule => String(rule.test) === String(/\.sass$/)
//     );

//     const scssConfig = webpackConfig.module.rules.find(
//         rule => String(rule.test) === String(/\.scss$/)
//     );

//     sassConfig.exclude.push(path.resolve(__dirname, "node_modules/vuetify"));
//     scssConfig.exclude.push(path.resolve(__dirname, "node_modules/vuetify"));
// });

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
    .sass("resources/sass/app.scss", "public/css");
