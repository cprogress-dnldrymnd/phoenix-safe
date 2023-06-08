<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$link_attr        = '';
$pbtitle          = isset( $settings['title'] ) ? $settings['title'] : '';
$btntext          = isset( $settings['btntext'] ) ? $settings['btntext'] : '';
$subtitle         = isset( $settings['subtitle'] ) ? $settings['subtitle'] : '';
$price            = isset( $settings['price'] ) ? $settings['price'] : '';
$frequency        = isset( $settings['frequency'] ) ? $settings['frequency'] : '';
$style            = isset( $settings['style'] ) ? $settings['style'] : '';
$bestseller       = isset( $settings['bestseller'] ) ? $settings['bestseller'] : '';
$bestseller_label = isset( $settings['bestseller_label'] ) ? $settings['bestseller_label'] : '';
$features         = isset( $settings['features'] ) ? $settings['features'] : '';

if ( ! $pbtitle || ! $features ) {
	return;
}

$this->add_render_attribute( 'pgscore_pricing_box', 'class', 'pgscore-pricing' );
if ( $style ) {
	$this->add_render_attribute( 'pgscore_pricing_box', 'class', 'pgscore-pricing-' . $style );
}

if ( $bestseller ) {
	$this->add_render_attribute( 'pgscore_pricing_box', 'class', 'active' );
}

$plan_features = array( $features );
if ( strpos( $features, "\n" ) !== false ) {
	$plan_features = explode( "\n", $features );
}

// Clean br tags from lines.
if ( $plan_features ) {
	foreach ( $plan_features as $line_k => $line ) {
		$line        = trim( $line );
		$line_length = strlen( $line );
		if ( '<br />' === substr( $line, -6 ) || '<br>' === substr( $line, -4 ) ) {
			if ( '<br />' === substr( $line, -6 ) ) {
				$line = mb_substr( $line, 0, $line_length - 6 );
			} elseif ( '<br>' === substr( $line, -4 ) ) {
				$line = mb_substr( $line, 0, $line_length - 4 );
			}
		}
		$plan_features[ $line_k ] = $line;
	}
}
$this->add_render_attribute( 'widget_wrapper', 'class', 'pgscore_pricing_wrapper' );
$this->add_link_attributes( 'pricingbox_btn_link', $settings['btnlink'] );
if ( filter_var( $settings['btnlink']['is_external'], FILTER_VALIDATE_BOOLEAN ) ) {
	$this->add_render_attribute( 'pricingbox_btn_link', 'rel', 'noreferrer' );
	$this->add_render_attribute( 'pricingbox_btn_link', 'rel', 'noopener' );
}
if ( ! isset( $settings['btnlink']['url'] ) || empty( $settings['btnlink']['url'] ) ) {
	$this->add_render_attribute( 'pricingbox_btn_link', 'href', '#' );
}
$this->add_render_attribute( 'pricingbox_btn_link', 'class', 'button button-border gray' );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'pgscore_pricing_box' ); ?>>
		<?php
		if ( $bestseller ) {
			$label = ! empty( $bestseller_label ) ? $bestseller_label : esc_html__( 'Best Seller', 'pgs-core' );
			?>
			<div class="pricing-ribbon">
				<span class="ribbon"><?php echo esc_html( $label ); ?> </span>
			</div>
			<?php
		}
		?>
		<div class="pricing-title">
			<h2><?php echo esc_html( $pbtitle ); ?></h2>
			<span><?php echo esc_html( $subtitle ); ?></span>
			<div class="pricing-prize">
				<h2><?php echo esc_html( $price ); ?></h2>
				<span><?php echo esc_html( $frequency ); ?></span>
			</div>
		</div>
		<div class="pricing-list">
			<?php
			if ( $plan_features ) {
				?>
				<ul>
					<?php
					foreach ( $plan_features as $feature ) {
						if ( $feature ) {
							?>
							<li><?php echo esc_html( wp_strip_all_tags( $feature ) ); ?></li>
							<?php
						}
					}
					?>
				</ul>
				<?php
			}
			?>
		</div>
		<div class="pricing-order">
			<a <?php $this->print_render_attribute_string( 'pricingbox_btn_link' ); ?>>
				<?php echo esc_html( $btntext ); ?>
			</a>
		</div>
	</div>
</div>
