const path = require('path');
const webpack = require('webpack');

module.exports = {
    devtool: 'source-map',
    entry: {
        app: './app/assets/js/app.js'
    },
    output: {
        path: path.resolve(__dirname, '.tmp/js'),
        filename: '[name].js'
    },
    module: {
        rules: [{
            test: /\.js$/,
            exclude: /node_modules/,
            use: [{
                loader: 'babel-loader',
                options: {
                    presets: ["env"]
                }
            }]
        }]
    },
    plugins: [
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery'
        })
    ]
}