const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const DependencyExtractionWebpackPlugin = require( '@wordpress/dependency-extraction-webpack-plugin' ); // block.assets.php

const mode = (process && process.argv && process.argv[process.argv.indexOf('--mode') + 1]) ? process.argv[process.argv.indexOf('--mode') + 1] : 'UNKNOWN'
const production = mode === 'production' ? true : false;

console.log('\033[0mMODE \033[0;32m' + mode + '\033[0m\n');

const config = {
    watch: !production,
    watchOptions: {
        aggregateTimeout: 300,
        poll: 1000,
        ignored: [path.resolve(__dirname, 'node_modules/'), path.resolve(__dirname, 'vendor/')],
    },
    resolve: {
        extensions: ['.js', '.jsx', '.scss']
    },
    module: {
        rules: [{
            test: /\.jsx$/,
            use: {
                loader: "babel-loader",
                options: {
                    presets: ['@babel/preset-env', '@babel/preset-react'],
                    plugins: [
                        ["@babel/plugin-transform-runtime"],
                        [
                            "@babel/plugin-transform-react-jsx",
                        ],
                    ]
                }
            }
        }, {
            test: /\.s[ac]ss$/i,
            use: [
                MiniCssExtractPlugin.loader,
                "css-loader",
                {
                    loader: "sass-loader",
                },
            ],
        }]
    },
    externals: {
        'react': 'React',
        'react-dom': 'ReactDOM'
    },
    devtool: false
}

let configAdmin = Object.assign({}, config, {
    name: "configAdmin",
    entry: [path.resolve(__dirname, '.build/assets/scripts/admin/index.js'), path.resolve(__dirname, '.build/assets/styles/admin.scss')],
    output: {
        filename: 'admin.js',
        path: path.resolve(__dirname, 'assets/scripts'),
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "../styles/admin.css"
        })
    ],
});

let configUi = Object.assign({}, config, {
    name: "configUi",
    entry: [path.resolve(__dirname, '.build/assets/scripts/ui/index.js'), path.resolve(__dirname, '.build/assets/styles/ui.scss')],
    output: {
        filename: 'ui.js',
        path: path.resolve(__dirname, 'assets/scripts'),
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "../styles/ui.css"
        })
    ],
});

let configGutenberg = Object.assign({}, config, {
    name: "configGutenberg",
    entry: path.resolve(__dirname, '.build/assets/gutenberg/blocks.js'),
    output: {
        filename: 'blocks.js',
        path: path.resolve(__dirname, 'assets/gutenberg'),
    },
    plugins: [
        new DependencyExtractionWebpackPlugin()
    ],
});


// Return Array of Configurations
module.exports = [configAdmin, configUi, configGutenberg];
