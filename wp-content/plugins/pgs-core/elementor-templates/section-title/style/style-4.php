<?php
$main_title_el       = isset( $settings['main_title_el'] ) ? $settings['main_title_el'] : '';
$section_title_style = isset( $settings['section_title_style'] ) ? $settings['section_title_style'] : '';
$section_alighnment  = isset( $settings['section_alighnment'] ) ? $settings['section_alighnment'] : '';
$image_source        = isset( $settings['image_source'] ) ? $settings['image_source'] : '';
$main_title          = isset( $settings['main_title'] ) ? $settings['main_title'] : '';
$sub_title           = isset( $settings['sub_title'] ) ? $settings['sub_title'] : '';
$section_description = isset( $settings['section_description'] ) ? $settings['section_description'] : '';
$divider_bg_img      = isset( $settings['divider_bg_img'] ) ? $settings['divider_bg_img'] : '';
$divider_bg_img_link = isset( $settings['divider_bg_img_link'] ) ? $settings['divider_bg_img_link'] : '';

$this->add_render_attribute( 'pgscore_section_title_devider', 'class', 'pgscore_divider_wrapper pgscore_divider_' . str_replace( '-', '', $section_title_style ) );
if ( $section_alighnment ) {
	$this->add_render_attribute( 'pgscore_section_title_devider', 'class', 'pgscore_divider_alignment_' . $section_alighnment );
}
?>
<div <?php $this->print_render_attribute_string( 'pgscore_section_title_devider' ); ?>>
	<span class="divider-sub-title">
		<?php echo esc_html( $sub_title ); ?>
	</span>		

	<<?php echo esc_attr( $main_title_el ); ?> class="divider-title">
		<span>
			<?php echo esc_html( $main_title ); ?>
		</span>
	</<?php echo esc_attr( $main_title_el ); ?>>
	<?php
	if ( 'link' === $image_source ) {
		if ( isset( $divider_bg_img_link['url'] ) && $divider_bg_img_link['url'] ) {
			?>
				<div class="divider-img">
					<img src="<?php echo esc_url( $divider_bg_img_link['url'] ); ?>" />
				</div>
			<?php
		}
	} else {
		if ( isset( $divider_bg_img['id'] ) && $divider_bg_img['id'] ) {
			?>
				<div class="divider-img">
				<?php echo wp_get_attachment_image( $divider_bg_img['id'], 'thumbnail', 'false' ); ?>
				</div>
			<?php
		}
	}

	if ( $section_description ) {
		?>
		<p><?php echo esc_html( $section_description ); ?></p>
		<?php 
	}
	?>
</div>
