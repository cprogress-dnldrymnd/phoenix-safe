<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$the_query = isset( $settings['the_query'] ) ? $settings['the_query'] : '';
if ( $the_query->have_posts() ) :

	while ( $the_query->have_posts() ) :
		$the_query->the_post();

		$item_classes   = array();
		$item_groups    = array();
		$item_classes[] = 'portfolio-grid-item';
		$item_classes[] = 'grid-item';
		$post_terms     = get_the_terms( get_the_ID(), 'portfolio-category' );

		if ( $post_terms && ! is_wp_error( $post_terms ) ) {
			foreach ( $post_terms as $post_term ) {
				$item_groups[] = $post_term->term_id;
			}
		}

		$item_classes = join( ' ', $item_classes );
		?>
		<div class="<?php echo esc_attr( $item_classes ); ?>" data-groups="<?php echo esc_attr( wp_json_encode( $item_groups ) ); ?>">
			<?php $this->get_templates( "{$this->widget_slug}/loop/content", null, array( 'settings' => $settings ) ); ?>
		</div>
		<?php
	endwhile;

	/* Restore original Post Data */
	wp_reset_postdata();

endif;

