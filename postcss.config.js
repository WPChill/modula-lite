module.exports = {
	plugins: [
		require( 'autoprefixer' ),
		require( 'postcss-prefix-selector' )( {
			prefix: '.modula-best-grid-gallery',
			exclude: [ 'html', 'body', /^#wpchill-notifications-root/, /^#modula-settings-app/, /^#wpcontent/, /^#mgJo4qgDDlzuqMIoKOJU/ ],
			ignoreFiles: [ /apps\/.*/, /.*\.module\.scss$/ ],
		} ),
	],
};
