<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$link_attr            = '';
$icon                 = isset( $settings['icon'] ) ? $settings['icon'] : '';
$button_width         = isset( $settings['button_width'] ) ? $settings['button_width'] : '';
$button_title         = isset( $settings['button_title'] ) ? $settings['button_title'] : '';
$button_icon          = isset( $settings['button_icon'] ) ? $settings['button_icon'] : '';
$button_size          = isset( $settings['button_size'] ) ? $settings['button_size'] : '';
$button_icon_position = isset( $settings['button_icon_position'] ) ? $settings['button_icon_position'] : '';
$button_border        = isset( $settings['button_border'] ) ? $settings['button_border'] : '';
$button_type          = isset( $settings['button_type'] ) ? $settings['button_type'] : '';
$button_underline     = isset( $settings['button_underline'] ) ? $settings['button_underline'] : '';

if ( isset( $settings['button_link']['url'] ) && $settings['button_link']['url'] ) {
	$target    = ( isset( $settings['button_link']['is_external'] ) && $settings['button_link']['is_external'] ) ? ' target="_blank"' : '';
	$nofollow  = ( isset( $settings['button_link']['nofollow'] ) && $settings['button_link']['nofollow'] ) ? ' rel="nofollow"' : '';
	$link_attr = 'href="' . $settings['button_link']['url'] . '"' . $target . $nofollow;
}

if ( $button_width ) {
	$this->add_render_attribute( 'widget_wrapper', 'class', 'pgscore_button_width_' . $button_width );
}

if ( $button_size ) {
	$this->add_render_attribute( 'pgscore_button', 'class', 'pgscore_button_size_' . $button_size );
}

if ( 'true' === $button_icon ) {
	$this->add_render_attribute( 'pgscore_button', 'class', 'button-icon' );
	$this->add_render_attribute( 'pgscore_button', 'class', 'button-icon-position-' . $button_icon_position );
}

if ( $button_type ) {
	if ( 'link' !== $button_type ) {
		$this->add_render_attribute( 'pgscore_button', 'class', 'pgscore_button_border_' . $button_border );
	}
	$this->add_render_attribute( 'pgscore_button', 'class', 'pgscore_button_' . $button_type );
}

if ( 'link' === $button_type ) {
	if ( 'true' === $button_underline ) {
		$this->add_render_attribute( 'pgscore_button', 'class', 'button-underline' );
	}
}

if ( $button_title && $link_attr ) {
	?>
	<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
		<div <?php $this->print_render_attribute_string( 'pgscore_button' ); ?>>
			<a class="inline_hover" <?php echo $link_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php
			if ( $button_icon ) {
				if ( 'left' === $button_icon_position ) {
					\Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) );
				}
			}
			?>
			<?php echo esc_html( $button_title ); ?>
			<?php
			if ( $button_icon ) {
				if ( 'right' === $button_icon_position ) {
					\Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) );
				}
			}
			?>
			</a>
		</div>
	</div>
	<?php
}
