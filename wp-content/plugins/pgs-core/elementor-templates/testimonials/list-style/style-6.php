<?php
$the_query              = isset( $settings['the_query'] ) ? $settings['the_query'] : '';
$show_prev_next_buttons = isset( $settings['show_prev_next_buttons'] ) ? $settings['show_prev_next_buttons'] : '';
$enable_infinity_loop   = isset( $settings['enable_infinity_loop'] ) ? $settings['enable_infinity_loop'] : '';
$slides_per_view        = isset( $settings['slides_per_view'] ) ? $settings['slides_per_view'] : '';
$slides_per_view_xs     = isset( $settings['slides_per_view_xs'] ) ? $settings['slides_per_view_xs'] : '';
$slides_per_view_sm     = isset( $settings['slides_per_view_sm'] ) ? $settings['slides_per_view_sm'] : '';
$slides_per_view_md     = isset( $settings['slides_per_view_md'] ) ? $settings['slides_per_view_md'] : '';
$carousel_speed         = isset( $settings['carousel_speed'] ) ? $settings['carousel_speed'] : '';
$slide_margin           = isset( $settings['slide_margin'] ) ? $settings['slide_margin'] : '';

if ( 'yes' === $enable_infinity_loop ) {
	$enable_infinity_loop = true;
} else {
	$enable_infinity_loop = false;
}

$arrow_id = 'testimonials-arrow-' . $this->get_id();

$owl_options_args = array(
	'items'              => (int) $slides_per_view,
	'loop'               => $enable_infinity_loop,
	'margin'             => (int) $slide_margin,
	'autoplay'           => true,
	'autoplayTimeout'    => (int) $carousel_speed,
	'autoplayHoverPause' => true,
	'dots'               => false,
	'nav'                => true,
	'smartSpeed'         => 1000,
	'navText'            => array(
		'<i class="fas fa-angle-left fa-2x"></i>',
		'<i class="fas fa-angle-right fa-2x"></i>',
	),
	'responsive'         => array(
		0    => array(
			'items' => 1,
		),
		480  => array(
			'items' => (int) $slides_per_view_xs,
		),
		768  => array(
			'items' => (int) $slides_per_view_sm,
		),
		992  => array(
			'items' => (int) $slides_per_view_md,
		),
		1200 => array(
			'items' => (int) $slides_per_view,
		),
	),
	'navContainer'       => "#{$arrow_id}",
);

$owl_options = json_encode( $owl_options_args );

$this->add_render_attribute( 'pgscore_testimonial_list', 'class', 'testimonial testimonial-style-6 owl-carousel owl-theme owl-carousel-options' );
$this->add_render_attribute( 'pgscore_testimonial_list', 'data-owl_options', $owl_options );
?>
<div <?php $this->print_render_attribute_string( 'pgscore_testimonial_list' ); ?>>
	<?php
	while ( $the_query->have_posts() ) {
		$the_query->the_post();

		$testimonials_img_src = '';
		$author               = get_post_meta( get_the_ID(), 'author', true );
		$content              = get_post_meta( get_the_ID(), 'content', true );
		$designation          = get_post_meta( get_the_ID(), 'designation', true );
		$testimonials_img_alt = ( $author ) ? $author : esc_html__( 'Author', 'pgs-core' );

		if ( has_post_thumbnail() ) {
			$testimonials_thumbnail_id = get_post_thumbnail_id();
			$testimonials_img_data     = wp_get_attachment_image_src( $testimonials_thumbnail_id, 'thumbnail' );

			if ( isset( $testimonials_img_data[0] ) ) {
				$testimonials_img_src = $testimonials_img_data[0];
			}
		}
		if ( $content ) {
			?>
			<div class="testimonial-information">
				<div class="testimonial-content">
					<i class="fas fa-quote-left"></i>
					<p><?php echo wp_kses( $content, array( 'p' => true ) ); ?></p>
				</div>
				<div class="testimonial-meta">
					<div class="client-info">
						<?php
						if ( $author ) {
							?>
							<h5 class="author-name">- <?php echo esc_html( $author ); ?></h5>
							<?php
						}
						if ( $designation ) {
							?>
							<span><?php echo esc_html( $designation ); ?></span>
							<?php
						}
						?>
					</div>
				</div>
			</div>
			<?php
		}
	}
	/* Restore original Post Data */
	wp_reset_postdata();
	?>
</div>
<?php
if ( 'yes' === $show_prev_next_buttons ) {
	?>
	<div id="<?php echo esc_attr( $arrow_id ); ?>" class="testimonials-carousel-nav"></div>
	<?php
}
