<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes, $product;
extract( $pgscore_shortcodes['pgscore_product_deal'] );
extract( $atts );

if ( ! is_object( $product ) ) {
	return;
}

$deal_classes = 'product-deal-wrapper woocommerce product-deal-style-' . $style;
?>
<div class="<?php echo esc_attr( $deal_classes ); ?>">
	<div class="product-deal-inner">
		<?php pgscore_get_shortcode_templates( 'product_deal/product/content' ); ?>
	</div>
</div>
