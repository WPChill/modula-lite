// Load the translations
const { __ } = wp.i18n;
// Load the Modula objects
wp.Modula = 'undefined' === typeof wp.Modula ? {} : wp.Modula;

/**
 * Modula browse for file
 */
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
			instance.readIframeData();
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

		const instance = this;
		if ( ! instance.postID ) {
			instance.postID = document.getElementById( 'post_ID' ).value;
		}
		const $params = {
			action: 'modula_check_paths',
			paths: paths,
			security: modulaGalleryUpload.security,
			post_ID: instance.postID,
		};
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
		if ( instance.postID === 0 ) {
			instance.postID = document.getElementById( 'post_ID' ).value;
		}
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
				post_ID: instance.postID,
				security: modulaGalleryUpload.security,
			};
			const ajaxResponse = await instance.ajaxCall( $params ),
				response = await JSON.parse( ajaxResponse );
			if ( response.success ) {
				instance.progressClass.update( i + 1, files.length );
				filesIDs.push( response.data );
			} else {
				// Send error message
				instance.progressClass.changeText( response.data );
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
		} else {
			instance.progressClass.hideBar();
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
			ids: $ids,
			galleryID: instance.postID,
			security: modulaGalleryUpload.security,
		};

		const ajaxResponse = await instance.ajaxCall( $params ),
			response = await JSON.parse( ajaxResponse );
		if ( response.success ) {
			// Update the gallery
			instance.progressClass.changeText(
				modulaGalleryUpload.galleryUpdated
			);
			// Set data to send to the parent.
			const parentData = {
				action: 'modula_gallery_updated',
				postID: instance.postID,
				images: response.data,
				security: modulaGalleryUpload.security,
			};
			// Send data to the parent
			instance.sendDataToParent( parentData );
		}
	}
	/**
	 * Send data to parent
	 *
	 * @param {*} data
	 * @since 2.11.0
	 */
	sendDataToParent( data ) {
		window.parent.postMessage( data, '*' );
	}
	/**
	 * Read iframe data
	 *
	 * @since 2.11.0
	 */
	readIframeData() {
		const instance = this;
		window.addEventListener( 'message', function ( e ) {
			if ( e.data ) {
				// Return if action or security is undefined
				if (
					'undefined' === typeof e.data.action ||
					'undefined' === e.data.security
				) {
					return;
				}
				// Return if security does not match
				if ( modulaGalleryUpload.security !== e.data.security ) {
					return;
				}
				// Check if the action is modula_gallery_updated
				if ( e.data.action === 'modula_gallery_updated' ) {
					// Close the modal
					tb_remove();
					// Add files to the gallery
					instance.addFilesToGallery( e.data.images );
					// Add success notice
					const noticeWrapper =
							document.getElementsByClassName( 'wrap' )[ 0 ],
						text = __(
							'Import process completed.',
							'modula-best-grid-gallery'
						);
					instance.addNotice( noticeWrapper, text, 'success' );
				}
			}
		} );
	}
	/**
	 * Add files to gallery
	 *
	 * @param {*} images
	 * @since 2.11.0
	 */
	addFilesToGallery( images ) {
		const instance = this;
		// Get the images
		const imagesArray = Object.values( images );
		for ( let i = 0; i < imagesArray.length; i++ ) {
			const newModel = instance.generateSingleImage( imagesArray[ i ] );
			// Get checked input modula-settings[upload_position] value
			const uploadPosition = document.querySelector(
				'input[name="modula-settings[upload_position]"]:checked'
			).value;
			if ( 'start' === uploadPosition ) {
				wp.Modula.Items.add( newModel, { at: 0 } );
				wp.Modula.Items.trigger( 'newItemAdded', newModel );
			}
			wp.Modula.GalleryView.render();
		}
	}
	/**
	 * Generate single image
	 *
	 * @param {*} data
	 * @returns
	 *
	 * @since 2.11.0
	 */
	generateSingleImage( attachment ) {
		var data = {
			halign: 'center',
			valign: 'middle',
			link: '',
			target: '',
			togglelightbox: '',
			hideTitle: '',
		};

		if ( 'undefined' !== typeof attachment[ 'sizes' ] ) {
			data[ 'full' ] = attachment[ 'sizes' ][ 'full' ][ 'url' ];
			if ( 'undefined' != typeof attachment[ 'sizes' ][ 'large' ] ) {
				data[ 'thumbnail' ] = attachment[ 'sizes' ][ 'large' ][ 'url' ];
			} else {
				data[ 'thumbnail' ] = data[ 'full' ];
			}
		} else {
			data[ 'full' ] = attachment[ 'url' ];
			data[ 'thumbnail' ] = data[ 'full' ];
		}

		data[ 'id' ] = attachment[ 'id' ];
		data[ 'alt' ] = attachment[ 'alt' ];
		data[ 'orientation' ] = attachment[ 'orientation' ];
		data[ 'title' ] = attachment[ 'title' ];
		data[ 'description' ] = attachment[ 'caption' ];

		return new wp.Modula.items[ 'model' ]( data );
	}
	/**
	 * Add success notice
	 *
	 * @since 2.11.0
	 */
	addNotice( wrapper, text, type ) {
		const instance = this;
		const notice = document.createElement( 'div' );
		notice.className = 'notice notice-' + type + ' is-dismissible';
		notice.innerHTML = '<p>' + text + '</p>';
		// Prepend the notice to the wrapper
		wrapper.insertBefore( notice, wrapper.firstChild );
	}
}

/**
 * Modula progress bar class
 */
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
