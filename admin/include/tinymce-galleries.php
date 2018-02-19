 <?php global $wp_version, $wpdb, $wp_post_types; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title> <?php _e( 'Modula Grid Gallery', 'modula-gallery' ) ?> </title>
		<!--<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>-->
		<script>
		var wpColorPickerL10n = {"clear":"Clear","defaultString":"Default","pick":"Select Color","current":"Current Color"};
		</script>
		<script type="text/javascript" src="<?php print $admin_url ?>/load-scripts.php?c=1&load%5B%5D=jquery-core,jquery-migrate,utils,jquery-ui-core,jquery-ui-widget,jquery-ui-mouse,jquery-ui-draggable,jquery-ui-slider,jquery-tou&load%5B%5D=ch-punch,iris,wp-color-picker"></script>
		<link rel="stylesheet" href="<?php print admin_url( 'load-styles.php?c=1&dir=ltr&load=buttons,wp-admin,iris,wp-color-picker'); ?>" type="text/css" media="all">			
		<link rel="stylesheet" href="<?php print $css_path ?>">
		<script language="javascript" type="text/javascript" src="<?php echo includes_url( 'js/tinymce/tiny_mce_popup.js' ).'?ver='.$wp_version; ?>"></script> 	
		<style type="text/css">
			h1
			{
				color: black;
			}
			body {
				overflow-y:scroll;
				padding: 5px 20px 100px 20px;
				height: auto;
			}		
			#galleries{
				width: 100%;
				border-collapse: collapse;
			}	
			tr:nth-child(1){
				background-color: #90caf9;
			}
			tr{
				background-color: #e3f2fd;
				cursor: pointer;
			}
			tr:not(:nth-child(1)):hover{
				background-color: #bbdefb;
			}			

			#galleries td, #galleries th{
				border: 1px solid white;
				padding: 10px;
			}
		</style>
	</head>
	<body class="popup">
		<h1> <?php _e( 'YOUR GALLERIES', 'modula-gallery' ) ?>: </h1>
		<br>
		<table id="galleries">
			<!-- list here galleries -->
			<!-- loop variable $galleries -->
			<tr>
				<td>
					<b> <?php _e( 'ID', 'modula-gallery' ) ?> </b>
				</td>

				<td>
					<b> <?php _e( 'Name', 'modula-gallery' ) ?> </b>
				</td>
				
				
			</tr>
			<?php foreach($galleries as $gallery): ?>	
				<?php $gid = $gallery->Id; $gallery = json_decode($gallery->configuration);  ?>	
				<tr>
					<td>
						<?php print $gid ?>
					</td>
					<td>
						<label  id="<?php print 'gall_' . $gid ?>"> <?php print $gallery->name ?> </label>
					</td>	
				</tr>
			<?php endforeach ?>
		</table>
		<script>
		jQuery("#galleries tr").click(function (e) {
			var id = jQuery(this).find('label').attr('id').split('gall_');
			id.shift();	
			top.tinymce.activeEditor.insertContent('[Modula id="'+ id +'"]');
			top.tinymce.activeEditor.windowManager.close(); 
		});
		</script>
	</body>
</html>
