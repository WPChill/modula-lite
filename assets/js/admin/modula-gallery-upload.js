// Browse for file class
class ModulaBrowseForFile {
	postID = 0;
	constructor() {
		const instance = this;
		// Add user actions
		instance.add_actions();
		instance.postID = document.getElementById( 'post_ID' ).value;
	}
	add_actions() {
		const instance = this,
			modulaFileBrowserButton = document.getElementById(
				'modula-uploader-folder-browser'
			);
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
	browserModal( url ) {}
}

document.addEventListener( 'DOMContentLoaded', function () {
	window.send_to_browse_file_url = function ( html ) {
		tb_remove();
		window.send_to_editor = window.send_to_editor_default;
	};
	new ModulaBrowseForFile();
} );
