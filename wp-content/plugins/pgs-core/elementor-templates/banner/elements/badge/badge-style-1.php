<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$this->add_render_attribute( 'pgscore_banner_badge_wrap', 'class', 'pgscore_banner-badge-wrap' );
$this->add_render_attribute( 'pgscore_banner_badge_inner_wrap', 'class', 'pgscore_banner-badge-inner-wrap' );
$this->add_render_attribute(
	'pgscore_banner_badge',
	'class',
	array(
		'pgscore_banner-badge',
		'pgscore_banner-badge_style-' . $settings['badge_style'],
		'pgscore_banner-badge_type-' . $settings['badge_type'],
		'pgscore_banner-badge_align-' . $settings['badge_vertical_align'],
		'pgscore_banner-badge_align-' . $settings['badge_horizontal_align'],
	)
);
$this->add_render_attribute( 'pgscore_banner_badge_inner', 'class', 'pgscore_banner-badge-inner' );
$this->add_render_attribute( 'pgscore_banner_badge_text', 'class', 'pgscore_banner-badge-text' );
?>
<div <?php $this->print_render_attribute_string( 'pgscore_banner_badge_wrap' ); ?>>
	<div <?php $this->print_render_attribute_string( 'pgscore_banner_badge_inner_wrap' ); ?>>
		<div <?php $this->print_render_attribute_string( 'pgscore_banner_badge' ); ?>>
			<div <?php $this->print_render_attribute_string( 'pgscore_banner_badge_inner' ); ?>>
				<span <?php $this->print_render_attribute_string( 'pgscore_banner_badge_text' ); ?>><?php echo esc_html( $settings['badge_title'] ); ?></span>
			</div>
		</div>
	</div>
</div>
