<?php
$intro_title = isset( $settings['intro_title'] ) ? $settings['intro_title'] : '';
if ( $intro_title ) {
	$intro_title_tag = Elementor\Utils::validate_html_tag( $settings['intro_title_tag'] );
	?>
	<div class="latest-post-title"><?php echo wp_kses(
		sprintf(
			'<%1$s class="latest-post-title-el">%2$s</%1$s>',
			$intro_title_tag,
			$intro_title
		),
		array(
			$intro_title_tag => array(
				'class' => true,
			),
		)
	); ?></div>
	<?php
}
