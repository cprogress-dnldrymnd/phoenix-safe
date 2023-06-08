<?php
/**
 * Register "Static Block" custom post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type/
 * @link https://developer.wordpress.org/reference/functions/register_post_type/
 *
 * @package PGS Core
 */

if ( ! function_exists( 'pgscore_register_static_blocks' ) ) {
	/**
	 * Register HTM Block post type
	 */
	function pgscore_register_static_blocks() {

		$labels = array(
			'name'               => _x( 'Static Blocks', 'Post Type General Name', 'pgs-core' ),
			'singular_name'      => _x( 'Static Block', 'Post Type Singular Name', 'pgs-core' ),
			'menu_name'          => __( 'Static Blocks', 'pgs-core' ),
			'parent_item_colon'  => __( 'Parent Item:', 'pgs-core' ),
			'all_items'          => __( 'All Blocks', 'pgs-core' ),
			'view_item'          => __( 'View Block', 'pgs-core' ),
			'add_new_item'       => __( 'Add New Block', 'pgs-core' ),
			'add_new'            => __( 'Add New', 'pgs-core' ),
			'edit_item'          => __( 'Edit Block', 'pgs-core' ),
			'update_item'        => __( 'Update Block', 'pgs-core' ),
			'search_items'       => __( 'Search Block', 'pgs-core' ),
			'not_found'          => __( 'Not found', 'pgs-core' ),
			'not_found_in_trash' => __( 'Not found in Trash', 'pgs-core' ),
		);

		$args = array(
			'label'               => __( 'Static Block', 'pgs-core' ),
			'description'         => __( 'Static blocks to place custom HTML in your contents.', 'pgs-core' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'elementor' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 29,
			'menu_icon'           => 'dashicons-schedule',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'rewrite'             => false,
			'capability_type'     => 'page',
		);

		register_post_type( 'static_block', $args );
	}
}
add_action( 'init', 'pgscore_register_static_blocks' );

if ( ! function_exists( 'pgscore_manage_static_blocks_columns' ) ) {
	/**
	 * Add shortcode column to block list
	 */
	function pgscore_manage_static_blocks_columns( $columns ) {
		$columns = array(
			'cb'        => '<input type="checkbox" />',
			'title'     => __( 'Title', 'pgs-core' ),
			'shortcode' => __( 'Shortcode', 'pgs-core' ),
			'date'      => __( 'Date', 'pgs-core' ),
		);

		return $columns;
	}
}
add_filter( 'manage_edit-static_block_columns', 'pgscore_manage_static_blocks_columns' );

if ( ! function_exists( 'manage_static_blocks_columns' ) ) {
	/**
	 * Manage Static block post columns
	 */
	function manage_static_blocks_columns( $column, $post_id ) {
		switch ( $column ) {
			case 'shortcode':
				echo '<strong>[static_block id="' . esc_attr( $post_id ) . '"]</strong>';
				break;
		}
	}
}
add_action( 'manage_static_block_posts_custom_column', 'manage_static_blocks_columns', 10, 2 );

if ( ! function_exists( 'pgscore_static_block_default_template' ) ) {
	/**
	 * Set default template.
	 */
	function pgscore_static_block_default_template( $post_ID, $post, $update ) {
		if ( ! $update && 'static_block' === $post->post_type && 'auto-draft' === $post->post_status ) {
			add_post_meta( $post_ID, '_wp_page_template', 'elementor_canvas' );
		}
	}
}
add_action( 'save_post', 'pgscore_static_block_default_template', 10, 3 );

if ( ! function_exists( 'pgscore_static_block_shortcode' ) ) {
	/**
	 * Static block shortcode.
	 */
	function pgscore_static_block_shortcode( $atts ) {

		extract(
			shortcode_atts(
				array(
					'id' => 0,
				),
				$atts
			)
		);

		return pgs_get_html_block( $id );
	}
}
add_shortcode( 'static_block', 'pgscore_static_block_shortcode' );
add_shortcode( 'html_block', 'pgscore_html_block_shortcode' );

if ( ! function_exists( 'pgscore_elementor_template' ) ) {
	/**
	 * Elementor template shortcode.
	 */
	function pgscore_elementor_template( $atts ) {
		extract(
			shortcode_atts(
				array(
					'id' => 0,
				),
				$atts
			)
		);

		return \Elementor\Plugin::$instance->frontend->get_builder_content( $id, true );
	}
}
add_shortcode( 'pgs_elementor_template', 'pgscore_elementor_template' );

if ( ! function_exists( 'pgs_get_html_block' ) ) {
	function pgs_get_html_block( $post_id ) {
		$page_builder = ciyashop_get_default_page_builder();
		$content      = '';

		if ( 'wpbakery' === $page_builder ) {

			$content = get_post_field( 'post_content', $post_id );
			$content = do_shortcode( $content );

			$shortcodes_css = get_post_meta( $post_id, '_wpb_shortcodes_custom_css', true );

			$content .= '<style type="text/css" data-type="vc_shortcodes-custom-css">';
			if ( ! empty( $shortcodes_css ) ) {
				$content .= $shortcodes_css;
			}
			$content .= '</style>';
		}elseif ( 'elementor' === $page_builder ) {
			$content = \Elementor\Plugin::$instance->frontend->get_builder_content( $post_id, true );
		}

		return $content;
	}
}
