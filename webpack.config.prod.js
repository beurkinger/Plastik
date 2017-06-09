const webpack = require('webpack');

plugins = [
  new webpack.DefinePlugin({
    'process.env': {
      'NODE_ENV': JSON.stringify('production')
    }
  }),
  new webpack.optimize.UglifyJsPlugin(),
  new webpack.optimize.OccurrenceOrderPlugin(),
  new webpack.optimize.AggressiveMergingPlugin()
];
var outputPath = __dirname + '/public';
outputFilename = 'js/transformed-mini.js';

module.exports = {
  entry: __dirname + '/src/index.js',
  module: {
    loaders: [{
      test: /\.js$/,
      exclude: /node_modules/,
      loader: 'babel-loader'
    }]
  },
  output: {
    filename: outputFilename,
    path: outputPath
  },
  plugins: plugins
};
