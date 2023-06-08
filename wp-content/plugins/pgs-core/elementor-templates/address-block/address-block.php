<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$title        = isset( $settings['title'] ) ? $settings['title'] : ''; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
$icon         = isset( $settings['icon'] ) ? $settings['icon'] : '';
$shape        = isset( $settings['shape'] ) ? $settings['shape'] : '';
$style        = isset( $settings['style'] ) ? $settings['style'] : '';
$alighnment   = isset( $settings['alighnment'] ) ? $settings['alighnment'] : '';
$position     = isset( $settings['icon-position'] ) ? $settings['icon-position'] : '';
$sub_contents = isset( $settings['sub_contents'] ) ? $settings['sub_contents'] : '';

if ( ! $title && ! $sub_contents ) {
	return;
}

$this->add_render_attribute(
	array(
		'pgscore_address' => array(
			'class' => array(
				'address-block',
				$shape,
				$style,
				$position,
				'text-' . $alighnment,
				'address-block-' . ( isset( $icon['value'] ) && $icon['value'] ) ? 'with-icon' : 'without-icon',
			),
		),
	)
);
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'pgscore_address' ); ?>>
		<?php
		if ( $icon ) {
			?>
			<div class="address-block-icon">
				<?php \Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) ); ?>
			</div>
			<?php
		}
		?>
		<div class="address-block-data">
			<?php
			if ( $title ) {
				?>
				<h3 class="title"><?php echo esc_html( $title ); ?></h3>
				<?php
			}
			foreach ( $sub_contents as $sub_content ) {
				if ( $sub_content['subcontent_title'] ) {
					?>
					<span>
						<?php
						$link_attr = '';
						if ( isset( $sub_content['custom_link']['url'] ) && $sub_content['custom_link']['url'] ) {
							$target    = ( isset( $sub_content['custom_link']['is_external'] ) && $sub_content['custom_link']['is_external'] ) ? ' target="_blank"' : '';
							$nofollow  = ( isset( $sub_content['custom_link']['nofollow'] ) && $sub_content['custom_link']['nofollow'] ) ? ' rel="nofollow"' : '';
							$link_attr = 'href="' . $sub_content['custom_link']['url'] . '"' . $target . $nofollow;
						}

						if ( $link_attr ) {
							echo wp_kses( '<a ' . $link_attr . '>' . esc_html( $sub_content['subcontent_title'] ) . '</a>', pgscore_allowed_html( 'a' ) );
						} else {
							echo esc_html( $sub_content['subcontent_title'] );
						}
						?>
					</span>
					<?php
				}
			}
			?>
		</div>
	</div>
</div>
