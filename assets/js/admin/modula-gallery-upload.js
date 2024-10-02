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
		instance.foldersValidation();
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
	foldersValidation() {
		const instance = this,
			modulaSendFoldersButton = document.getElementById(
				'modula_create_gallery'
			);

		modulaSendFoldersButton.addEventListener( 'click', function ( e ) {
			e.preventDefault();
			const checkedInputsEl = document.querySelectorAll(
					'input[type="checkbox"]:checked'
				),
				checkedInputs = Array.from( checkedInputsEl ),
				paths = checkedInputs.map( ( input ) => input.value );
			const response = instance.checkPaths( paths );
			if ( ! response ) {
				// Sed error message
			}
			// Send the images folders paths to be added to be validated
		} );
	}
	/**
	 * Check paths
	 *
	 * @param {*} paths
	 * @returns
	 *
	 * @since 2.11.0
	 */
	checkPaths( paths ) {
		const instance = this;
		let ajaxResponse = false;
		if ( paths.length === 0 ) {
			return false;
		}
		var xhr = new XMLHttpRequest();
		var params = new URLSearchParams();
		// Set the request parameters.
		params.append( 'action', 'modula_check_paths' );
		params.append( 'paths', paths );
		params.append( 'security', modulaGalleryUpload.security );
		// Set request to admin-ajax.php.
		xhr.open( 'POST', modulaGalleryUpload.ajaxUrl, true );
		// Set the content type for a POST request.
		xhr.setRequestHeader(
			'Content-Type',
			'application/x-www-form-urlencoded'
		);
		// Define what happens on successful data submission.
		xhr.onload = function () {
			if ( xhr.status >= 200 && xhr.status < 400 ) {
				ajaxResponse = JSON.parse( xhr.response );
				if ( ajaxResponse.success ) {
					// Send success message and number of valid paths found.

				} else {
					// Send error message
				}
			} else {
				// Send error message
			}
		};

		// Define what happens in case of an error.
		xhr.onerror = function () {
			console.error( 'Request failed' );
			// Send error message
		};

		// Send the request with parameters.
		xhr.send( params.toString() );
		// Return the response.
		return xhr.response;
	}
}

document.addEventListener( 'DOMContentLoaded', function () {
	window.send_to_browse_file_url = function ( html ) {
		tb_remove();
		window.send_to_editor = window.send_to_editor_default;
	};
	new ModulaBrowseForFile();
} );
