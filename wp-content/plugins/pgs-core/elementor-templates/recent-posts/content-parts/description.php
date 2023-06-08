<?php
$intro_description = isset( $settings['intro_description'] ) ? $settings['intro_description'] : '';
if ( $intro_description ) {
	?>
	<div class="latest-post-description"><?php echo esc_html( $intro_description ); ?></div>
	<?php
}
