// webpack.config.js
const Encore = require('@symfony/webpack-encore');
const tailwindcss = require('tailwindcss');

Encore
    // ... other Encore configurations
    .addEntry('app', './assets/app.js')
    .addEntry('appCss', './assets/styles/app.css')
    .setOutputPath('public/build/') // Set the output path according to your project structure
    .setPublicPath('/build')
    .enableSingleRuntimeChunk()
    .enableVueLoader()
    // CSS
    .enablePostCssLoader((options) => {
        options.postcssOptions = {
            plugins: [
                tailwindcss('./tailwind.config.js'),
                // Other PostCSS plugins if needed
            ],
        };
    });

module.exports = Encore.getWebpackConfig();
