<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$ohtitle = isset( $settings['title'] ) ? $settings['title'] : '';
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<h4 class="pgs-opening-hours-title"><?php echo esc_html( $ohtitle ); ?></h4>
	<div class="pgs-opening-hours">
		<?php
		$ciyashop_opening_hours = ciyashop_opening_hours();
		if ( ! empty( $ciyashop_opening_hours ) ) {
			?>
			<ul>
				<?php
				foreach ( $ciyashop_opening_hours as $ciyashop_opening_hour => $ciyashop_opening_hour_val ) {
					if ( $ciyashop_opening_hour_val ) {
						?>
						<li>
							<i class="fa fa-clock-o"></i><span><?php echo esc_html( $ciyashop_opening_hour ); ?></span>
							<label><?php echo wp_kses( $ciyashop_opening_hour_val, pgscore_allowed_html( array( 'a' ) ) ); ?></label>
						</li>
						<?php
					}
				}
				?>
			</ul>
			<?php
		}
		?>
	</div>
</div>
