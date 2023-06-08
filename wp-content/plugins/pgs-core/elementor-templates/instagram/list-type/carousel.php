<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$carousel_arrow      = ( isset( $settings['carousel_arrow'] ) && 'true' === $settings['carousel_arrow'] ) ? true : false;
$carousel_pagination = ( isset( $settings['carousel_pagination'] ) && 'true' === $settings['carousel_pagination'] ) ? true : false;
$carousel_items_xl   = isset( $settings['carousel_items_xl'] ) ? (int) $settings['carousel_items_xl'] : 5;
$carousel_items_lg   = isset( $settings['carousel_items_lg'] ) ? (int) $settings['carousel_items_lg'] : 4;
$carousel_items_md   = isset( $settings['carousel_items_md'] ) ? (int) $settings['carousel_items_md'] : 3;
$carousel_items_sm   = isset( $settings['carousel_items_sm'] ) ? (int) $settings['carousel_items_sm'] : 2;
$carousel_gapping    = isset( $settings['carousel_gapping'] ) ? (int) $settings['carousel_gapping'] : 0;
$image_size          = isset( $settings['image_size'] ) ? $settings['image_size'] : '';

$owl_options_args = array(
	'nav'        => $carousel_arrow,
	'dots'       => $carousel_pagination,
	'loop'       => true,
	'items'      => $carousel_items_xl,
	'smartSpeed' => 1000,
	'responsive' => array(
		1200 => array(
			'items' => $carousel_items_xl,
		),
		992  => array(
			'items' => $carousel_items_lg,
		),
		768  => array(
			'items' => $carousel_items_md,
		),
		576  => array(
			'items' => $carousel_items_sm,
		),
		320  => array(
			'items' => 2,
		),
		0    => array(
			'items' => 1,
		),
	),
	'navText'    => array(
		"<i class='fas fa-angle-left fa-2x'></i>",
		"<i class='fas fa-angle-right fa-2x'></i>",
	),
	'margin'     => $carousel_gapping,
);

$owl_options = wp_json_encode( $owl_options_args );

$this->add_render_attribute( 'pgscore_instagram_carousel', 'class', 'insta_v3_items insta_v3_style--without_meta owl-carousel owl-theme owl-carousel-options' );
$this->add_render_attribute( 'pgscore_instagram_carousel', 'data-owl_options', $owl_options );
?>
<div <?php $this->print_render_attribute_string( 'pgscore_instagram_carousel' ); ?>>
	<?php
	if ( isset( $settings['images'] ) && $settings['images'] ) {
		foreach ( $settings['images'] as $image ) {
			if ( 'small' === $image_size ) {
				$image_url = $image->images->low_resolution->url;
			} elseif ( 'large' === $image_size ) {
				$image_url = $image->images->standard_resolution->url;
			} else {
				$image_url = $image->images->thumbnail->url;
			}
			?>
			<div class="insta_v3_item">
				<a href="<?php echo esc_url( $image->link ); ?>" class="insta_v3_item--link" target="_blank">
					<div class="insta_v3_item--content">
						<?php echo '<img class="insta_v3_item--img img-responsive" src="' . esc_url( $image_url ) . '" alt="' . esc_attr__( 'Instagram Image', 'pgs-core' ) . '">'; ?>
					</div>
				</a>
			</div>
			<?php
		}
	}
	?>
</div>
