<?php
$loop              = isset( $settings['loop'] ) ? $settings['loop'] : '';
$enable_intro      = isset( $settings['enable_intro'] ) ? $settings['enable_intro'] : '';
$carousel_items_sm = isset( $settings['carousel_items_sm'] ) ? $settings['carousel_items_sm'] : 1;
$carousel_items_md = isset( $settings['carousel_items_md'] ) ? $settings['carousel_items_md'] : 1;
$carousel_items_lg = isset( $settings['carousel_items_lg'] ) ? $settings['carousel_items_lg'] : 2;
$carousel_items_xl = isset( $settings['carousel_items_xl'] ) ? $settings['carousel_items_xl'] : 2;
$carousel_margin   = isset( $settings['carousel_margin'] ) ? $settings['carousel_margin'] : 15;

$owl_options_args = array(
	'items'              => 3,
	'responsive'         => array(
		0    => array(
			'items' => 1,
		),
		576  => array(
			'items' => (int) $carousel_items_sm,
		),
		768  => array(
			'items' => (int) $carousel_items_md,
		),
		992  => array(
			'items' => (int) $carousel_items_lg,
		),
		1200 => array(
			'items' => (int) $carousel_items_xl,
		),
	),
	'margin'             => (int) $carousel_margin,
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
);

if ( 'yes' === $enable_intro ) {
	$owl_options_args['navContainer'] = ".latest-post-control.latest-post-control-{$this->get_id()} .latest-post-nav";
}
$owl_options = json_encode( $owl_options_args );

$this->add_render_attribute( 'pgscore_recent_posts_carousel', 'class', 'owl-carousel owl-theme owl-carousel-options' );
$this->add_render_attribute( 'pgscore_recent_posts_carousel', 'data-owl_options', $owl_options );
?>
<div class="carousel-wrapper">
	<div <?php $this->print_render_attribute_string( 'pgscore_recent_posts_carousel' ); ?>>
		<?php
		while ( $loop->have_posts() ) {
			$loop->the_post();
			?>
			<div class="item">
				<?php $this->get_templates( "{$this->widget_slug}/loop/content", null, array( 'settings' => $settings ) ); ?>
			</div>
			<?php
		}
		/* Restore original Post Data */
		wp_reset_postdata();
		?>
	</div>
</div>
