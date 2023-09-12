const path = require('path');
//const ExtractTextPlugin       = require('extract-text-webpack-plugin');
//const UglifyJSPlugin            = require('uglifyjs-webpack-plugin');
const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const CssEntryPlugin = require('css-entry-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

const config = {
	entry: {
		wp_modula_gutenberg: './assets/src/js/wp-modula-gutenberg.js'
	},
	output: {
		filename: 'js/admin/wp-modula-gutenberg.js',
		path: path.resolve(__dirname, 'assets')
	},
	module: {
		rules: [
			{
				test: /\.scss$/,
				/* 		use: ExtractTextPlugin.extract({
					fallback: 'style-loader', */
				use: [MiniCssExtractPlugin.loader, 'css-loader?url=false', 'postcss-loader', 'sass-loader' ]
				//}),
			},
			{
				test: /\.js$/,
				exclude: /(node_modules)/,
				loader: 'babel-loader'
			}
		]
	},
	plugins: [
		new MiniCssExtractPlugin({
			filename: '/css/admin/modula-gutenberg.css'
		}),
		//new ExtractTextPlugin('/css/[name].css'),
		new BrowserSyncPlugin({
			proxy: 'localhost/',
			port: 3000,
			files: [ '**/*.php' ],
			ghostMode: {
				clicks: false,
				location: false,
				forms: false,
				scroll: false
			},
			injectChanges: true,
			logFileChanges: true,
			logLevel: 'debug',
			logPrefix: 'wepback',
			notify: false,
			reloadDelay: 0
		})
	]
};

//If true JS and CSS files will be minified
if (process.env.NODE_ENV === 'production') {
	config.plugins.push(
		//new UglifyJSPlugin(),
		new OptimizeCssAssetsPlugin()
	);
}

module.exports = config;
