const Encore = require('@symfony/webpack-encore');

// Configure the runtime environment if not already configured
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

// Base configuration
Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/app.js')
    .enableStimulusBridge('./assets/controllers.json') // Activer Stimulus
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableSassLoader()
    .copyFiles({
        from: './assets/images',
        to: 'images/[path][name].[ext]',
    })
    .copyFiles({
        from: './assets/plugins',
        to: 'plugins/[path][name].[ext]',
    })
    // Configure Babel for polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.38';
    });

// Export the final Webpack configuration
module.exports = Encore.getWebpackConfig();
