<?php

$affiliate = get_option( 'modula_affiliate', array() );
$affiliate = wp_parse_args( $affiliate, array( 'link' => 'https://wp-modula.com', 'text' => 'Powered by' ) );

?>
<div class="row">
    <p><?php echo esc_html__('In the options below you would need to copy your affiliate link into the affiliate link input . Afterwards you would need to type in your powered by text that you would like to be displayed before the link. Now all that is left to do, is to copy the following shortcode : ', 'modula-best-grid-gallery') ?> <code> [modula-make-money] </code> <?php echo esc_html__( 'and paste it wherever you would like it to be displayed, ie: post, page. The shortcode has an extra parameter that you can override the powered by text, ie: ', 'modula-best-grid-gallery') ?><code>[modula-make-money text="I am making money with"] </code>. <?php echo esc_html__( 'This would be helpful if you would like different texts on different pages. You also have the option from the gallery settings page to toggle on the Powered By. ( you can find the toggle in the General tab) ','modula-best-grid-gallery'); ?></p>
	<p><?php echo esc_html__( 'You can find out more on how to become an affiliate', 'modula-best-grid-gallery'); ?> <a href="https://wp-modula.com/become-an-affiliate/" target="_blank"> <?php echo esc_html__( 'here', 'modula-best-grid-gallery'); ?> </a>
	</p>

	<form method="post" action="options.php">

		<?php settings_fields('modula_affiliate'); ?>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('Affiliate Link', 'modula-best-grid-gallery'); ?>
					</th>
					<td>
						<input id="modula_affiliate_link" name="modula_affiliate[link]" type="text" class="regular-text" value="<?php echo isset( $affiliate['link']) ? esc_attr( esc_url( $affiliate['link'] ) ) : ''; ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row" valign="top">
						<?php esc_html_e('Powered By Text', 'modula-best-grid-gallery'); ?>
					</th>
					<td>
						<input id="modula_affiliate_text" name="modula_affiliate[text]" type="text" class="regular-text" value="<?php echo isset($affiliate['text']) ? esc_attr( sanitize_text_field( $affiliate['text'] ) ) : '' ?>" />
					</td>
				</tr>
			</tbody>
		</table>
		<?php submit_button(); ?>
	</form>
</div>