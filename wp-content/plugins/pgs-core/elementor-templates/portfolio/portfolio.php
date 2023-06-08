<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$style              = isset( $settings['style'] ) ? $settings['style'] : 'style-1';
$portfolio_space    = isset( $settings['portfolio_space'] ) ? $settings['portfolio_space'] : 10;
$portfolio_type     = isset( $settings['portfolio_type'] ) ? $settings['portfolio_type'] : '';
$portfolio_column   = isset( $settings['portfolio_column'] ) ? $settings['portfolio_column'] : 3;
$categories         = isset( $settings['categories'] ) ? $settings['categories'] : '';
$sort_by            = isset( $settings['sort_by'] ) ? $settings['sort_by'] : 'ASC';
$oredr_by           = isset( $settings['oredr_by'] ) ? $settings['oredr_by'] : 'publish_date';
$portfolio_per_page = isset( $settings['portfolio_per_page'] ) ? (int) $settings['portfolio_per_page'] : 20;

$args = array(
	'post_type'           => 'portfolio',
	'posts_per_page'      => $portfolio_per_page,
	'orderby'             => $oredr_by,
	'order'               => $sort_by,
	'post_status'         => array( 'publish' ),
	'ignore_sticky_posts' => true,
);

if ( $categories && is_array( $categories ) ) {
	$args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery
		array(
			'taxonomy' => 'portfolio-category',
			'field'    => 'term_id',
			'terms'    => $categories,
		),
	);
}

$the_query = new WP_Query( $args );

if ( ! $the_query->have_posts() ) {
	return;
}

$settings['the_query'] = $the_query;

$this->add_render_attribute(
	array(
		'pgscore_portfolio' => array(
			'class' => array(
				'portfolio-' . $style,
				'portfolio-content-area image_popup-gallery',
				'portfolio-space-' . $portfolio_space,
			),
		),
	)
);

$this->add_render_attribute( 'pgscore_portfolio_section', 'class', 'portfolio-section' );
if ( 'isotope' === $portfolio_type ) {
	$this->add_render_attribute( 'pgscore_portfolio', 'class', 'isotope' );
	$this->add_render_attribute( 'pgscore_portfolio_section', 'class', 'isotope-wrapper' );
}

if ( 'isotope' === $portfolio_type || 'grid' === $portfolio_type ) {
	$this->add_render_attribute( 'pgscore_portfolio', 'class', 'column-' . $portfolio_column );
}

$filter_args = array(
	'taxonomy' => 'portfolio-category',
	'fields'   => 'id=>name',
);

if ( $categories ) {
	$filter_args['include'] = $categories;
}

$filter_terms = get_terms( $filter_args );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'pgscore_portfolio_section' ); ?>>
		<?php
		if ( 'isotope' === $portfolio_type && ! is_wp_error( $filter_terms ) && is_array( $filter_terms ) && $filter_terms ) {
			?>
			<div class="row no-gutter">
				<div class="col-sm-12">
					<div class="isotope-filters">
						<button data-filter="" class="all active"><?php echo esc_html__( 'All', 'pgs-core' ); ?></button>
						<?php
						foreach ( $filter_terms as $filter_key => $filter_name ) {
							?>
							<button data-filter="<?php echo esc_attr( $filter_key ); ?>"><?php echo esc_html( $filter_name ); ?></button>
							<?php
						}
						?>
					</div>
				</div>
			</div>
			<?php
		}
		?>
		<div <?php $this->print_render_attribute_string( 'pgscore_portfolio' ); ?>>
			<?php $this->get_templates( "{$this->widget_slug}/portfolio-type/{$portfolio_type}", null, array( 'settings' => $settings ) ); ?>
		</div>
	</div>
</div>

