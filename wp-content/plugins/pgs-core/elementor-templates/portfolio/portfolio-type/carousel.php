<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$the_query         = isset( $settings['the_query'] ) ? $settings['the_query'] : '';
$portfolio_type    = isset( $settings['portfolio_type'] ) ? $settings['portfolio_type'] : '';
$portfolio_space   = isset( $settings['portfolio_space'] ) ? (int) $settings['portfolio_space'] : 0;
$carousel_items_sm = isset( $settings['carousel_items_sm'] ) ? (int) $settings['carousel_items_sm'] : 1;
$carousel_items_md = isset( $settings['carousel_items_md'] ) ? (int) $settings['carousel_items_md'] : 1;
$carousel_items_lg = isset( $settings['carousel_items_lg'] ) ? (int) $settings['carousel_items_lg'] : 2;
$carousel_items_xl = isset( $settings['carousel_items_xl'] ) ? (int) $settings['carousel_items_xl'] : 2;

$owl_options_args = array(
	'items'              => 3,
	'responsive'         => array(
		0    => array(
			'items' => 1,
		),
		576  => array(
			'items' => $carousel_items_sm,
		),
		768  => array(
			'items' => $carousel_items_md,
		),
		992  => array(
			'items' => $carousel_items_lg,
		),
		1200 => array(
			'items' => $carousel_items_xl,
		),
	),
	'margin'             => $portfolio_space,
	'dots'               => false,
	'nav'                => true,
	'loop'               => true,
	'autoplay'           => true,
	'autoplayHoverPause' => true,
	'autoplayTimeout'    => 3100,
	'smartSpeed'         => 1000,
	'navText'            => array(
		'<i class="fas fa-angle-left fa-2x"></i>',
		'<i class="fas fa-angle-right fa-2x"></i>',
	),
	'lazyLoad'           => true,
);

$owl_options = wp_json_encode( $owl_options_args );

$this->add_render_attribute( 'pgscore_portfolio_carousel', 'class', 'owl-carousel owl-theme owl-carousel-options' );
$this->add_render_attribute( 'pgscore_portfolio_carousel', 'data-owl_options', $owl_options );
?>
<div class="carousel-wrapper">
	<div <?php $this->print_render_attribute_string( 'pgscore_portfolio_carousel' ); ?>>
	<?php
	if ( $the_query->have_posts() ) :

		while ( $the_query->have_posts() ) :
			$the_query->the_post();
			?>
			<div class="item">
				<?php $this->get_templates( "{$this->widget_slug}/loop/content", null, array( 'settings' => $settings ) ); ?>
			</div>
			<?php
		endwhile;

		/* Restore original Post Data */
		wp_reset_postdata();

	endif;
	?>
	</div>
</div>
