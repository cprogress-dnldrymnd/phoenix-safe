<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	 exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_recent_posts'] );
extract( $atts );

if ( $intro_title ) {
	$intro_title_css = '';
	if ( $enable_intro == 'true' ) {
		$intro_title_css = "color:{$intro_title_color}";
	}
	?>
	<div class="latest-post-title"><?php echo wp_kses(
		sprintf(
			'<%1$s class="latest-post-title-el" style="%3$s">%2$s</%1$s>',
			$intro_title_tag,
			$intro_title,
			esc_attr( $intro_title_css )
		),
		array(
			$intro_title_tag => array(
				'class' => true,
				'style' => true,
			),
		)
	); ?></div>
	<?php
}
