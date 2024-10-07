// Load the translations
const { __ } = wp.i18n;

// Browse for file class
class ModulaBrowseForFile {
	/**
	 * Post ID
	 *
	 * @since 2.11.0
	 */
	postID = 0;

	/**
	 * The progress class
	 *
	 * @since 2.11.0
	 */
	progressClass = false;

	/**
	 * Constructor
	 *
	 * @since 2.11.0
	 */
	constructor() {
		const instance = this;
		// Add user actions
		instance.add_actions();
		instance.postObject = document.getElementById( 'post_ID' );
		if ( instance.postObject ) {
			instance.postID = instance.postObject.value;
		}
	}
	/**
	 * Add actions
	 *
	 * @snice 2.11.0
	 */
	add_actions() {
		const instance = this,
			modulaFileBrowserButton = document.getElementById(
				'modula-uploader-folder-browser'
			);
		if ( modulaFileBrowserButton ) {
			modulaFileBrowserButton.addEventListener( 'click', function ( e ) {
				// Prevent default action
				e.preventDefault();

				window.send_to_editor = window.send_to_browse_file_url;

				tb_show(
					modulaGalleryUpload.browseFolder,
					'media-upload.php?post_id=' +
						instance.postID +
						'&amp;type=modula_file_browser&amp;from=wpdlm01&amp;TB_iframe=true'
				);

				return false;
			} );
		}
	}
	/**
	 * File browser
	 *
	 * @since 2.11.0
	 */
	fileBrowser() {
		const instance = this;
		// Event delegation - listens for clicks on dynamically added elements
		document.body.addEventListener( 'click', function ( e ) {
			if ( e.target && e.target.matches( '.modula_file_browser a' ) ) {
				e.preventDefault();
				// Code to handle the click event on the dynamically added element
				instance.addFolderClick( e.target );
			}
		} );
		instance.foldersFilesValidation();
	}
	/**
	 * Add folder click
	 *
	 * @param {*} folderLink
	 * @returns
	 *
	 * @since 2.11.0
	 */
	addFolderClick( folderLink ) {
		const instance = this,
			$link = jQuery( folderLink ),
			$parent = $link.closest( 'li' ),
			$input = $parent.find( 'input[type="checkbox"]' ),
			$inputChecked = $input.is( ':checked' );

		if ( $parent.is( '.folder_open' ) ) {
			$parent.find( 'ul' ).remove();
			$parent.removeClass( 'folder_open' );
		} else {
			$link.after( '<ul class="load_tree loading"></ul>' );
			var data = {
				action: 'modula_list_folders',
				path: $link.attr( 'data-path' ),
				postID: instance.postID,
				security: modulaGalleryUpload.security,
				'input-checked': $inputChecked,
			};

			jQuery.post(
				modulaGalleryUpload.ajaxUrl,
				data,
				function ( response ) {
					$parent.addClass( 'folder_open' );

					if ( response ) {
						$parent.find( '.load_tree' ).html( response );
					} else {
						$parent
							.find( '.load_tree' )
							.html( modulaGalleryUpload.noSubFolders );
					}
					$parent
						.find( '.load_tree' )
						.removeClass( 'load_tree loading' );
				}
			);
		}
		return false;
	}
	/**
	 *  Validate folders
	 *
	 * @since 2.11.0
	 */
	foldersFilesValidation() {
		const instance = this,
			modulaSendFoldersButton = document.getElementById(
				'modula_create_gallery'
			);

		modulaSendFoldersButton.addEventListener(
			'click',
			async function ( e ) {
				e.preventDefault();
				instance.progressClass.changeText(
					modulaGalleryUpload.startFolderValidation
				);
				const checkedInputsEl = document.querySelectorAll(
						'input[type="checkbox"]:checked'
					),
					checkedInputs = Array.from( checkedInputsEl ),
					paths = checkedInputs.map( ( input ) => input.value );
				const responsePaths = await instance.checkPaths( paths );
				if ( ! responsePaths.success ) {
					// Send error message
					instance.progressClass.changeText( responsePaths.data );
					return;
				}
				instance.progressClass.changeText(
					__( 'Found ', 'modula-best-grid-gallery' ) +
						responsePaths.data.length +
						__(
							' folders. Starting files validation...',
							'modula-best-grid-gallery'
						)
				);
				const responseFiles = await instance.filesValidation(
					responsePaths.data
				);

				if ( ! responseFiles.success ) {
					// Send error message
					instance.progressClass.changeText( responseFiles.data );
					return;
				}
				instance.progressClass.changeText(
					__( 'Found ', 'modula-best-grid-gallery' ) +
						responseFiles.data.length +
						__(
							' valid files. Starting importing the files...',
							'modula-best-grid-gallery'
						)
				);

				// Import the files in the Media Library
				instance.importFiles( responseFiles.data );
			}
		);
	}
	/**
	 * Check paths
	 *
	 * @param {*} paths
	 * @returns
	 *
	 * @since 2.11.0
	 */
	async checkPaths( paths ) {
		if ( paths.length === 0 ) {
			return {
				success: false,
				data: modulaGalleryUpload.noFoldersSelected,
			};
		}

		const $params = {
				action: 'modula_check_paths',
				paths: paths,
				security: modulaGalleryUpload.security,
			},
			instance = this;
		const ajaxResponse = await instance.ajaxCall( $params ),
			response = await JSON.parse( ajaxResponse );
		return response;
	}
	/**
	 * Files validation
	 *
	 * @param {*} paths
	 *
	 * @since 2.11.0
	 */
	async filesValidation( paths ) {
		const $params = {
				action: 'modula_check_files',
				paths: paths,
				security: modulaGalleryUpload.security,
			},
			instance = this;

		const ajaxResponse = await instance.ajaxCall( $params ),
			response = await JSON.parse( ajaxResponse );

		return response;
	}
	/**
	 * AJAX request
	 * @param {*} $params
	 * @param {*} $callback
	 * @returns
	 *
	 * @since 2.11.0
	 */
	async ajaxCall( $params ) {
		return new Promise( ( resolve, reject ) => {
			// Create a new XMLHttpRequest object.
			var xhr = new XMLHttpRequest();
			var params = new URLSearchParams();
			// Set the request parameters.
			if ( $params ) {
				// Loop through the parameters and append them to the URLSearchParams object.
				for ( let key in $params ) {
					if ( ! $params.hasOwnProperty( key ) ) {
						continue;
					}
					params.append( key, $params[ key ] );
				}
			}
			// Set request to admin-ajax.php.
			xhr.open( 'POST', modulaGalleryUpload.ajaxUrl, true );
			// Set the content type for a POST request.
			xhr.setRequestHeader(
				'Content-Type',
				'application/x-www-form-urlencoded'
			);
			// Detect when the request is complete
			xhr.onreadystatechange = function () {
				if ( xhr.readyState === 4 ) {
					// 4 means request is done
					if ( xhr.status === 200 ) {
						// 200 is a successful status
						resolve( xhr.response );
					} else {
						// Handle error if necessary
						reject( xhr.response );
					}
				}
			};

			// Define what happens in case of an error.
			xhr.onerror = function () {
				console.error( 'Request failed' );
				// Send error message
			};

			// Send the request with parameters.
			xhr.send( params.toString() );
		} );
	}
	/**
	 * Import files
	 *
	 * @param {*} files
	 * @since 2.11.0
	 */
	async importFiles( files ) {
		const instance = this;
		let filesIDs = [];
		instance.progressClass.update( 0.3, files.length );
		// Cycle through the files and import them
		for ( let i = 0; i < files.length; i++ ) {
			instance.progressClass.changeText(
				__( 'Importing file ', 'modula-best-grid-gallery' ) +
					( i + 1 ) +
					__( ' of ', 'modula-best-grid-gallery' ) +
					files.length
			);
			const file = files[ i ];
			const $params = {
				action: 'modula_import_file',
				file: file,
				security: modulaGalleryUpload.security,
			};
			const ajaxResponse = await instance.ajaxCall( $params ),
				response = await JSON.parse( ajaxResponse );
			if ( response.success ) {
				instance.progressClass.update( i + 1, files.length );
				filesIDs.push( response.data );
			} else {
				// Send error message
			}
		}

		// Check if there are files to import
		if ( filesIDs.length > 0 ) {
			instance.progressClass.changeText(
				__( 'Imported ', 'modula-best-grid-gallery' ) +
					filesIDs.length +
					__( ' files.', 'modula-best-grid-gallery' )
			);
			// Wait for 2 seconds before updating the gallery.
			setTimeout( function () {
				instance.progressClass.hideBar();
				instance.progressClass.changeText(
					modulaGalleryUpload.updatingGallery
				);
				// Update the gallery
				instance.updateGallery( filesIDs );
			}, 2000 );
		}
	}

	/**
	 * Update gallery
	 *
	 * @param {*} ids
	 * @since 2.11.0
	 */
	async updateGallery( $ids ) {
		const instance = this;
		instance.postID = document.getElementById( 'post_ID' ).value;

		const $params = {
			action: 'modula_add_images_ids',
			ids: JSON.stringify( $ids ),
			galleryID: instance.postID,
			security: modulaGalleryUpload.security,
		};

		const ajaxResponse = await instance.ajaxCall( $params ),
			response = await JSON.parse( ajaxResponse );

		if ( response.success ) {
			// Update the gallery
			//instance.updateGalleryView( response.data );
			instance.progressClass.changeText(
				modulaGalleryUpload.galleryUpdated
			);
		}
	}
}

class ModulaProgressBar {
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
	 * Constructor
	 *
	 * @since 2.11.0
	 */
	constructor( el ) {
		const instance = this;
		instance.wrapper = document.getElementById( el );
		// Create the progress bar element
		instance.progressBar = document.createElement( 'div' );
		instance.progressBar.className = 'modula-progress-bar';
		// Create the progress text element
		instance.progressText = document.createElement( 'div' );
		instance.progressText.className = 'modula-progress-text';
	}
	/**
	 * Progress display
	 *
	 * @since 2.11.0
	 */
	display() {
		const instance = this;
		instance.wrapper.appendChild( instance.progressText );
		instance.wrapper.appendChild( instance.progressBar );
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
}

document.addEventListener( 'DOMContentLoaded', function () {
	window.send_to_browse_file_url = function ( html ) {
		tb_remove();
		window.send_to_editor = window.send_to_editor_default;
	};
	new ModulaBrowseForFile();
} );
