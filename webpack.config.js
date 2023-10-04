var defaultConfig = require('@wordpress/scripts/config/webpack.config');
var TerserPlugin = require('terser-webpack-plugin');
var glob = require('glob');
var path = require('path');

module.exports = {
	...defaultConfig,
	target: 'node',
	entry: {
		scripts: glob.sync('./assets/**/*.js', { dotRelative: true }),
		styles: glob.sync('./assets/**/*.css', { dotRelative: true }),
	},
	output: {
		path: path.resolve(__dirname, 'assets'),
		filename: '[name].min.js',
		sourceMapFilename: '[name].js.map',
		clean: true,
	},
	resolve: {
		// Add `.ts` and `.tsx` as a resolvable extension.
		extensions: ['.js', '.css', '.scss'],
	},
	optimization: {
		minimize: true,
		minimizer: [
			new TerserPlugin({
				terserOptions: {
					parse: {},
					compress: {
						drop_console: true,
					},
					mangle: true, // Note `mangle.properties` is `false` by default.
					module: false,
					sourceMap: true,
				},
			}),
		],
	},
	module: {
		...defaultConfig.module,
		rules: [
			...defaultConfig.module.rules,
			{
				use: ['css-loader'],
				test: /\.scss$/,
				use: [
					{
						loader: 'resolve-url-loader',
						options: { attempts: 1, sourceMap: true },
					},
					{
						loader: 'css-loader',
						options: {
							modules: true,
							sourceMap: true,
							url: false,
							importLoaders: 2,
						},
					},
					{ loader: 'sass-loader', options: { sourceMap: true } }, // to convert SASS to CSS
				],
			},
		],
	},
	plugins: [...defaultConfig.plugins],
};
