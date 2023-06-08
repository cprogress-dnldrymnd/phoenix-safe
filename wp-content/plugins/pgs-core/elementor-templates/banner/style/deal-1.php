<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
if ( $settings['list_items'] ) {
	$list_item_sr = 0;
	foreach ( $settings['list_items'] as $list_item ) {
		if ( isset( $list_item['title'] ) && $list_item['title'] ) {
			$list_item_sr++;

			$list_item_key = "list_item-{$list_item_sr}";

			$this->add_render_attribute( $list_item_key, 'class', 'pgscore_banner-text-wrap' );
			$this->add_render_attribute( $list_item_key, 'class', 'pgscore_banner-text-wrap-' . $list_item_sr );

			if ( isset( $list_item['bg_color'] ) && $list_item['bg_color'] ) {
				$this->add_render_attribute( $list_item_key, 'class', 'pgscore_banner-text-bg_color' );
			}
			$this->add_render_attribute( $list_item_key, 'class', 'elementor-repeater-item' );
			$this->add_render_attribute( $list_item_key, 'class', 'elementor-repeater-item-' . $list_item['_id'] );
			?>
			<div <?php $this->print_render_attribute_string( $list_item_key ); ?>>
					<div class="pgscore_banner-text">
					<?php
					echo wp_kses(
						$list_item['title'],
						array(
							'br'   => array(),
							'span' => array(),
						)
					);
					?>
					</div>
				</div>
			<?php

		}
	}
}

$this->get_templates( "{$this->widget_slug}/elements/deal", null, array( 'settings' => $settings ) );

if ( ( ! isset( $settings['banner_link_enable'] ) || 'yes' !== $settings['banner_link_enable'] ) && $settings['button_text'] ) {
	$this->get_templates( "{$this->widget_slug}/elements/button", null, array( 'settings' => $settings ) );
}
