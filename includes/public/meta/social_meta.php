<!-- Modula Social Tags -->
<meta property='og:type' content="<?php
echo esc_html( $og_data['type'] ); ?>"/>
<meta name='title' property='og:title' content="<?php
echo esc_html( $og_data['title'] ); ?>"/>
<meta property='og:description' content="<?php
echo esc_html( wp_strip_all_tags( $og_data['description'] ) ); ?>"/>
<meta property='og:image' content="<?php
echo esc_url( $og_data['image'] ); ?>"/>
<meta property='og:url' content="<?php
echo esc_url( $og_data['url'] ); ?>"/>
<meta property='og:image:width' content='<?php
echo esc_html( $og_data['img_width'] ); ?>'/>
<meta property='og:image:height' content='<?php
echo esc_html( $og_data['img_height'] ); ?>'/>
<?php
if ( ! empty( $og_data['published_date'] ) ) { ?>
	<meta property="article:published_time" content="<?php
	echo esc_html( $og_data['published_date'] ); ?>"/>
	<?php
} ?>
<?php
if ( ! empty( $og_data['author'] ) ) { ?>
	<meta property="article:author" content="<?php
	echo esc_html( $og_data['author'] ); ?>"/>
	<?php
} ?>
<meta property="og:site_name" content="<?php
bloginfo( 'name' ); ?>"/>
<!-- Twitter tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php
echo esc_html( $og_data['title'] ); ?>"/>
<meta name="twitter:description" content="<?php
echo esc_html( $og_data['description'] ); ?>"/>
<meta name="twitter:image" content="<?php
echo esc_url( $og_data['image'] ); ?>"/>
<!-- End Modula Social Tags -->