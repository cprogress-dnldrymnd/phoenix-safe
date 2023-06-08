<?php
$style                   = isset( $settings['style'] ) ? $settings['style'] : '';
$posts_per_page          = isset( $settings['posts_per_page'] ) ? $settings['posts_per_page'] : '';
$categories              = isset( $settings['categories'] ) ? $settings['categories'] : array();
$show_prev_next_buttons  = isset( $settings['show_prev_next_buttons'] ) ? $settings['show_prev_next_buttons'] : '';
$show_pagination_control = isset( $settings['show_pagination_control'] ) ? $settings['show_pagination_control'] : '';
$owl_options_args        = array();

$args = array(
	'post_type'      => 'teams',
	'posts_per_page' => $posts_per_page,
);

if ( is_array( $categories ) && $categories ) {
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'team-category',
			'field'    => 'term_id',
			'terms'    => $categories,
		),
	);
}

$the_query = new WP_Query( $args );
if ( ! $the_query->have_posts() ) {
	return;
}

$this->add_render_attribute( 'pgscore_team_members', 'class', 'pgscore_team_member_list' );
if ( $style ) {
	$this->add_render_attribute( 'pgscore_team_members', 'class', 'pgscore_team_members_style_' . $style );
}

// Arrow
if ( 'yes' === $show_prev_next_buttons ) {
	$owl_options_args['nav'] = true;
} else {
	$owl_options_args['nav'] = false;
}

// Pagination
if ( 'yes' === $show_pagination_control ) {
	$owl_options_args['dots'] = true;
} else {
	$owl_options_args['dots'] = false;
}

$owl_options_args['items']                     = 4;
$owl_options_args['responsive'][0]['items']    = 1;
$owl_options_args['responsive'][480]['items']  = 2;
$owl_options_args['responsive'][768]['items']  = 2;
$owl_options_args['responsive'][980]['items']  = 3;
$owl_options_args['responsive'][1200]['items'] = 4;
$owl_options_args['margin']                    = 15;
$owl_options_args['loop']                      = true;
$owl_options_args['autoplay']                  = true;
$owl_options_args['autoplayHoverPause']        = true;
$owl_options_args['autoplayTimeout']           = 3100;
$owl_options_args['smartSpeed']                = 1000;

$owl_options_args['navText'] = array(
	'<i class="fas fa-angle-left fa-2x"></i>',
	'<i class="fas fa-angle-right fa-2x"></i>',
);

$owl_options = json_encode( $owl_options_args );

$this->add_render_attribute( 'pgscore_team_members_carousel', 'class', 'owl-carousel owl-theme owl-carousel-options' );
$this->add_render_attribute( 'pgscore_team_members_carousel', 'data-owl_options', $owl_options );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'pgscore_team_members' ); ?>>
		<div <?php $this->print_render_attribute_string( 'pgscore_team_members_carousel' ); ?>>
			<?php
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				global $post;
				?>
				<div class="item">
					<?php $this->get_templates( "{$this->widget_slug}/loop/{$style}", null, array( 'settings' => $settings ) ); ?>
				</div>
				<?php
			}
			/* Restore original Post Data */
			wp_reset_postdata();
			?>
		</div>
	</div>
</div>
