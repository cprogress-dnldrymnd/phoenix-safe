<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$deal_expire_message = ( isset( $settings['deal_expire_message'] ) && $settings['deal_expire_message'] ) ? $settings['deal_expire_message'] : esc_html__( 'This offer has expired.', 'pgs-core' );
$deal_counter_size   = ( isset( $settings['deal_counter_size'] ) && $settings['deal_counter_size'] ) ? $settings['deal_counter_size'] : 'sm';
$deal_on_expire_btn  = ( isset( $settings['deal_on_expire_btn'] ) && $settings['deal_on_expire_btn'] ) ? $settings['deal_on_expire_btn'] : 'disable';
$deal_color_scheme   = ( isset( $settings['deal_color_scheme'] ) && $settings['deal_color_scheme'] ) ? $settings['deal_color_scheme'] : 'dark';

$counter_data = array(
	'expiremsg'     => $deal_expire_message,
	'weeks'         => esc_html__( 'Week', 'pgs-core' ),
	'days'          => esc_html__( 'Day', 'pgs-core' ),
	'hours'         => esc_html__( 'Hrs', 'pgs-core' ),
	'minutes'       => esc_html__( 'Min', 'pgs-core' ),
	'seconds'       => esc_html__( 'Sec', 'pgs-core' ),
	'on_expire_btn' => $deal_on_expire_btn,
);
$counter_data = wp_json_encode( $counter_data );


$this->add_render_attribute( 'pgscore_banner_deal_counter_wrapper', 'class', 'deal-counter-wrapper' );
$this->add_render_attribute( 'pgscore_banner_deal_counter_wrapper', 'class', 'counter-size-' . $deal_counter_size );
$this->add_render_attribute( 'pgscore_banner_deal_counter_wrapper', 'class', 'counter-color-' . $deal_color_scheme );
$this->add_render_attribute( 'pgscore_banner_deal_counter_wrapper', 'data-deal_style', $settings['style'] );


$this->add_render_attribute( 'pgscore_banner_deal_counter', 'class', 'deal-counter' );
$this->add_render_attribute( 'pgscore_banner_deal_counter', 'data-countdown-date', esc_attr( $settings['deal_date'] ) );
$this->add_render_attribute( 'pgscore_banner_deal_counter', 'data-counter_data', esc_attr( $counter_data ) );


if ( 'deal-1' === $settings['style'] ) {
	$this->add_render_attribute( 'pgscore_banner_deal_counter_wrapper', 'class', 'counter-style-' . $settings['deal_counter_style'] );
}
?>
<div <?php $this->print_render_attribute_string( 'pgscore_banner_deal_counter_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'pgscore_banner_deal_counter' ); ?>></div>
</div>
