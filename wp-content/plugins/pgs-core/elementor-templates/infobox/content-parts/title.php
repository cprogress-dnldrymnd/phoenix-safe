<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$link_attr  = '';
$title      = isset( $settings['title'] ) ? $settings['title'] : ''; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
$add_anchor = isset( $settings['add_anchor'] ) ? $settings['add_anchor'] : '';
$title_el   = isset( $settings['title_el'] ) ? $settings['title_el'] : '';

if ( isset( $settings['anchor_link']['url'] ) && $settings['anchor_link']['url'] ) {
	$target    = ( isset( $settings['anchor_link']['is_external'] ) && $settings['anchor_link']['is_external'] ) ? ' target="_blank"' : '';
	$nofollow  = ( isset( $settings['anchor_link']['nofollow'] ) && $settings['anchor_link']['nofollow'] ) ? ' rel="nofollow"' : '';
	$link_attr = 'href="' . $settings['anchor_link']['url'] . '"' . $target . $nofollow;
}

if ( $title ) {
	if ( 'true' === $add_anchor ) {
		?>
		<<?php echo esc_attr( $title_el ); ?> class="pgscore_info_box-title">

		<?php
		if ( $link_attr ) {
			?>
			<a <?php echo $link_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php
		}

		echo esc_html( $title );

		if ( $link_attr ) {
			?>
			</a>
			<?php
		}
		?>

		</<?php echo esc_attr( $title_el ); ?>>
		<?php
	} else {
		?>
		<<?php echo esc_attr( $title_el ); ?> class="pgscore_info_box-title">
			<?php
			echo esc_html( $title );
			?>
		</<?php echo esc_attr( $title_el ); ?>>
		<?php
	}
}
