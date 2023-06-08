<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$tabs_data             = isset( $settings['tabs_data'] ) ? $settings['tabs_data'] : '';
$enable_intro          = isset( $settings['enable_intro'] ) ? $settings['enable_intro'] : '';
$tabs_position         = isset( $settings['tabs_position'] ) ? $settings['tabs_position'] : '';
$tabs_alignment        = isset( $settings['tabs_alignment'] ) ? $settings['tabs_alignment'] : '';
$top_tabs_style        = isset( $settings['top_tabs_style'] ) ? $settings['top_tabs_style'] : '';
$tab_link_active_color = isset( $settings['tab_link_active_color'] ) ? $settings['tab_link_active_color'] : '';
$tab_link_color        = isset( $settings['tab_link_color'] ) ? $settings['tab_link_color'] : '';

$this->add_render_attribute( 'pgscore_mtpl_tabs_classes', 'class', 'nav mtpl-tabs' );
if ( 'intro' === $tabs_position ) {
	$this->add_render_attribute( 'pgscore_mtpl_tabs_classes', 'class', 'flex-column' );
} else {

	$this->add_render_attribute(
		array(
			'pgscore_mtpl_tabs_classes' => array(
				'class' => array(
					'mtpl-tabs--tabs_position-' . $tabs_position,
					'mtpl-tabs--tabs_alignment-' . $tabs_alignment,
					'mtpl-tabs--tabs_style-' . $top_tabs_style,
				),
			),
		)
	);

	if ( 'center' === $tabs_alignment ) {
		$this->add_render_attribute( 'pgscore_mtpl_tabs_classes', 'class', 'justify-content-center' );
	} elseif ( 'right' === $tabs_alignment ) {
		$this->add_render_attribute( 'pgscore_mtpl_tabs_classes', 'class', 'justify-content-end' );
	}
}
?>
<ul <?php $this->print_render_attribute_string( 'pgscore_mtpl_tabs_classes' ); ?>>
	<?php
	$tab_nav_sr = 1;
	foreach ( $tabs_data as $tab_item ) {

		$tab_link = '#mtpl-' . $this->get_id() . '-tab-' . $tab_item['tab_slug'];
		$arrow_id = 'mtpl-' . $this->get_id() . '-arrow-' . $tab_item['tab_slug'];

		$mtpl_tab_link_classes = array(
			'nav-link',
			'mtpl-tab-link',
		);

		if ( 'true' === $enable_intro && 'intro' === $tabs_position ) {
			$mtpl_tab_link_classes[] = 'mtpl-intro-tab-link';
		}

		$tab_item_active = '';
		if ( 1 === $tab_nav_sr ) {
			$mtpl_tab_link_classes[] = 'active';
		}

		$mtpl_tab_link_classes = implode( ' ', $mtpl_tab_link_classes );
		?>
		<li class="nav-item mtpl-tab">
			<a class="<?php echo esc_attr( $mtpl_tab_link_classes ); ?>" href="<?php echo esc_url( $tab_link ); ?>" data-toggle="tab" data-arrow_target="<?php echo esc_attr( $arrow_id ); ?>">
				<?php echo esc_html( $tab_item['tab_name'] ); ?>
			</a>
		</li>
		<?php
		$tab_nav_sr++;
	}
	?>
</ul>
