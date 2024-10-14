/**
 * Modula progress bar class
 */
class ModulaProgress {
	/**
	 * Progress bar wrapper
	 *
	 * @since 2.11.0
	 */
	wrapper = null;

	/**
	 * Progress bar element
	 *
	 * @since 2.11.0
	 */
	progressBar = 0;

	/**
	 * Progress bar text
	 * Place where the info about the progress is displayed
	 *
	 * @since 2.11.0
	 */
	progressText = '';

	/**
	 * Progress bar progress
	 *
	 * @since 2.11.0
	 */
	progress = 0;

	/**
	 * Progress bar total
	 *
	 * @since 2.11.0
	 */
	total = 0;

	/**
	 * No Modal progress
	 * 
	 * @since 2.11.0
	 */
	modal = false;

	/**
	 * No Modal container
	 * 
	 * @since 2.11.0
	 */
	noModalContainer = null;

	/**
	 * No Modal files count
	 * 
	 * @since 2.11.0
	 */
	noModalFilesCount = 0;

	/**
	 * No Modal progress bar
	 * 
	 * @since 2.11.0
	 */
	noModalProgressBar = 0;

	/**
	 * Constructor
	 *
	 * @since 2.11.0
	 */
	constructor( el, modal = true ) {
		const instance = this;
		instance.modal = modal;
		instance.wrapper = document.getElementById( el );
		if ( instance.modal ) {
			// Create the progress bar element
			instance.progressBar = document.createElement( 'div' );
			instance.progressBar.className = 'modula-progress-bar';
			// Create the progress text element
			instance.progressText = document.getElementById('modula-progress-text');
		} else {
			instance.progressText = document.createElement( 'div' );
			instance.progressText.className = 'modula-progress-text';
		}
	}
	/**
	 * Progress display
	 *
	 * @since 2.11.0
	 */
	display() {
		const instance = this;
		if ( instance.modal ) {
			instance.wrapper.appendChild( instance.progressBar );
		} else {
			instance.wrapper.appendChild( instance.progressText );
		}
	}
	/**
	 * Update progress bar
	 *
	 * @since 2.11.0
	 */
	update( progress, total ) {
		const instance = this;
		instance.progress = progress;
		instance.total = total;
		instance.progressBar.style.width = ( progress / total ) * 100 + '%';
	}
	/**
	 * Change text
	 *
	 * @param {*} text
	 *
	 * @since 2.11.0
	 */
	changeText( text ) {
		const instance = this;
		instance.progressText.innerHTML = text;
	}
	/**
	 * Hide bar
	 *
	 * @since 2.11.0
	 */
	hideBar() {
		const instance = this;
		instance.progressBar.style.display = 'none';
	}
	/**
	 * No Modal init
	 *
	 * @param {*} files
	 *
	 * @since 2.11.0
	 */
	initNoModal( files ) {
		const instance = this;
		instance.noModalContainer = jQuery( '.modula-uploading-info' );
		instance.noModalProgressBar = jQuery( '.modula-progress-bar' );
		instance.noModalFilesCount = files.length;
	}
	/**
	 * No Modal Show bar
	 *
	 * @since 2.11.0
	 */
	noModalShowBar() {
		const instance = this;
		// Show the progress bar
		// Set the status text, to tell the user what's happening
		jQuery(
			'.modula-upload-numbers .modula-current',
			instance.noModalContainer
		).text( '1' );
		jQuery(
			'.modula-upload-numbers .modula-total',
			instance.noModalContainer
		).text( instance.noModalFilesCount );

		// Show progress bar
		instance.noModalContainer.addClass( 'show-progress' );
	}
	/**
	 * No Modal Hide bar
	 * @since 2.11.0
	 */
	noModalHideBar() {
		const instance = this;
		setTimeout( function () {
			instance.noModalContainer.removeClass( 'show-progress' );
		}, 1000 );
	}
	/**
	 * No Modal Update progress
	 *
	 * @since 2.11.0
	 */
	noModalProgress( $file ) {
		const instance = this;
		// Update the status text
		jQuery(
			'.modula-upload-numbers .modula-current',
			instance.noModalContainer
		).text( $file );

		// Update the progress bar
		jQuery( '.modula-progress-bar-inner', instance.noModalProgressBar ).css(
			{
				width:
					Math.round( ( $file * 100 ) / instance.noModalFilesCount ) +
					'%',
			}
		);
	}
}