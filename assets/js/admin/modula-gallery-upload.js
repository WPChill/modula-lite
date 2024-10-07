// Browse for file class
class ModulaBrowseForFile {
	postID = 0;
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
				action: 'modula_list_files',
				path: $link.attr( 'data-path' ),
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
				const checkedInputsEl = document.querySelectorAll(
						'input[type="checkbox"]:checked'
					),
					checkedInputs = Array.from( checkedInputsEl ),
					paths = checkedInputs.map( ( input ) => input.value );
				const responsePaths = await instance.checkPaths( paths );
				if ( ! responsePaths ) {
					// Send error message

					return;
				}
				const responseFiles =
					await instance.filesValidation( responsePaths );

				if ( ! responseFiles ) {
					// Send error message

					return;
				}
				// Import the files in the Media Library
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
			return false;
		}

		const $params = {
				action: 'modula_check_paths',
				paths: paths,
				security: modulaGalleryUpload.security,
			},
			instance = this;
		const ajaxResponse = await instance.ajaxCall( $params ),
			response = await JSON.parse( ajaxResponse );
		if ( response.success ) {
			return response.data;
		} else {
			return false;
		}
	}
	/**
	 * Files validation
	 *
	 * @param {*} paths
	 *
	 * @since 2.11.0
	 */
	async filesValidation( paths ) {
		if ( 0 === paths.length ) {
			return false;
		}
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
}

document.addEventListener( 'DOMContentLoaded', function () {
	window.send_to_browse_file_url = function ( html ) {
		tb_remove();
		window.send_to_editor = window.send_to_editor_default;
	};
	new ModulaBrowseForFile();
} );
