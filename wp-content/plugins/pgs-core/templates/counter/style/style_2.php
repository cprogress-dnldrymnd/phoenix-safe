<?php
if ( ! defined( 'ABSPATH' ) ) { // Or some other WordPress constant
	exit;
}
global $pgscore_shortcodes;
extract( $pgscore_shortcodes['pgscore_counter'] );
extract( $atts );

$background_styles = array();

if ( isset( $counter_icon_background ) && ! empty( $counter_icon_background ) ) {
	if ( 'background' === $counter_icon_background ) {
		if ( isset( $counter_background_color ) && ! empty( $counter_background_color ) ) {
			$background_styles[] = 'background-color:' . $counter_background_color . ';';
		}
	} else {
		if ( isset( $counter_border_color ) && ! empty( $counter_border_color ) ) {
			$background_styles[] = 'border-color:' . $counter_border_color . ';';
		}
	}
}

$number_styles = array();

if ( isset( $counter_number_color ) && ! empty( $counter_number_color ) ) {
	$number_styles[] = 'color:' . $counter_number_color . ';';
}
if ( isset( $counter_number_font_size ) && ! empty( $counter_number_font_size ) ) {
	if ( $counter_number_font_size >= 50 ) {
		$counter_number_font_size = 50;
	} elseif ( $counter_number_font_size <= 14 ) {
		$counter_number_font_size = 14;
	}
	$number_styles[] = 'font-size:' . $counter_number_font_size . 'px;';
}
if ( isset( $counter_number_font_style ) && ! empty( $counter_number_font_style ) ) {

	$number_styles[] = 'font-style:' . $counter_number_font_style . ';';
}
if ( isset( $counter_number_font_weight ) && ! empty( $counter_number_font_weight ) ) {

	$number_styles[] = 'font-weight:' . $counter_number_font_weight . ';';
}

$title_styles = array();

if ( isset( $counter_title_color ) && ! empty( $counter_title_color ) ) {
	$title_styles[] = 'color:' . $counter_title_color . ';';
}
if ( isset( $counter_title_font_size ) && ! empty( $counter_title_font_size ) ) {
	if ( $counter_title_font_size >= 50 ) {
		$counter_title_font_size = 50;
	} elseif ( $counter_title_font_size <= 14 ) {
		$counter_title_font_size = 14;
	}
	$title_styles[] = 'font-size:' . $counter_title_font_size . 'px;';
}
if ( isset( $counter_title_font_style ) && ! empty( $counter_title_font_style ) ) {

	$title_styles[] = 'font-style:' . $counter_title_font_style . ';';
}
if ( isset( $counter_title_font_weight ) && ! empty( $counter_title_font_weight ) ) {

	$title_styles[] = 'font-weight:' . $counter_title_font_weight . ';';
}
if ( isset( $counter_title_text_transform ) && ! empty( $counter_title_text_transform ) ) {

	$title_styles[] = 'text-transform:' . $counter_title_text_transform . ';';
}

$google_font_css = array();
if ( isset( $use_google_font ) && 'yes' === $use_google_font && isset( $counter_google_fonts ) ) {

	$enqueue_google_font = true;

	if ( isset( $google_font_enqueue_source ) && 'manual' === $google_font_enqueue_source ) {
		$enqueue_google_font = false;
	}

	$google_font_css = pgscore_get_google_fonts_css( $counter_google_fonts, $enqueue_google_font );
	$title_styles    = array_merge( $google_font_css, $title_styles );
}
?>
<div class="pgscore-counter pgscore-counter-style-2 icon-<?php echo esc_attr( $counter_icon_background ); ?> alignment-<?php echo esc_attr( $counter_alighnment ); ?>" >
	<?php if ( ! $counter_icon_disable ) { ?>
		<?php if ( 'font' === $counter_icon_source ) { ?>
		<div style="<?php echo esc_attr( implode( '', $background_styles ) ); ?>" class="pgscore-counter-icon pgscore-icon-<?php echo esc_attr( $counter_icon_source ); ?> icon-size-<?php echo esc_attr( $counter_icon_size ); ?>">
			<?php echo $icon_html; ?>
		</div>
		<?php } else { ?> 
		<div class="pgscore-counter-icon pgscore-icon-<?php echo esc_attr( $counter_icon_source ); ?>">
			<?php echo $icon_html; ?>
		</div>
		<?php } ?>
	<?php } ?>
	
	<div style="<?php echo esc_attr( implode( '', $number_styles ) ); ?>" class="pgscore-counter-number">
		<span class="counter-number"><?php echo esc_html( $counter_number ); ?></span>
	</div>
	<div style="<?php echo esc_attr( implode( '', $title_styles ) ); ?>" class="pgscore-counter-title">
		<span class="counter-title"><?php echo esc_html( $counter_title ); ?></span>
	</div>		
</div>
