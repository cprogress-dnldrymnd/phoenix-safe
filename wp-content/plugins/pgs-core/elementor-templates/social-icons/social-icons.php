<?php
$style        = isset( $settings['style'] ) ? $settings['style'] : '';
$hover_style  = isset( $settings['hover_style'] ) ? $settings['hover_style'] : '';
$shape        = isset( $settings['shape'] ) ? $settings['shape'] : '';
$size         = isset( $settings['size'] ) ? $settings['size'] : '';
$list_items   = isset( $settings['list_items'] ) ? $settings['list_items'] : ''; 

if ( ! is_array( $list_items ) || ! $list_items || ( ( count( $list_items ) === 1 ) && ! $list_items[0] ) ) {
	return;
}

$this->add_render_attribute( 'pgscore_social_icons', 'class', 'pgscore-social-icons' );
if ( $style ) {
	$this->add_render_attribute( 'pgscore_social_icons', 'class', 'pgssi-style-' . $style );
}

if ( $hover_style ) {
	$this->add_render_attribute( 'pgscore_social_icons', 'class', 'pgssi-effect-' . $hover_style );
}

if ( $shape ) {
	$this->add_render_attribute( 'pgscore_social_icons', 'class', 'pgssi-shape-' . $shape );
}

if ( $size ) {
	$this->add_render_attribute( 'pgscore_social_icons', 'class', 'pgssi-size-' . $size );
}
?>
<div <?php $this->print_render_attribute_string( 'pgscore_social_icons' ); ?>>
	<ul>
		<?php
		foreach ( $list_items as $list_item ) {
			if ( isset( $list_item['social_icon']['value'] ) && $list_item['social_icon']['value'] ) {
				$list_item_class = str_replace( 'fab fa-', '', $list_item['social_icon']['value'] );

				$link_attr = '';
				if ( isset( $list_item['link']['url'] ) && $list_item['link']['url'] ) {
					$target    = ( isset( $list_item['link']['is_external'] ) && $list_item['link']['is_external'] ) ? ' target="_blank"' : '';
					$nofollow  = ( isset( $list_item['link']['nofollow'] ) && $list_item['link']['nofollow'] ) ? ' rel="nofollow"' : '';
					$link_attr = 'href="' . $list_item['link']['url'] . '"' . $target . $nofollow;
				}
				?>
				<li class="pgssi-item pgssi-color-<?php echo esc_attr( $list_item_class ); ?>">
					<a <?php echo $link_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
						<?php \Elementor\Icons_Manager::render_icon( $list_item['social_icon'], [ 'aria-hidden' => 'true' ] ); ?>
					</a>
				</li>
				<?php
			}
		}
		?>
	</ul>
</div>
