<?php
$style                   = isset( $settings['style'] ) ? $settings['style'] : '';
$enable_intro            = isset( $settings['enable_intro'] ) ? $settings['enable_intro'] : '';
$listing_type            = isset( $settings['listing_type'] ) ? $settings['listing_type'] : '';
$intro_position          = isset( $settings['intro_position'] ) ? $settings['intro_position'] : '';
$intro_content_alignment = isset( $settings['intro_content_alignment'] ) ? $settings['intro_content_alignment'] : '';
$enable_intro_link       = isset( $settings['enable_intro_link'] ) ? $settings['enable_intro_link'] : '';
$intro_link_position     = isset( $settings['intro_link_position'] ) ? $settings['intro_link_position'] : '';
$link_title              = isset( $settings['link_title'] ) ? $settings['link_title'] : '';
$intro_link_alignment    = isset( $settings['intro_link_alignment'] ) ? $settings['intro_link_alignment'] : '';
$categories              = isset( $settings['categories'] ) ? $settings['categories'] : array();
$posts_per_page          = isset( $settings['posts_per_page'] ) ? $settings['posts_per_page'] : '';

$args = array(
	'post_type'           => 'post',
	'post_status'         => array( 'publish' ),
	'posts_per_page'      => $posts_per_page,
	'ignore_sticky_posts' => true,
);

if ( is_array( $categories ) && $categories ) {
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'category',
			'field'    => 'slug',
			'terms'    => $categories,
		),
	);
}

$loop = new WP_Query( $args );

// Return if no posts found.
if ( ! $loop->have_posts() ) {
	return;
}

$this->add_render_attribute(
	[
		'pgscore_recent_posts' => [
			'class' => [
				'latest-post-wrapper',
				'latest-post-type-' . $listing_type,
				'latest-post-' . $style,
				'latest-post-' . ( 'yes' === $enable_intro ? 'with-intro' : 'without-intro' ),
			],
		],
	]
);
$this->add_render_attribute( 'pgscore_recent_posts', 'data-intro', ( 'yes' === $enable_intro ? 'yes' : 'no' ) );

$link_attr = false;

// Link Attributes
if ( 'yes' === $enable_intro_link ) {
	$target   = ( isset( $settings['intro_link']['is_external'] ) && $settings['intro_link']['is_external'] ) ? ' target="_blank"' : '';
	$nofollow = ( isset( $settings['intro_link']['nofollow'] ) && $settings['intro_link']['nofollow'] ) ? ' rel="nofollow"' : '';
	if ( $settings['intro_link']['url'] ) {
		$link_attr = 'href="' . $settings['intro_link']['url'] . '"' . $target . $nofollow;
	}
}

$settings['link_attr'] = $link_attr;
$settings['loop']      = $loop;
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'pgscore_recent_posts' ); ?>>
		<div class="latest-post-inner">
			<div class="row<?php echo ( ( 'yes' === $enable_intro ) ? ' no-gutters' : '' ); ?>">
				<?php
				if ( 'yes' === $enable_intro ) {

					// Check intro position
					if ( 'right' === $intro_position ) {
						$this->add_render_attribute( 'pgscore_recent_posts_intro_column_classes', 'class', 'col-xs-12 col-sm-12 col-md-4 col-lg-3 order-md-2 order-lg-2' );
						$this->add_render_attribute( 'pgscore_recent_posts_item_column_classes', 'class', 'col-xs-12 col-sm-12 col-md-8 col-lg-9 order-md-1 order-lg-1' );
					} else {
						$this->add_render_attribute( 'pgscore_recent_posts_intro_column_classes', 'class', 'col-xs-12 col-sm-12 col-md-4 col-lg-3' );
						$this->add_render_attribute( 'pgscore_recent_posts_item_column_classes', 'class', 'col-xs-12 col-sm-12 col-md-8 col-lg-9' );
					}

					$this->add_render_attribute( 'pgscore_recent_posts_intro_classes', 'class', 'latest-post-intro-wrapper latest-post-intro-content-alignment-' . $intro_content_alignment );
					?>
					<div <?php $this->print_render_attribute_string( 'pgscore_recent_posts_intro_column_classes' ); ?>>
						<div <?php $this->print_render_attribute_string( 'pgscore_recent_posts_intro_classes' ); ?>>
							<div class="latest-post-intro-wrapper-overlay"></div>
							<?php
							$this->get_templates( "{$this->widget_slug}/content-parts/title", null, array( 'settings' => $settings ) );
							$this->get_templates( "{$this->widget_slug}/content-parts/description", null, array( 'settings' => $settings ) );

							if ( 'yes' === $enable_intro_link && ( 'grid' === $listing_type || ( 'carousel' === $listing_type && 'with_controls' !== $intro_link_position ) ) && ( $link_title && $link_attr ) ) {
								$this->get_templates( "{$this->widget_slug}/content-parts/link", null, array( 'settings' => $settings ) );
							}

							if ( 'carousel' === $listing_type ) {
								$this->add_render_attribute( 'pgscore_recent_posts_item_controls_classes', 'class', 'latest-post-control latest-post-control-' . $this->get_id() );
								if ( 'yes' === $enable_intro_link && 'with_controls' === $intro_link_position ) {
									$this->add_render_attribute( 'pgscore_recent_posts_item_controls_classes', 'class', 'latest-post-control-link-alignment-' . $intro_link_alignment );
								}
								?>
								<div <?php $this->print_render_attribute_string( 'pgscore_recent_posts_item_controls_classes' ); ?>>
									<?php
									if ( 'yes' === $enable_intro_link && 'with_controls' === $intro_link_position && ( $link_title && $link_attr ) ) {
										$this->get_templates( "{$this->widget_slug}/content-parts/link", null, array( 'settings' => $settings ) );
									}
									?>
									<div class="latest-post-nav"></div>
								</div>
								<?php
							}
							?>
						</div>
					</div>
					<?php
				} else {
					$this->add_render_attribute( 'pgscore_recent_posts_item_column_classes', 'class', 'col-xs-12 col-sm-12 col-md-12' );
				}
				?>
				<div <?php $this->print_render_attribute_string( 'pgscore_recent_posts_item_column_classes' ); ?>>
					<div class="latest-post-main">
						<div class="latest-post-main-inner">
							<div class="latest-post-content">
								<div class="latest-post-content-inner">
									<?php $this->get_templates( "{$this->widget_slug}/list-style/" . $listing_type, null, array( 'settings' => $settings ) ); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
