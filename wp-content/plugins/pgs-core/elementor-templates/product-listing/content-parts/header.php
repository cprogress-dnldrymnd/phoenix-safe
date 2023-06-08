<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$intro_title       = isset( $settings['intro_title'] ) ? $settings['intro_title'] : '';
$intro_description = isset( $settings['intro_description'] ) ? $settings['intro_description'] : '';
?>
<div class="products-listing-header">
	<div class="products-listing-inner">
		<?php
		if ( $intro_title ) {
			?>
			<div class="row">
				<div class="col-8"><?php $this->get_templates( "{$this->widget_slug}/content-parts/title", null, array( 'settings' => $settings ) ); ?></div>
				<div class="col-4">
					<?php
					// Classes.
					$this->add_render_attribute( 'pgscore_product_header_controls_classes', 'class', 'products-listing-header-control products-listing-header-control-' . $this->get_id() );
					?>
					<div <?php $this->print_render_attribute_string( 'pgscore_product_header_controls_classes' ); ?>>
						<div class="products-listing-nav"></div>
					</div>
				</div>
			</div>
			<?php
		}
		if ( $intro_description ) {
			?>
			<div class="row">
				<div class="col">
					<?php $this->get_templates( "{$this->widget_slug}/content-parts/description", null, array( 'settings' => $settings ) ); ?>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</div>
