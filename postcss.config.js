module.exports = {
	plugins: [
		require('autoprefixer'),
		require('postcss-prefix-selector')({
			prefix: '.mbgg',
			exclude: ['html', 'body'],
		})
	],
};
