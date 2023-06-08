<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$portfolio_type = isset( $settings['portfolio_type'] ) ? $settings['portfolio_type'] : '';
?>
<div class="project-item">
	<div class="project-info">
		<div class="project-image">
			<?php
			if ( has_post_thumbnail() ) {
				$size = 'full';
				if ( 'grid' === $portfolio_type ) {
					$size = 'ciyashop-latest-post-thumbnail';
				}
				echo get_the_post_thumbnail( get_the_ID(), $size ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
			}
			?>
			<div class="portfolio-control">
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="portfolio-link"><i class="fas fa-link"></i></span></a>
				<a href="<?php the_post_thumbnail_url( 'full' ); ?>" data-elementor-open-lightbox="no" class="button popup-link image_popup-img"><i class="fas fa-expand-arrows-alt"></i></a>
			</div>
		</div>
		<div class="overlay">
			<div class="overlay-content">
				<a class="category-link" href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e( 'View Portfolio', 'pgs-core' ); ?></a>
				<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
			</div>
		</div>
	</div>
</div>
