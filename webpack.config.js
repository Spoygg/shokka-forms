const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = (env) => {
  return {
    entry: {
      editor: './js/src/editor.js',
      front: ['./js/src/front.js', './css/src/style.scss']
    },
    mode: env.production ? 'production' : 'development',

    output: {
      filename: '[name].js',
      path: path.resolve(__dirname, 'js/dist/')
    },

    module: {
      rules: [
        {
          test: /\.m?js$/,
          exclude: /(node_modules|bower_componenets)/,
          use: {
            loader: 'babel-loader',
            options: {
              presets: ['@babel/preset-env', '@babel/preset-react']
            }
          }
        },
        {
          test: /\.scss$/i,
          use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader']
        }
      ]
    },
    plugins: [
      new MiniCssExtractPlugin(
        {
          filename: '../../css/dist/style.css'
        }
      )
    ]
  };
};
