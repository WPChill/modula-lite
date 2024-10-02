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
}

document.addEventListener( 'DOMContentLoaded', function () {
	window.send_to_browse_file_url = function ( html ) {
		tb_remove();
		window.send_to_editor = window.send_to_editor_default;
	};
	new ModulaBrowseForFile();
} );
