<?php
if ( preg_match( '#' . basename( __FILE__ ) . '#', $_SERVER['PHP_SELF'] ) ) {
	die( _e( 'You are not allowed to call this page directly.', 'modula-gallery' ) );
}

$nobanner = true;
if ( empty( $tg_subtitle ) ) {
	$tg_subtitle = "Fix images";
}

$imageUrl = null;
foreach ( $this->ModulaDB->getGalleries() as $gallery ) {
	$gid    = $gallery->Id;
	$images = $this->ModulaDB->getImagesByGalleryId( $gid );
	if ( count( $images ) > 0 ) {
		$imageUrl = $images[0]->imagePath;
		break;
	}
}
$oldUrl = "&lt;OLD URL&gt;";
if ( strpos( $imageUrl, '/wp-content' ) > 0 ) {
	$oldUrl = strtolower( substr( $imageUrl, 0, strpos( $imageUrl, '/wp-content' ) ) );
}

?>

<?php include( "header.php" ); ?>
	<style>
		#fix-panel h2 {
			font-size: 18px;
			font-weight: bold;
			margin-bottom: 4px;
			padding-bottom: 0;
			line-height: 1;
		}

		#fix-panel pre {
			background: #fff;
			padding: 10px;
		}
	</style>
<?php if ( isset( $_GET['fix'] ) && $_GET['fix'] == '1' ) : ?>

	<?php

	$lines = array();
	foreach ( $this->ModulaDB->getGalleries() as $gallery ) {
		$gid    = $gallery->Id;
		$images = $this->ModulaDB->getImagesByGalleryId( $gid );
		foreach ( $images as $image ) {
			if ( strpos( strtolower( $image->imagePath ), $oldUrl ) === 0 ) {
				$lines [] = $image->imagePath;
			}
		}
	}

	?>
	<div class="row">
		<div class="col">
			<div class="card-panel lime lighten-4" id="fix-panel">
				<?php echo count( $lines ) ?> <?php echo esc_html__( 'image to be processed:', 'modula-gallery' ); ?>
				<pre><?php echo implode( "\n", $lines ) ?></pre>

				<?php
				$dir = wp_upload_dir();
				file_put_contents( $dir['basedir'] . "/old-images.txt", implode( "\n", $lines ) );

				$res = $wpdb->query( 'UPDATE ' . $wpdb->prefix . 'modula_images SET imagePath=REPLACE(imagePath, "' . $oldUrl . '", "' . site_url() . '")' );
				add_option( 'Modula_skip_fix', true );
				?>

				<?php if ( $res > 0 ) : ?>
					<h2><?php echo esc_html__( 'Fix completed successfully!', 'modula-gallery' ); ?></h2>
				<?php else : ?>
					<h2><?php echo esc_html__( 'No images where updated', 'modula-gallery' ); ?></h2>
				<?php endif ?>
				<a class="btn" href="?page=modula-lite-admin"><?php echo esc_html__( 'Go to dashboard', 'modula-gallery' ); ?></a>
			</div>
		</div>
	</div>
<?php else : ?>

	<div class="row">
		<div class="col">
			<div class="card-panel lime lighten-4" id="fix-panel">
				<strong>FIX</strong>: version 1.1.0 introduced a new way to resize images, now you can choose a custom
				image size for your galleries, regardless the sizes defined by your theme.<br> Although we thoroughly
				tested the new feature, <strong>some website may encounter an issue where images don't appear
					anymore</strong>.<br>
				<h2>For tech savvy:</h2>
				The cause is a wrong url inside the MySQL table <strong><?php echo $wpdb->prefix ?>
					modula_images</strong><br> If you know how to do it, you can easily fix the wrong urls inside the
				field <strong>imagePath</strong>. The query to use is:
				<pre>UPDATE <?php echo $wpdb->prefix ?>modula_images REPLACE(imagePath, '<?php echo $oldUrl ?>
					', '<?php echo site_url() ?>');</pre>

				<?php if ( $oldUrl == "&lt;OLD URL&gt;" ) : ?>
					where &lt;old URL&gt; is the previous URL of this site.
				<?php endif ?>
				<h2>For everyone:</h2>
				If you have updated the plugin and you have run into this issue then you can use the <strong>Fix
					tool</strong> by clicking the following button: <br> <br>
				<a href="?page=modula-lite-gallery-fix&fix=1" class="btn">Fix image paths</a> <br> <strong>If you're
					unsure about what to do then please contact
					<a href="mailto:diego@greentreelabs.net?subject=Help with Modula fix tool">diego@greentreelabs.net</a></strong>.
			</div>
		</div>
	</div>
<?php endif ?>