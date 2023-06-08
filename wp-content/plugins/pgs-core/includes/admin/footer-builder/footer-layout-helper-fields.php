<?php
/**
 * Footer Helper Field.
 *
 * @author      Potenza Team
 * @package     ciyashop core
 * @version     1.0.0
 */

/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Footer Settings fields
 */
function pgscore_footer_layout_fields() {

	$ciyashop_footer_layout_fields = array(
		array(
			'type'        => 'radio_buttonset',
			'heading'     => esc_html__( 'Sticky Footer', 'pgs-core' ),
			'param_name'  => 'sticky_footer',
			'options'     => array(
				'enable'  => esc_html__( 'Enable', 'pgs-core' ),
				'disable' => esc_html__( 'Disable', 'pgs-core' ),
			),
			'default'     => 'disable',
			'classes'     => 'radio_label_only',
			'description' => esc_html__( 'The footer will be displayed behind the content of the page and will be visible when user scrolls to the bottom on the page.', 'pgs-core' ),
			'group'       => esc_html__( 'General', 'pgs-core' ),
		),
		array(
			'type'       => 'background_settings',
			'heading'    => esc_html__( 'Background Settings', 'pgs-core' ),
			'param_name' => 'footer_background_image',
			'group'      => esc_html__( 'Background', 'pgs-core' ),
		),
		array(
			'type'       => 'radio_buttonset',
			'heading'    => esc_html__( 'Background Opacity Color', 'pgs-core' ),
			'param_name' => 'footer_background_opacity',
			'options'    => array(
				'none'   => esc_html__( 'None', 'pgs-core' ),
				'custom' => esc_html__( 'Custom', 'pgs-core' ),
			),
			'default'    => 'none',
			'classes'    => 'radio_label_only',
			'group'      => esc_html__( 'Color', 'pgs-core' ),
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Opacity Color', 'pgs-core' ),
			'param_name'  => 'footer_background_overlay',
			'group'       => esc_html__( 'Color', 'pgs-core' ),
			'alpha'       => true,
			'dependency'  => array(
				'element' => 'footer_background_opacity',
				'value'   => array( 'custom' ),
			),
			'description' => wp_kses(
				__( '<b>This Setting Only work when image set as a background for footer.</b>', 'pgs-core' ),
				pgscore_allowed_html( array( 'b' ) )
			),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Footer Heading Color', 'pgs-core' ),
			'param_name' => 'footer_heading_color',
			'group'      => esc_html__( 'Color', 'pgs-core' ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Footer Text Color', 'pgs-core' ),
			'param_name' => 'footer_text_color',
			'group'      => esc_html__( 'Color', 'pgs-core' ),
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Footer Link Color', 'pgs-core' ),
			'param_name' => 'footer_link_color',
			'group'      => esc_html__( 'Color', 'pgs-core' ),
		),
		array(
			'type'       => 'radio_buttonset',
			'heading'    => esc_html__( 'Show Copyright Text', 'pgs-core' ),
			'param_name' => 'enable_copyright_footer',
			'options'    => array(
				'yes' => esc_html__( 'Yes', 'pgs-core' ),
				'no'  => esc_html__( 'No', 'pgs-core' ),
			),
			'default'    => 'yes',
			'classes'    => 'radio_label_only',
			'group'      => esc_html__( 'Copyright', 'pgs-core' ),
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Copyright Background Color', 'pgs-core' ),
			'param_name'  => 'copyright_back_color',
			'alpha'       => true,
			'description' => esc_html__( 'Custom color for copyright section background', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'enable_copyright_footer',
				'value'   => array( 'yes' ),
			),
			'group'      => esc_html__( 'Copyright', 'pgs-core' ),
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Text Color', 'pgs-core' ),
			'param_name'  => 'copyright_text_color',
			'default'     => '#323232',
			'description' => esc_html__( 'Custom color for copyright section font color', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'enable_copyright_footer',
				'value'   => array( 'yes' ),
			),
			'group'      => esc_html__( 'Copyright', 'pgs-core' ),
		),
		array(
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Link Color', 'pgs-core' ),
			'param_name'  => 'copyright_link_color',
			'default'     => '#04d39f',
			'description' => esc_html__( 'Custom color for copyright section font link color', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'enable_copyright_footer',
				'value'   => array( 'yes' ),
			),
			'group'      => esc_html__( 'Copyright', 'pgs-core' ),
		),
		array(
			'type'        => 'textarea_html',
			'heading'     => esc_html__( 'Footer Text Left', 'pgs-core' ),
			'param_name'  => 'footer_text_left',
			'default'     => esc_html__( '&copy; Copyright [pgscore-year] [pgscore-site-title] All Rights Reserved.', 'pgs-core' ),
			'description' => sprintf(
				wp_kses(
					__( 'You can use following shortcodes in your footer text: <br><span class="code">[pgscore-year]</span> <span class="code">[pgscore-site-title]</span> <span class="code">[pgscore-footer-menu]</span>', 'pgs-core' ),
					array(
						'span' => array(
							'class' => true,
						),
						'br'   => array(),
					)
				)
			),
			'group'       => esc_html__( 'Copyright', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'enable_copyright_footer',
				'value'   => array( 'yes' ),
			),
		),
		array(
			'type'        => 'textarea_html',
			'heading'     => esc_html__( 'Footer Text Right', 'pgs-core' ),
			'param_name'  => 'footer_text_right',
			'default'     => sprintf(
				wp_kses(
					__( 'Develop and design by <a href="%1$s">%2$s</a>', 'pgs-core' ),
					array(
						'a' => array(
							'href'   => true,
							'target' => true,
						),
					)
				),
				'http://www.potenzaglobalsolutions.com/',
				esc_html__( 'Potenza Global Solutions', 'pgs-core' )
			),
			'description' => sprintf(
				wp_kses(
					__( 'You can use following shortcodes in your footer text: <br><span class="code">[pgscore-year]</span> <span class="code">[pgscore-site-title]</span> <span class="code">[pgscore-footer-menu]</span>', 'pgs-core' ),
					array(
						'span' => array(
							'class' => true,
						),
						'br'   => array(),
					)
				)
			),
			'group'       => esc_html__( 'Copyright', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'enable_copyright_footer',
				'value'   => array( 'yes' ),
			),
		),
		array(
			'type'       => 'radio_buttonset',
			'heading'    => esc_html__( 'Footer Bottom', 'pgs-core' ),
			'param_name' => 'footer_bottom',
			'options'    => array(
				'show' => esc_html__( 'Show', 'pgs-core' ),
				'hide' => esc_html__( 'hide', 'pgs-core' ),
			),
			'default'    => 'show',
			'classes'    => 'radio_label_only',
			'group'      => esc_html__( 'Copyright', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'footer_type_select',
				'value'   => array( 'default' ),
			),
		),
		array(
			'type'        => 'textarea_html',
			'heading'     => esc_html__( 'Footer Bottom Content', 'pgs-core' ),
			'param_name'  => 'footer_bottom_content',
			'description'     => esc_html__( 'You can use this field to add bottom content in footer area. You can use child-theme CSS or Theme Option > Custom CSS to format content in this field. Also, you can use shortcode to insert your desired contents.', 'pgs-core' ),
			'group'       => esc_html__( 'Copyright', 'pgs-core' ),
			'dependency'  => array(
				'element' => 'footer_bottom',
				'value'   => array( 'show' ),
			),
		),
	);

	return $ciyashop_footer_layout_fields;
}
