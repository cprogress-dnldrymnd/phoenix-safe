<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$this->add_render_attribute( 'pgscore_banner_btn_wrap', 'class', 'pgscore_banner-btn-wrap' );
$this->add_render_attribute( 'pgscore_banner_btn_wrap', 'class', 'pgscore_banner-btn-style-' . $settings['button_style'] );

if ( 'link' !== $settings['button_style'] ) {
	$this->add_render_attribute( 'pgscore_banner_btn_wrap', 'class', 'pgscore_banner-btn-size-' . $settings['button_size'] );
}

$this->add_render_attribute( 'pgscore_banner_btn', 'class', 'pgscore_banner-btn' );
$this->add_link_attributes( 'pgscore_banner_btn', $settings['link_url'] );
if ( isset( $settings['link_url']['is_external'] ) && 'on' === (string) $settings['link_url']['is_external'] ) {
	$this->add_render_attribute( 'pgscore_banner_btn', 'rel', 'noreferrer' );
	$this->add_render_attribute( 'pgscore_banner_btn', 'rel', 'noopener' );
}
if ( $settings['hover_animation'] ) {
	$this->add_render_attribute( 'pgscore_banner_btn', 'class', 'elementor-animation-' . $settings['hover_animation'] );
}
?>
<div <?php $this->print_render_attribute_string( 'pgscore_banner_btn_wrap' ); ?>>
	<a <?php $this->print_render_attribute_string( 'pgscore_banner_btn' ); ?>><?php echo esc_html( $settings['button_text'] ); ?></a>
</div>
