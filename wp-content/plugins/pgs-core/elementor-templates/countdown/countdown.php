<?php // phpcs:ignore PEAR.Commenting.FileComment.Missing
$expire_message         = isset( $settings['expire_message'] ) ? $settings['expire_message'] : '';
$counter_style          = isset( $settings['counter_style'] ) ? $settings['counter_style'] : '';
$countdown_date         = isset( $settings['countdown_date'] ) ? $settings['countdown_date'] : '';
$countdown_color_scheme = isset( $settings['countdown_color_scheme'] ) ? $settings['countdown_color_scheme'] : '';

$counter_data = array(
	'expiremsg' => $expire_message,
	'weeks'     => esc_html__( 'Week', 'pgs-core' ),
	'days'      => esc_html__( 'Day', 'pgs-core' ),
	'hours'     => esc_html__( 'Hrs', 'pgs-core' ),
	'minutes'   => esc_html__( 'Min', 'pgs-core' ),
	'seconds'   => esc_html__( 'Sec', 'pgs-core' ),
);

$counter_data = wp_json_encode( $counter_data );

$this->add_render_attribute(
	array(
		'pgscore_countdown' => array(
			'class' => array(
				'deal-counter-wrapper',
				'counter-wrapper',
				'counter-style-' . $counter_style,
				'counter-' . $countdown_color_scheme,
			),
		),
	)
);
$this->add_render_attribute( 'pgscore_countdown_deal', 'class', 'deal-counter' );
$this->add_render_attribute( 'pgscore_countdown_deal', 'data-countdown-date', $countdown_date );
$this->add_render_attribute( 'pgscore_countdown_deal', 'data-counter_data', $counter_data );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'pgscore_countdown' ); ?>>
		<div <?php $this->print_render_attribute_string( 'pgscore_countdown_deal' ); ?>></div>
	</div>
</div>
