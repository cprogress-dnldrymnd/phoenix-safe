<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_products_listing'] );
extract( $atts );

if ( 'image' === $intro_bg_type && $intro_bg_image ) {
	?>
	<div class="products-listing-intro-wrapper-overlay" style="<?php echo esc_attr( "background-color:{$intro_bg_image_ol_color};" ); ?>"></div>
	<?php
}
