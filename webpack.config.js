var Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .setPublicPath('/homestuck-craft/public/build')
    .setManifestKeyPrefix('build')
    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()
    // show OS notifications when builds finish/fail
    // .enableBuildNotifications()
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
    .addEntry('js/app', './assets/js/app.js')
    .addStyleEntry('css/app', './assets/css/app.scss')

    // uncomment if you use Sass/SCSS files
    .enableSassLoader(function (sassOptions) {
        // https://github.com/sass/node-sass#options
        // options.includePaths = [...]
    })

    // uncomment for legacy applications that require $/jQuery as a global variable
    .autoProvidejQuery()
    .autoProvideVariables({
        $: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery'
    })

    .enableSourceMaps(!Encore.isProduction())
;

module.exports = Encore.getWebpackConfig();