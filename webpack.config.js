const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const path = require('path');
const dev = process.env.NODE_ENV === 'dev';

// change these variables to fit your project
const jsPath= './src/js';
const cssPath = './src/scss';
const outputPath = '';
const localDomain = 'http://bulle-d-art.test';
const entryPoints = {
  // 'app' is the output name, people commonly use 'bundle'
  // you can have more than 1 entry point
  'app': jsPath + '/app.js',
  'style' : cssPath + '/style.scss'
};

module.exports = {
    entry: ['./src/js/app.js', './src/scss/style.scss'],
    output: {
      path: path.resolve(__dirname, outputPath),
      filename: 'app.js',
    },
    plugins: [
      // extract css into dedicated file
      new MiniCssExtractPlugin({
        filename: 'style.css'
      }),
  
      // Uncomment this if you want to use CSS Live reload
      /*
      new BrowserSyncPlugin({
        proxy: localDomain,
        files: [ outputPath + '/*.css' ],
        injectCss: true,
      }, { reload: false, }),
      */
    ],
    module: {
      rules: [
        {
        test: /\.m?js$/,
        exclude: /node_modules/,
            use: {
                loader: 'babel-loader',
                options: {
                    presets: [
                        ['@babel/preset-env', { targets: "defaults" }]
                    ]
                }
            }
        },
        {
          test: /\.s?[c]ss$/i,
          use: [
            MiniCssExtractPlugin.loader,
            "css-loader",
            "postcss-loader",
            "sass-loader",
          ]
        },
        {
          test: /\.sass$/i,
          use: [
            MiniCssExtractPlugin.loader,
            'css-loader',
            "postcss-loader",
            {
              loader: 'sass-loader',
              options: {
                sassOptions: { indentedSyntax: true }
              }
            }
          ]
        },
        {
          test: /\.(jpg|jpeg|png|gif|woff|woff2|eot|ttf|svg)$/i,
          use: 'url-loader?limit=1024'
        }
      ]
    }
};