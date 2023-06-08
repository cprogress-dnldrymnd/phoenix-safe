<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$the_query = isset( $settings['the_query'] ) ? $settings['the_query'] : '';
if ( $the_query ) {
	?>
	<div class="row">
		<?php
		if ( $the_query->have_posts() ) :

			while ( $the_query->have_posts() ) :
				$the_query->the_post();
				?>
				<div class="portfolio-grid-column-item">
					<?php $this->get_templates( "{$this->widget_slug}/loop/content", null, array( 'settings' => $settings ) ); ?>
				</div>
				<?php

			endwhile;

			/* Restore original Post Data */
			wp_reset_postdata();

		endif;
		?>
	</div>
	<?php
}
