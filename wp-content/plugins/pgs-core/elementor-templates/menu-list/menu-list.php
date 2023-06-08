<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$menu_list_items = isset( $settings['list_items'] ) ? $settings['list_items'] : array();
$menu_list_title = isset( $settings['menu_list_title'] ) ? $settings['menu_list_title'] : '';

$this->add_render_attribute( 'widget_wrapper', 'class', 'pgscore_menu_list_wrapper' );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<?php
	if ( $menu_list_title ) {
		?>
		<div class="pgscore_menu_list-title">
			<?php echo esc_html( $menu_list_title ); ?>
		</div>
		<?php
	}
	?>
	<ul class="pgscore_menu_list menu_list">
		<?php
		foreach ( $menu_list_items as $index => $list_item ) {
			$li_class      = 'elementor-repeater-item-' . $list_item['_id'];
			$menu_link_key = $this->get_repeater_setting_key( 'menu_item_link', 'list_items', $index );

			if ( isset( $list_item['menu_title'] ) && $list_item['menu_title'] ) {
				if ( empty( $list_item['menu_item_link']['url'] ) ) {
					$li_class .= ' empty-link';
				}
				?>
				<li class="<?php echo esc_attr( $li_class ); ?>">
					<?php
					if ( isset( $list_item['add_icon'] ) && 'yes' === $list_item['add_icon'] && isset( $list_item['icon'] ) && $list_item['icon'] ) {
						\Elementor\Icons_Manager::render_icon( $list_item['icon'], array( 'aria-hidden' => 'true' ) );
					}
					if ( ! empty( $list_item['menu_item_link']['url'] ) ) {
						$this->add_link_attributes( $menu_link_key, $list_item['menu_item_link'] );
						if ( filter_var( $list_item['menu_item_link']['is_external'], FILTER_VALIDATE_BOOLEAN ) ) {
							$this->add_render_attribute( $menu_link_key, 'rel', 'noreferrer' );
							$this->add_render_attribute( $menu_link_key, 'rel', 'noopener' );
						}
						?>
						<a <?php $this->print_render_attribute_string( $menu_link_key ); ?>>
						<?php
					} else {
						?>
						<span class="menu-title">
						<?php
					}

					echo esc_html( $list_item['menu_title'] );

					if ( isset( $list_item['menu_item_label'] ) && $list_item['menu_item_label'] ) {
						?>
						<span class="menu_item_label">
							<?php echo esc_html( $list_item['menu_item_label'] ); ?>
						</span>
						<?php
					}

					if ( ! empty( $list_item['menu_item_link']['url'] ) ) {
						?>
						</a>
						<?php
					} else {
						?>
						</span>
						<?php
					}
					?>
				</li>
				<?php
			}
		}
		?>
	</ul>
</div>
