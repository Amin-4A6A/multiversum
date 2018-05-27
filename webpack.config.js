// webpack.config.js
require("dotenv").config();
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

module.exports = {
    module: {
        rules: [
            {
                test: /\.scss$/,
                use: [
                    "style-loader", // creates style nodes from JS strings
                    "css-loader", // translates CSS into CommonJS
                    "sass-loader" // compiles Sass to CSS
                ]
            },
            {
                test: /\.js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader',
                }
            },
            {
                test: /\.(eot|svg|ttf|woff|woff2)$/,
                use: {
                    loader: 'file-loader',
                    options: {
                        name: 'webfonts/[name].[ext]',
                        context: ''
                    }
                }
            }
        ]
    },
    plugins: [
        new BrowserSyncPlugin({
            // browse to http://localhost:3000/ during development,
            // ./public directory is being served
            host: process.env.host,
            port: process.env.port,
            proxy: process.env.proxy,
            files: [
                "public/bundle/*.*",
                "view/**/*.twig"
            ]
        })
    ]
};