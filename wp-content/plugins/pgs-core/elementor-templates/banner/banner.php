<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$banner_classes      = array();
$banner_options_data = array();
$banner_padding_data = array();
$banner_image        = array();
$el_id               = $this->get_id();

if (
	( isset( $settings['bg_img_source'] ) && 'external_link' === $settings['bg_img_source'] )
	&& ( isset( $settings['bg_img_link'] ) && isset( $settings['bg_img_link']['url'] ) && $settings['bg_img_link']['url'] )
) {
	$banner_image[0] = $settings['bg_img_link']['url'];
	$banner_image[1] = '';
	$banner_image[2] = '';
} elseif (
	( ! isset( $settings['bg_img_source'] ) || ! $settings['bg_img_source'] || ( isset( $settings['bg_img_source'] ) && 'media_library' === $settings['bg_img_source'] ) )
	&& ( isset( $settings['bg_img'] ) && isset( $settings['bg_img']['id'] ) && $settings['bg_img']['id'] )
) {
	/* banner image is empty then return  */
	$banner_image = wp_get_attachment_image_src( $settings['bg_img']['id'], 'full' );
}

if ( empty( $banner_image ) ) {
	if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
		?>
		<div class="alert alert-danger" role="alert" style="margin: 0;">
			<h4 class="alert-heading"><?php esc_html_e( 'Important Note', 'pgs-core' ); ?></h4>
			<p><?php esc_html_e( 'If "Banner Image" is not set, the widget content will not be rendered. Please select an image or enter image URL to display widget content.', 'pgs-core' ); ?></p>
		</div>
		<?php
	}
	return;
}

// Banner Classes.
$this->add_render_attribute( 'pgscore_banner', 'class', 'pgscore_banner' );
$this->add_render_attribute( 'pgscore_banner', 'class', 'pgscore_banner-style-' . ( ( isset( $settings['style'] ) && $settings['style'] ) ? $settings['style'] : 'style-1' ) );
$this->add_render_attribute( 'pgscore_banner', 'class', 'pgscore_banner-effect-' . ( ( isset( $settings['banner_effect'] ) && $settings['banner_effect'] ) ? $settings['banner_effect'] : 'none' ) );

$banner_options_data['font_size_responsive'] = true;
$banner_options                              = '{}';

// Banner - Background Image.
if ( ! empty( $banner_image ) ) {
	$this->add_render_attribute( 'pgscore_banner', 'style', 'background-image: url("' . esc_url( $banner_image[0] ) . '");' );
}

$this->add_render_attribute( 'pgscore_banner', 'data-banner_options', $banner_options );

$this->add_render_attribute( 'pgs_banner_content', 'class', 'pgscore_banner-content' );
if ( 'deal-2' === $settings['style'] ) {
	$this->add_render_attribute( 'pgs_banner_content', 'class', 'pgscore_banner-content-hleft' );
	$this->add_render_attribute( 'pgs_banner_content', 'class', 'pgscore_banner-content-vtop' );
} else {
	$this->add_render_attribute( 'pgs_banner_content', 'class', 'pgscore_banner-content-' . ( ( isset( $settings['horizontal_align'] ) && $settings['horizontal_align'] ) ? $settings['horizontal_align'] : 'hleft' ) );
	$this->add_render_attribute( 'pgs_banner_content', 'class', 'pgscore_banner-content-' . ( ( isset( $settings['vertical_align'] ) && $settings['vertical_align'] ) ? $settings['vertical_align'] : 'vtop' ) );
}

$banner_padding_options                           = '{}';
$banner_padding_data['banner_padding_responsive'] = true;
if ( is_array( $banner_padding_data ) && $banner_padding_data ) {
	$banner_padding_options = wp_json_encode( $banner_padding_data );
}
$this->add_render_attribute( 'pgs_banner_content', 'data-banner_padding_options', $banner_padding_options );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<?php
	if ( $this->is_banner_link_enabled() ) {
		$this->add_link_attributes( 'pgs_banner_link', $settings['banner_link_url'] );
		$this->add_render_attribute( 'pgs_banner_link', 'class', 'pgs_banner-link' );
		$this->add_render_attribute( 'pgs_banner_link', 'rel', 'alternate' );
		if ( isset( $settings['banner_link_url']['is_external'] ) && 1 === (int) $settings['banner_link_url']['is_external'] ) {
			$this->add_render_attribute( 'pgs_banner_link', 'rel', 'noreferrer' );
			$this->add_render_attribute( 'pgs_banner_link', 'rel', 'noopener' );
		}
		?>
		<a <?php $this->print_render_attribute_string( 'pgs_banner_link' ); ?>>
		<?php
	}
	?>
	<div <?php $this->print_render_attribute_string( 'pgscore_banner' ); ?>>
		<?php
		$this->add_render_attribute( 'pgs_banner_image', 'class', 'pgscore_banner-image img-fluid inline' );
		$this->add_render_attribute( 'pgs_banner_image', 'width', esc_attr( $banner_image[1] ) );
		$this->add_render_attribute( 'pgs_banner_image', 'height', esc_attr( $banner_image[2] ) );
		$this->add_render_attribute( 'pgs_banner_image', 'alt', esc_attr__( 'Banner', 'pgs-core' ) );
		$this->add_render_attribute( 'pgs_banner_image', 'src', esc_url( $banner_image[0] ) );
		?>
		<img <?php $this->print_render_attribute_string( 'pgs_banner_image' ); ?>>
		<div <?php $this->print_render_attribute_string( 'pgs_banner_content' ); ?>>
			<div class="pgscore_banner-content-wrapper">
				<div class="pgscore_banner-content-inner-wrapper">
					<?php $this->get_templates( "{$this->widget_slug}/style/{$settings['style']}", null, array( 'settings' => $settings ) ); ?>
				</div>
			</div>
		</div>
	</div>
	<?php
	if ( $this->is_banner_link_enabled() ) {
		?>
		</a>
		<?php
	}
	?>
</div>
<?php
