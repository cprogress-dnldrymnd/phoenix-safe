<?php
$style          = isset( $settings['style'] ) ? $settings['style'] : '';
$categories     = isset( $settings['categories'] ) ? $settings['categories'] : '';
$posts_per_page = ( isset( $settings['posts_per_page'] ) && is_numeric( $settings['posts_per_page'] ) && $settings['posts_per_page'] ) ? $settings['posts_per_page'] : 3;

$args = array(
	'post_type'           => 'testimonials',
	'posts_per_page'      => $posts_per_page,
	'post_status'         => array( 'publish' ),
	'ignore_sticky_posts' => true,
);

if ( is_array( $categories ) && $categories ) {
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'testimonial-category',
			'field'    => 'term_id',
			'terms'    => $categories,
		),
	);
}

$the_query = new WP_Query( $args );

// bail early if no posts found
if ( ! $the_query->have_posts() ) {
	return;
}

$post_count = $the_query->found_posts;

$this->add_render_attribute( 'pgscore_testimonial', 'class', 'testimonial testimonial-' . $style );
if ( $posts_per_page > 50 ) {
	$posts_per_page = 50;
} elseif ( $posts_per_page <= 0 ) {
	return;
}

if ( $posts_per_page <= 3 || $post_count <= 3 ) {
	$this->add_render_attribute( 'pgscore_testimonial', 'class', 'testimonial-single' );
}
$settings['the_query'] = $the_query;
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'pgscore_testimonial' ); ?>>
		<?php $this->get_templates( "{$this->widget_slug}/list-style/{$style}", null, array( 'settings' => $settings ) ); ?>
	</div>
</div>
