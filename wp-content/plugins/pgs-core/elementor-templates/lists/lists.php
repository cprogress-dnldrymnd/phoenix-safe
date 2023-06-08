<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
// List Classes.
$icon_style_type        = isset( $settings['icon_style_type'] ) ? $settings['icon_style_type'] : '';
$icon_shape             = isset( $settings['icon_shape'] ) ? $settings['icon_shape'] : '';
$add_icon               = isset( $settings['add_icon'] ) ? $settings['add_icon'] : '';
$list_style_type        = isset( $settings['list_style_type'] ) ? $settings['list_style_type'] : '';
$list_font_weight       = isset( $settings['list_font_weight'] ) ? $settings['list_font_weight'] : '';
$list_text_transform    = isset( $settings['list_text_transform'] ) ? $settings['list_text_transform'] : '';
$list_title_color       = isset( $settings['list_title_color'] ) ? $settings['list_title_color'] : '';
$list_title_hover_color = isset( $settings['list_title_hover_color'] ) ? $settings['list_title_hover_color'] : '';
$list_items             = isset( $settings['list_items'] ) ? $settings['list_items'] : '';
$list_element_tag       = isset( $settings['list_element_tag'] ) ? $settings['list_element_tag'] : '';
$icon                   = isset( $settings['icon'] ) ? $settings['icon'] : '';

$this->add_render_attribute( 'pgscore_lists', 'class', 'pgscore_list list' );
if ( 'yes' === $add_icon && $icon ) {
	$this->add_render_attribute( 'pgscore_lists', 'class', 'list-unstyled' );
}

if ( 'yes' === $add_icon ) {
	if ( $icon_style_type ) {
		$this->add_render_attribute( 'pgscore_lists', 'class', 'icon-style-type-' . $icon_style_type );
	}

	if ( $icon_shape && 'default' !== $icon_style_type ) {
		$this->add_render_attribute( 'pgscore_lists', 'class', 'icon-shape-' . $icon_shape );
	}
} else {
	if ( $list_style_type ) {
		$this->add_render_attribute( 'pgscore_lists', 'class', 'icon-list-type-' . $list_style_type );
	}
}
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<ul <?php $this->print_render_attribute_string( 'pgscore_lists' ); ?>>
		<?php
		if ( $list_items ) {
			foreach ( $list_items as $list_item ) {
				if ( isset( $list_item['content'] ) && $list_item['content'] ) {

					$link_attr = '';

					if ( isset( $list_item['content_link']['url'] ) && $list_item['content_link']['url'] ) {
						$target    = ( isset( $list_item['content_link']['is_external'] ) && $list_item['content_link']['is_external'] ) ? ' target="_blank"' : '';
						$nofollow  = ( isset( $list_item['content_link']['nofollow'] ) && $list_item['content_link']['nofollow'] ) ? ' rel="nofollow"' : '';
						$link_attr = 'href="' . $list_item['content_link']['url'] . '"' . $target . $nofollow;
					}
					?>
					<li>
						<?php
						if ( 'yes' === $add_icon ) {
							\Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) );
						}
						if ( $link_attr ) {
							?>
							<<?php echo esc_html( $list_element_tag ); ?> class="pgscore-list-info inline_hover" >
							<a class="inline_hover" <?php echo $link_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $list_item['content'] ); ?></a>
							</<?php echo esc_html( $list_element_tag ); ?>>
							<?php
						} else {
							?>
							<<?php echo esc_html( $list_element_tag ); ?> class="pgscore-list-info ">
							<?php echo esc_html( $list_item['content'] ); ?>
							</<?php echo esc_html( $list_element_tag ); ?>>
							<?php
						}
						?>
					</li>
					<?php
				}
			}
		}
		?>
	</ul>
</div>
