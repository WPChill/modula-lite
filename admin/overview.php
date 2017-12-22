<?php
if ( preg_match( '#' . basename( __FILE__ ) . '#', $_SERVER['PHP_SELF'] ) ) {
	die( _e( 'You are not allowed to call this page directly.', 'modula-gallery' ) );
}

if ( empty( $tg_subtitle ) ) {
	$tg_subtitle = "Dashboard";
}

$galleries = $this->ModulaDB->getGalleries();

$idx = 0;
?>


<?php include( "header.php" ); ?>

<div class="bd">

	<?php if ( isset( $redir ) && $redir ) : ?>
		<div class="row ">
			<div class="col s12 m6 l4">
				<div class="card-panel light-green lighten-4">
					<h5 class="cyan-text text-darken-3"><?php echo esc_html__( 'Redirecting....', 'modula-gallery' ) ?></h5>
					<p>
						<?php echo esc_html__( 'Click a gallery to edit', 'modula-gallery' ) ?>. </p>
				</div>
			</div>
		</div>
		<script>location.href = '?page=modula-lite-admin';</script>
	<?php endif ?>

	<?php if ( count( $galleries ) == 0 ) : ?>
		<div class="row ">
			<div class="col s12 m6 l4">
				<div class="card-panel light-green lighten-4">
					<h5 class="cyan-text text-darken-3"><?php echo esc_html__( 'Welcome to Modula Gallery!', 'modula-gallery' ) ?></h5>
					<p>
						<?php echo esc_html__( 'Create your first awesome gallery, click', 'modula-gallery' ) ?>
						<a href="?page=modula-lite-add"><?php echo esc_html__( 'here', 'modula-gallery' ) ?></a>. </p>
				</div>
			</div>
		</div>
	<?php else : ?>

		<div id="gallery-list" class="row">
			<?php foreach ( $galleries as $gallery ) : ?><?php
				$gid     = $gallery->Id;
				$images  = $this->ModulaDB->getImagesByGalleryId( $gid );
				$bg      = count( $images ) ? "url('" . $images[0]->imagePath . "')" : "none";
				$gallery = json_decode( $gallery->configuration );
				?><?php wp_nonce_field( 'Modula', 'Modula' ); ?>
				<div class="col s12 m6 l4">
					<div class="card <?php echo count( $images ) ? "with-image" : "" ?>" id="gallery-<?php echo esc_attr( $gid ); ?>" data-gid="<?php echo esc_attr( $gid ); ?>">

						<div class="data" style="background-image:<?php echo esc_attr( $bg ); ?>">
							<div class="card-content white-text">
								<span class="card-title"><?php echo esc_html( $gallery->name ); ?></span> <br>
								<?php if ( strlen( $gallery->description ) ) : ?>
									<p><?php echo esc_html( $gallery->description ) ?></p>
								<?php endif ?>
							</div>
							<div class="card-action darken-4">
								<a href="#" data-tooltip="Show shortcode" data-position="top" data-delay="10" class="tooltipped waves-effect show-shortcode" data-gid="<?php echo esc_attr( $gid ); ?>"><i class="mdi mdi-code-array"></i></a>
								<a href="?page=modula-lite-edit&galleryId=<?php echo absint( $gid ); ?>" data-tooltip="Edit gallery" data-position="top" data-delay="10" class="tooltipped
								waves-effect waves"><i class="mdi mdi-pencil"></i></a>
								<a data-tooltip="Clone gallery" data-position="top" data-delay="10" class="tooltipped waves-effect waves clone-gallery" data-gid="<?php echo esc_attr( $gid ); ?>"><i class="mdi mdi-content-copy"></i></a>

								<a data-tooltip="Delete gallery" datacolor="red" data-position="top" data-delay="10" class="tooltipped waves-effect waves delete-gallery" data-gid="<?php echo esc_attr( $gid ); ?>"><i class="mdi mdi-delete"></i></a>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach ?>
		</div>
	<?php endif ?>

	<!-- Delete gallery modal -->
	<div id="delete-gallery-modal" class="modal">
		<div class="modal-content">
			<h4><?php echo esc_html__( 'Confirmation', 'modula-gallery' ) ?></h4>
			<p><?php echo esc_html__( 'Do you really want to delete the gallery', 'modula-gallery' ) ?> <span></span> ?
			</p>
		</div>
		<div class="modal-footer">
			<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat yes"><?php echo esc_html__( 'Yes', 'modula-gallery' ) ?></a>
			<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat"><?php echo esc_html__( 'No', 'modula-gallery' ) ?></a>
		</div>
	</div>

	<!-- Shortcode gallery modal -->
	<div id="shortcode-gallery-modal" class="modal">
		<div class="modal-content">
			<h4></h4>
			<p><?php echo esc_html__( 'Copy and paste the following shortcode inside a post, page or widget:', 'modula-gallery' ) ?></p>
			<code></code>
		</div>
		<div class="modal-footer">
			<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat"><?php echo esc_html__( 'Close', 'modula-gallery' ) ?></a>
		</div>
	</div>

	<div class="preloader-wrapper big active" id="spinner">
		<div class="spinner-layer spinner-blue-only">
			<div class="circle-clipper left">
				<div class="circle"></div>
			</div>
			<div class="gap-patch">
				<div class="circle"></div>
			</div>
			<div class="circle-clipper right">
				<div class="circle"></div>
			</div>
		</div>
	</div>

	<script>
      (function( $ ) {
        var galleryId;
        var galleryName;

        $( '.card .card-content' ).click( function() {
          var id = $( this ).parents( '.card' ).data( 'gid' );
          location.href = '?page=modula-lite-edit&galleryId=' + id;
        } );

        $( '.delete-gallery' ).click( function( e ) {
          e.preventDefault();
          galleryId = $( this ).data( 'gid' );
          galleryName = $( this ).parents( '.data' ).find( '.card-title' ).text();
          $( '#delete-gallery-modal span' ).text( galleryName );
          $( '#delete-gallery-modal' ).modal();
          $( '#delete-gallery-modal' ).modal( 'open' );
        } );

        $( '.clone-gallery' ).click( function( e ) {
          e.preventDefault();
          var id = $( this ).data( 'gid' );
          var name = $( this ).parents( '.data' ).find( '.card-title' ).text();

          var data = { 'action': 'modula_clone_gallery', 'gid': id, 'Modula': $( '#Modula' ).val() };
          TG.show_loading();
          jQuery.post( ajaxurl, data, function( response ) {
            Materialize.toast( 'Gallery "' + name + '" cloned', 2000 );
            location.reload();
            TG.hide_loading();

          } );

        } );

        $( '.show-shortcode' ).click( function( e ) {
          e.preventDefault();

          var id = $( this ).data( 'gid' );
          var name = $( this ).parents( '.data' ).find( '.card-title' ).text();
          $( '#shortcode-gallery-modal h4' ).text( name );
          $( '#shortcode-gallery-modal code' ).text( '[Modula id=\'' + id + '\']' );
          $( '#shortcode-gallery-modal' ).modal();
          $( '#shortcode-gallery-modal' ).modal( 'open' );
        } );

        $( 'body' ).on( 'click', '#delete-gallery-modal .yes', function() {

          var data = { 'action': 'modula_delete_gallery', 'gid': galleryId, 'Modula': $( '#Modula' ).val() };
          TG.show_loading();

          jQuery.post( ajaxurl, data, function( response ) {
            Materialize.toast( 'Gallery "' + galleryName + '" deleted', 2000 );
            $( '#gallery-' + galleryId ).remove();
            TG.hide_loading();
            location.reload();
          } );

        } );
      })( jQuery );
	</script>