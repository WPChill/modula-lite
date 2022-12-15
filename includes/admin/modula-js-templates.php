<script type="text/html" id="tmpl-modula-image">
    <div class="modula-single-image-content {{data.orientation}}" <# if ( data.full != '' ) { #> style="background-image:url('{{ data.thumbnail }}')" <# } #> >
        <?php do_action( 'modula_admin_gallery_image_start' ) ?>
        <# if ( data.thumbnail != '' ) { #>
            <img src="{{ data.thumbnail }}">
        <# } #>
        <div class="actions">
            <?php do_action( 'modula_admin_gallery_image_before_actions' ) ?>
            <a href="#" class="modula-edit-image" title="<?php esc_attr_e( 'Edit Image', 'modula-best-grid-gallery' ) ?>"><span class="dashicons dashicons-edit"></span></a>
            <?php do_action( 'modula_admin_gallery_image_after_actions' ) ?>
            <a href="#" class="modula-delete-image" title="<?php esc_attr_e( 'Delete Image', 'modula-best-grid-gallery' ) ?>"><span class="dashicons dashicons-trash"></span></a>
        </div>
        <div class="segrip ui-resizable-handle ui-resizable-se"></div>
        <?php do_action( 'modula_admin_gallery_image_end' ) ?>
    </div>
</script>

<script type="text/html" id="tmpl-modula-image-editor">
    <div class="edit-media-header">
        <button class="left dashicons"><span class="screen-reader-text"><?php esc_html_e( 'Edit previous media item', 'modula-best-grid-gallery' ); ?></span></button>
        <button class="right dashicons"><span class="screen-reader-text"><?php esc_html_e( 'Edit next media item', 'modula-best-grid-gallery' ); ?></span></button>
    </div>
    <div class="media-frame-title">
        <h1><?php esc_html_e( 'Edit Metadata', 'modula-best-grid-gallery' ); ?></h1>
    </div>
    <div class="media-frame-content">
        <div class="attachment-details save-ready">
            <!-- Left -->
            <div class="attachment-media-view portrait">
                <div class="thumbnail thumbnail-image">
                    <img class="details-image" src="{{ data.full }}" draggable="false" />
                </div>
            </div>
            
            <!-- Right -->
            <div class="attachment-info">
                <!-- Settings -->
                <div class="settings">
                    <!-- Attachment ID -->
                    <input type="hidden" name="id" value="{{ data.id }}" />
                    
                    <!-- Image Title -->
                    <label class="setting">
                        <span class="name"><?php esc_html_e( 'Title', 'modula-best-grid-gallery' ); ?></span>
                        <input type="text" name="title" value="{{ data.title }}" />
                        <div class="description">
                            <?php esc_html_e( 'Image titles can take any type of HTML.', 'modula-best-grid-gallery' ); ?>
                        </div>
                    </label>
                  
                    
                    <!-- Alt Text -->
                    <label class="setting">
                        <span class="name"><?php esc_html_e( 'Alt Text', 'modula-best-grid-gallery' ); ?></span>
                        <input type="text" name="alt" value="{{ data.alt }}" />
                        <div class="description">
                            <?php esc_html_e( 'Very important for SEO, the Alt Text describes the image.', 'modula-best-grid-gallery' ); ?>
                        </div>
                    </label>

                    <!-- Caption Text -->
                    <label class="setting">
                        <span class="name"><?php esc_html_e( 'Caption Text', 'modula-best-grid-gallery' ); ?></span>
                        <textarea name="description">{{ data.description }}</textarea>
                        <div class="description">
                        </div>
                    </label>

                    <!-- Alignment -->
                    <div class="setting">
                        <span class="name"><?php esc_html_e( 'Alignment', 'modula-best-grid-gallery' ); ?></span>
                        <select name="halign" class="inline-input">
                            <option <# if ( 'left' == data.halign ) { #> selected <# } #>><?php esc_html_e( 'left', 'modula-best-grid-gallery' ); ?></option>
                            <option <# if ( 'center' == data.halign ) { #> selected <# } #>><?php esc_html_e( 'center', 'modula-best-grid-gallery' ); ?></option>
                            <option <# if ( 'right' == data.halign ) { #> selected <# } #>><?php esc_html_e( 'right', 'modula-best-grid-gallery' ); ?></option>
                        </select>
                        <select name="valign" class="inline-input">
                            <option <# if ( 'top' == data.valign ) { #> selected <# } #>><?php esc_html_e( 'top', 'modula-best-grid-gallery' ); ?></option>
                            <option <# if ( 'middle' == data.valign ) { #> selected <# } #>><?php esc_html_e( 'middle', 'modula-best-grid-gallery' ); ?></option>
                            <option <# if ( 'bottom' == data.valign ) { #> selected <# } #>><?php esc_html_e( 'bottom', 'modula-best-grid-gallery' ); ?></option>
                        </select>
                    </div>
                    
                    <!-- Link -->
                    <div class="setting modula-link">
                        <label class="">
                            <span class="name"><?php esc_html_e( 'URL', 'modula-best-grid-gallery' ); ?></span>
                            <input type="text" name="link" value="{{ data.link }}" />
	                        <span class="dashicons dashicons-editor-break"></span>
                            <span class="description">
                                <?php esc_html_e( ' You can start typing the first 3 letter and we will autocomplete the rest !' ); ?>
                                <?php esc_html_e( 'Enter a hyperlink if you wish to link this image to somewhere other than the general selected action.', 'modula-best-grid-gallery' ); ?>
                                <?php esc_html_e( '( Doesn\'t work for Direct link to image or No link )', 'modula-best-grid-gallery' ); ?>

                            </span>
                        </label>
                        <label>
                        <span class="description">
                            <input type="checkbox" name="target" value="1"<# if ( data.target == '1' ) { #> checked <# } #> />
                            <span><?php esc_html_e( 'Opens your image links in a new browser window / tab.', 'modula-best-grid-gallery' ); ?></span>
                        </span>
                        </label>
                    </div>

                    <!-- Hide from lightbox -->
                    <div class="setting modula-toggle-lightbox">
                        <div class="modula-toggle">
                            <label class="">
                                <span class="name"><?php esc_html_e( 'Hide image from lightbox', 'modula-best-grid-gallery' ); ?></span>
                                <input class="modula-toggle__input" type="checkbox" name="togglelightbox" value="1"<# if ( data.togglelightbox == '1' ) { #> checked <# } #> />
                                <div class="modula-toggle__items">
                                    <span class="modula-toggle__track"></span>
                                    <span class="modula-toggle__thumb"></span>
                                    <svg class="modula-toggle__off" width="6" height="6" aria-hidden="true"
                                            role="img"
                                            focusable="false"
                                            viewBox="0 0 6 6">
                                        <path d="M3 1.5c.8 0 1.5.7 1.5 1.5S3.8 4.5 3 4.5 1.5 3.8 1.5 3 2.2 1.5 3 1.5M3 0C1.3 0 0 1.3 0 3s1.3 3 3 3 3-1.3 3-3-1.3-3-3-3z"></path>
                                    </svg>
                                    <svg class="modula-toggle__on" width="2" height="6" aria-hidden="true"
                                            role="img"
                                            focusable="false"
                                            viewBox="0 0 2 6">
                                        <path d="M0 0h2v6H0z"></path>
                                    </svg>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Addons can populate the UI here -->
                    <div class="modula-addons"></div>
                </div>
                <!-- /.settings -->     
               
                <!-- Actions -->
                <div class="actions">
                    <a href="#" class="modula-gallery-meta-submit button media-button button-large button-primary media-button-insert" title="<?php esc_attr_e( 'Save Metadata', 'modula-best-grid-gallery' ); ?>">
                        <?php esc_html_e( 'Save', 'modula-best-grid-gallery' ); ?>
                    </a>
                    <a href="#" class="modula-gallery-meta-submit-close button media-button button-large media-button-insert" title="<?php esc_attr_e( 'Save & Close', 'modula-best-grid-gallery' ); ?>">
                        <?php esc_html_e( 'Save & Close', 'modula-best-grid-gallery' ); ?>
                    </a>

                    <!-- Save Spinner -->
                    <span class="settings-save-status">
                        <span class="spinner"></span>
                        <span class="saved"><?php esc_html_e( 'Saved.', 'modula-best-grid-gallery' ); ?></span>
                    </span>
                </div>
                <!-- /.actions -->
            </div>
        </div>
    </div>
</script>