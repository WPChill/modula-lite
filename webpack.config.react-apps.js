const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const isProduction = process.env.NODE_ENV === 'production';

module.exports = {
	...defaultConfig,
	mode: isProduction ? 'production' : 'development',
};
