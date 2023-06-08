<?php
global $post;

$style               = isset( $settings['style'] ) ? $settings['style'] : '';
$listing_type        = isset( $settings['carousel'] ) ? $settings['carousel'] : '';
$show_category_boxes = isset( $settings['show_category_boxes'] ) ? $settings['show_category_boxes'] : '';

if ( 'carousel' === $listing_type ) {
	$img_class = 'owl-lazy';
} else {
	$img_class = 'ciyashop-lazy-load';
}

$post_title_tag = Elementor\Utils::validate_html_tag( $settings['post_title_tag'] );
?>
<div class="latest-post-item">
	<div class="latest-post-item-inner">
		<?php
		$ciyashop_latest_post_thumbnail = 'ciyashop-latest-post-thumbnail';
		$default_thumb                  = array(
			get_parent_theme_file_uri( '/images/placeholder/recent_post/500x375.jpg' ),
			500,
			375,
		);

		if ( 'style-6' !== $style ) {
			?>
			<div class="latest-post-image">
				<?php
				if ( has_post_thumbnail() ) {
					echo get_the_post_thumbnail( $post->ID, 'ciyashop-latest-post-thumbnail' ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
				} else {
					echo '<img src="' . esc_url( $default_thumb[0] ) . '" width="' . esc_attr( $default_thumb[1] ) . '" height="' . esc_attr( $default_thumb[2] ) . '" alt="' . esc_attr( get_the_title() ) . '">';
				}
				if ( 'style-5' === $style ) {
					?>
				<div class="post-date">
					<div class="post-date-inner">
						<i class="fa fa-clock-o"></i>
						<?php echo esc_html( get_the_date( 'd F Y' ) ); ?>
					</div>
				</div>
					<?php
				}
				?>
			</div>
			<?php
		}
		?>
		<div class="latest-post-content">
			<?php
			if ( ! in_array( $style, array( 'style-7', 'style-5' ), true ) ) {
				?>
					<div class="post-date">
						<div class="post-date-inner">
						<?php
						/* translators: %1$s: Day of Month, %2$s: Month */
							printf(
								'%1$s<span>%2$s</span>',
								esc_attr( get_the_date( 'd' ) ),
								esc_html( get_the_date( 'M' ) )
							);
						?>
						</div>
					</div>
					<?php
			}
			if ( 'style-6' === $style ) {
				?>
				<div class="post-content-right">
				<?php
			}
			if ( in_array( $style, array( 'style-2', 'style-3' ), true ) ) {
				echo wp_kses(
					sprintf(
						'<%1$s class="blog-title"><a href="%3$s">%2$s</a></%1$s>',
						$post_title_tag,
						get_the_title( $post ),
						esc_url( get_permalink() )
					),
					array(
						$post_title_tag => array(
							'class' => true,
						),
						'a' => array(
							'href' => true,
						),
					)
				);
			}
			if ( 'yes' === $show_category_boxes ) {
				$categories = get_the_category();
				if ( $categories ) {
					$category_display = $categories[0]->name;
					?>
					<div class="latest-post-category">
						<span><?php echo esc_html( $category_display ); ?></span>
					</div>
					<?php
				}
			}
			?>
			<div class="latest-post-meta">
				<ul>
					<?php
					if ( 'style-7' === $style ) {
						?>
						<li class="post-date"><i class="fa fa-clock-o"></i><?php echo esc_html( get_the_date( 'd F Y' ) ); ?></li>
						<?php
					}
					if ( get_comments_number() && comments_open() ) {
						?>
						<li><?php comments_popup_link( '<i class="fa fa-comments-o"></i> 0', '<i class="fa fa-comments-o"></i> 1', '<i class="fa fa-comments-o"></i>' . wp_count_comments( get_the_ID() )->total_comments, '' ); ?></li>
						<?php
					}
					//get author image
					$author_img = get_avatar( get_the_author_meta( 'ID' ), 20 );
					?>
					<li>
						<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
						<?php
						if ( false !== $author_img ) {
							echo $author_img; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
						} else {
							?>
							<i class="fa fa fa-user"></i>
							<?php
						}
						echo esc_html( get_the_author() );
						?>
						</a>
					</li>
					<?php
					if ( 'yes' !== $show_category_boxes ) {
						$categories_list = get_the_category_list( ', ' );
						if ( $categories_list && ( function_exists( 'ciyashop_categorized_blog' ) && ciyashop_categorized_blog() ) ) {
							?>
							<li>
								<?php
								/* translators: %1$s: Categories List */
								printf(
									'<i class="fa fa-folder-open"></i> %1$s',
									$categories_list // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								);
								?>
							</li>
							<?php
						}
					}
					?>
				</ul>
			</div>
			<?php
			if ( ! in_array( $style, array( 'style-2', 'style-3' ), true ) ) {
				echo wp_kses(
					sprintf(
						'<%1$s class="blog-title"><a href="%3$s">%2$s</a></%1$s>',
						$post_title_tag,
						get_the_title( $post ),
						esc_url( get_permalink() )
					),
					array(
						$post_title_tag => array(
							'class' => true,
						),
						'a' => array(
							'href' => true,
						),
					)
				);
			}

			$excerpt = get_the_excerpt();
			$excerpt = pgscore_shortenString( $excerpt, 80, true, true );
			?>
			<div class="latest-post-excerpt"><p><?php echo esc_html( $excerpt ); ?></p></div>
			<div class="latest-post-entry-footer">
				<a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo in_array( $style, array( 'style-1', 'style-2', 'style-3' ), true ) ? esc_html__( 'Read More...', 'pgs-core' ) : esc_html__( 'Read More', 'pgs-core' ); ?></a>
			</div>
			<?php
			if ( 'style-6' === $style ) {
				?>
			</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
