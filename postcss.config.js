module.exports = {
	plugins: [
		require( 'autoprefixer' ),
		require( 'postcss-prefix-selector' )( {
			prefix: '.modula-best-grid-gallery',
			exclude: [ 'html', 'body', /^#wpchill-notifications-root/ ],
		} ),
	],
};
