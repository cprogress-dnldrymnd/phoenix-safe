<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$icon                 = isset( $settings['icon'] ) ? $settings['icon'] : '';
$icon_image           = isset( $settings['icon_image'] ) ? $settings['icon_image'] : '';
$counter_title        = isset( $settings['counter_title'] ) ? $settings['counter_title'] : '';
$counter_icon_size    = isset( $settings['counter_icon_size'] ) ? $settings['counter_icon_size'] : '';
$counter_alighnment   = isset( $settings['counter_alighnment'] ) ? $settings['counter_alighnment'] : '';
$counter_number       = isset( $settings['counter_number'] ) ? $settings['counter_number'] : '';
$counter_icon_disable = isset( $settings['counter_icon_disable'] ) ? $settings['counter_icon_disable'] : '';
$counter_icon_source  = isset( $settings['counter_icon_source'] ) ? $settings['counter_icon_source'] : '';

$this->add_render_attribute(
	array(
		'pgscore_counter' => array(
			'class' => array(
				'pgscore-counter',
				'pgscore-counter-style-3',
				'alignment-' . $counter_alighnment,
			),
		),
	)
);
?>
<div <?php $this->print_render_attribute_string( 'pgscore_counter' ); ?>>
	<?php
	if ( 'true' !== $counter_icon_disable ) {

		$this->add_render_attribute( 'pgs_counter_icon', 'class', 'pgscore-counter-icon pgscore-icon-' . $counter_icon_source );
		if ( 'font' === $counter_icon_source ) {
			$this->add_render_attribute( 'pgs_counter_icon', 'class', 'pgscore-size-' . $counter_icon_size );
			?>
			<div <?php $this->print_render_attribute_string( 'pgs_counter_icon' ); ?>>
				<?php \Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) ); ?>
			</div>
			<?php
		} elseif ( 'image' === $counter_icon_source && $icon_image ) {
			?>
			<div <?php $this->print_render_attribute_string( 'pgs_counter_icon' ); ?>>
				<?php
				if ( isset( $icon_image['id'] ) && $icon_image['id'] ) {
					$icon_image_data = wp_get_attachment_image_src( $icon_image['id'], 'pgscore-thumbnail-80' );
					echo '<img src="' . esc_url( $icon_image_data[0] ) . '">';
				}
				?>
			</div>
			<?php
		}
	}
	?>
	<div class="pgscore-counter-number">
		<span class="counter-number"><?php echo esc_attr( $counter_number ); ?></span>
	</div>
	<div class="pgscore-counter-divider">
		<span></span>
	</div>
	<div class="pgscore-counter-title">
		<span class="counter-title"><?php echo esc_attr( $counter_title ); ?></span>
	</div>
</div>
