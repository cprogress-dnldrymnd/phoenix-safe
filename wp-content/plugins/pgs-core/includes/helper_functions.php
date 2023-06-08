<?php
// Filter out hard-coded width, height attributes on all captions (wp-caption class)
add_shortcode( 'wp_caption', 'pgscore_fixed_img_caption_shortcode' );
add_shortcode( 'caption', 'pgscore_fixed_img_caption_shortcode' );
function pgscore_fixed_img_caption_shortcode( $attr, $content = null ) {
	if ( ! isset( $attr['caption'] ) ) {
		if ( preg_match( '#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches ) ) {
			$content         = $matches[1];
			$attr['caption'] = trim( $matches[2] );
		}
	}
	$output = apply_filters( 'img_caption_shortcode', '', $attr, $content );
	if ( '' != $output ) {
		return $output;
	}
	extract(
		shortcode_atts(
			array(
				'id'      => '',
				'align'   => 'alignnone',
				'width'   => '',
				'caption' => '',
			),
			$attr
		)
	);
	if ( 1 > (int) $width || empty( $caption ) ) {
		return $content;
	}
	if ( $id ) {
		$id = 'id="' . esc_attr( $id ) . '" ';
	}
	return '<div ' . $id . 'class="wp-caption ' . esc_attr( $align ) . '" >'
	. do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}

/**
 * Filter out hard-coded width, height attributes on all captions (wp-caption class)
 *
 * @since PGS Core 1.0
 */
function pgscore_fix_img_caption_shortcode( $attr, $content = null ) {
	if ( ! isset( $attr['caption'] ) ) {
		if ( preg_match( '#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches ) ) {
			$content         = $matches[1];
			$attr['caption'] = trim( $matches[2] );
		}
	}
	$output = apply_filters( 'img_caption_shortcode', '', $attr, $content );
	if ( '' != $output ) {
		return $output;
	}
	extract(
		shortcode_atts(
			array(
				'id'      => '',
				'align'   => 'alignnone',
				'width'   => '',
				'caption' => '',
			),
			$attr
		)
	);
	if ( 1 > (int) $width || empty( $caption ) ) {
		return $content;
	}
	if ( $id ) {
		$id = 'id="' . esc_attr( $id ) . '" ';
	}
	return '<figure ' . $id . 'class="wp-caption ' . esc_attr( $align ) . '" >' . do_shortcode( $content ) . '<figcaption class="wp-caption-text">' . $caption . '</figcaption></figure>';
}
add_shortcode( 'wp_caption', 'pgscore_fix_img_caption_shortcode' );
add_shortcode( 'caption', 'pgscore_fix_img_caption_shortcode' );

function pgscore_get_excerpt_max_charlength( $charlength, $excerpt = null ) {
	if ( empty( $excerpt ) ) {
		$excerpt = get_the_excerpt();
	}
	$charlength++;

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex   = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut   = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );

		$new_excerpt = '';
		if ( $excut < 0 ) {
			$new_excerpt = mb_substr( $subex, 0, $excut );
		} else {
			$new_excerpt = $subex;
		}
		$new_excerpt .= '[...]';
		return $new_excerpt;
	} else {
		return $excerpt;
	}
}
function pgscore_the_excerpt_max_charlength( $charlength, $excerpt = null ) {
	$new_excerpt = pgscore_get_excerpt_max_charlength( $charlength, $excerpt );
	echo $new_excerpt;
}

/**
 * Truncate String with or without ellipsis.
 *
 * @param string $string      String to truncate
 * @param int    $maxLength   Maximum length of string
 * @param bool   $addEllipsis if True, "..." is added in the end of the string, default true
 * @param bool   $wordsafe    if True, Words will not be cut in the middle
 *
 * @return string Shotened Text
 */
function pgscore_shortenString( $string, $maxLength, $addEllipsis = true, $wordsafe = false ) {
	if ( empty( $string ) ) {
		$string;
	}
	$ellipsis  = '';
	$maxLength = max( $maxLength, 0 );
	if ( mb_strlen( $string ) <= $maxLength ) {
		return $string;
	}
	if ( $addEllipsis ) {
		$ellipsis   = mb_substr( '...', 0, $maxLength );
		$maxLength -= mb_strlen( $ellipsis );
		$maxLength  = max( $maxLength, 0 );
	}
	if ( $wordsafe ) {
		$string = preg_replace( '/\s+?(\S+)?$/', '', mb_substr( $string, 0, $maxLength ) );
	} else {
		$string = mb_substr( $string, 0, $maxLength );
	}
	if ( $addEllipsis ) {
		$string .= $ellipsis;
	}

	return $string;
}

/**
 * Get shortcode template parts.
 */
function pgscore_get_shortcode_templates( $slug, $name = '' ) {
	$template = '';

	$template_path = 'template-parts/shortcodes/';
	$plugin_path   = trailingslashit( PGSCORE_PATH );

	// Look in yourtheme/template-parts/shortcodes/slug-name.php
	if ( $name ) {
		$template = locate_template(
			array(
				$template_path . "{$slug}-{$name}.php",
			)
		);
	}

	// Get default slug-name.php
	if ( ! $template && $name && file_exists( $plugin_path . "templates/{$slug}-{$name}.php" ) ) {
		$template = $plugin_path . "templates/{$slug}-{$name}.php";
	}

	// If template file doesn't exist, look in yourtheme/template-parts/shortcodes/slug.php
	if ( ! $template ) {
		$template = locate_template(
			array(
				$template_path . "{$slug}.php",
			)
		);
	}

	// Get default slug.php
	if ( ! $template && file_exists( $plugin_path . "templates/{$slug}.php" ) ) {
		$template = $plugin_path . "templates/{$slug}.php";
	}

	// Allow 3rd party plugins to filter template file from their plugin.
	$template = apply_filters( 'pgscore_get_shortcode_templates', $template, $slug, $name );

	if ( $template ) {
		load_template( $template, false );
	}
}

function pgscore_class_builder( $class = '' ) {
	$classes = array();

	if ( $class ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class );
		}
		$classes = array_map( 'esc_attr', $class );
	} else {
		// Ensure that we always coerce class to being an array.
		$class = array();
	}
	$classes = array_map( 'esc_attr', $classes );

	return implode( ' ', array_filter( array_unique( $classes ) ) );
}

function pgscore_shortcode_id( $atts ) {
	extract( $atts );

	if ( ! empty( $element_id ) ) {
		$element_id = ( preg_match( '/^\d/', $element_id ) === 1 ) ? $shortcode_handle . '_' . $element_id : $element_id;
	}

	// bail, if no valid id found.
	if ( ! isset( $element_id ) || '' == $element_id ) {
		return;
	}

	echo 'id="' . esc_attr( $element_id ) . '"';
}

function pgscore_check_plugin_active( $plugin = '' ) {

	if ( empty( $plugin ) ) {
		return false;
	}

	global $pgscore_globals;
	$active_plugins = $pgscore_globals['active_plugins'];

	return (
		in_array( $plugin, $active_plugins )
		|| ( function_exists( 'is_plugin_active_for_network' ) && is_plugin_active_for_network( $plugin ) )
	);
}

function pgscore_is_plugin_installed( $search ) {
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	$plugins      = get_plugins();
	$plugins      = array_filter(
		array_keys( $plugins ),
		function( $k ) {
			if ( strpos( $k, '/' ) !== false ) {
				return true;
			}
		}
	);
	$plugins_stat = function( $plugins, $search ) {
		$new_plugins = array();
		foreach ( $plugins as $plugin ) {
			$new_plugins_data = explode( '/', $plugin );
			$new_plugins[]    = $new_plugins_data[0];
		}
		return in_array( $search, $new_plugins );
	};
	return $plugins_stat( $plugins, $search );
}

function pgscore_allowed_html( $allowed_els = '' ) {

	// bail early if parameter is empty
	if ( empty( $allowed_els ) ) {
		return array();
	}

	if ( is_string( $allowed_els ) ) {
		$allowed_els = explode( ',', $allowed_els );
	}

	$allowed_html = array();

	$allowed_tags = wp_kses_allowed_html( 'post' );

	foreach ( $allowed_els as $el ) {
		$el = trim( $el );
		if ( array_key_exists( $el, $allowed_tags ) ) {
			$allowed_html[ $el ] = $allowed_tags[ $el ];
		}
	}

	return $allowed_html;
}

function pgscore_product_types( $args = array() ) {
	$product_types = array(
		'new_arrivals' => esc_html__( 'Newest', 'pgs-core' ),
		'featured'     => esc_html__( 'Featured', 'pgs-core' ),
		'best_sellers' => esc_html__( 'Best Sellers', 'pgs-core' ),
		'on_sale'      => esc_html__( 'On sale', 'pgs-core' ),
		'cheapest'     => esc_html__( 'Cheapest', 'pgs-core' ),
	);

	// Deprecated.
	$product_types = apply_filters_deprecated( 'ciyashop_product_types', array( $product_types ), '4.0', 'pgscore_product_types' ); // TODO: CiyaShop Upcoming Release
	$product_types = apply_filters( 'pgscore_product_types', $product_types );

	if ( isset( $args['array_flip'] ) && $args['array_flip'] ) {
		$product_types = array_flip( $product_types );
	}

	return $product_types;
}

function pgscore_validate_css_unit( $str = '', $units = array() ) {

	// bail early if any param is empty
	if ( ! is_string( $str ) || '' == $str || ! is_array( $units ) || empty( $units ) ) {
		return false;
	}

	// prepare units string
	$units_str = implode( '|', $units );

	// prepare regex
	$reg_ex = '/^(auto|0)$|^[+-]?[0-9]+.?([0-9]+)?(' . $units_str . ')$/';

	// check match
	preg_match_all( $reg_ex, $str, $matches, PREG_SET_ORDER, 0 );

	// check if matched found.
	if ( count( $matches ) > 0 ) {
		return true;
	}

	return false;
}

//function to convert google font field values in valid formate and enqueue style
function pgscore_get_google_fonts_css( $google_fonts, $enqueue_google_font = true ) {

	//default value for font fields value
	$fields     = array();
	$text_style = array();

	$google_fonts_data = ciyashop_parse_multi_attribute(
		$google_fonts,
		array(
			'font_style'  => isset( $fields['font_style'] ) ? $fields['font_style'] : '',
			'font_family' => isset( $fields['font_family'] ) ? $fields['font_family'] : '',
		)
	);

	//convert values in to the valid array
	if ( ! empty( $google_fonts_data ) && isset( $google_fonts_data, $google_fonts_data['font_family'], $google_fonts_data['font_style'] ) ) {
		$google_fonts_family       = explode( ':', $google_fonts_data['font_family'] );
		$text_style['font-family'] = 'font-family:' . $google_fonts_family[0] . ';';
		$google_fonts_styles       = explode( ':', $google_fonts_data['font_style'] );
		if ( isset( $google_fonts_styles[1] ) ) {
			$text_style['font-weight'] = 'font-weight:' . $google_fonts_styles[1] . ';';
		}
		if ( isset( $google_fonts_styles[2] ) ) {
			$text_style['font-style'] = 'font-style:' . $google_fonts_styles[2] . ';';
		}
	}

	if ( isset( $google_fonts_data['font_family'] ) ) {
		$google_font_style = 'vc_google_fonts_' . ciyashop_build_safe_css_class( $google_fonts_data['font_family'] );
	}

	//check if already enqueued style
	if ( isset( $google_font_style ) && ! wp_style_is( $google_font_style ) && $enqueue_google_font ) {
		wp_enqueue_style( $google_font_style, '//fonts.googleapis.com/css?family=' . $google_fonts_data['font_family'] );
	}

	return $text_style;
}

/**
 * Truncate String with or without ellipsis.
 *
 * @param string $string      String to truncate
 * @param int    $maxLength   Maximum length of string
 * @param bool   $addEllipsis if True, "..." is added in the end of the string, default true
 * @param bool   $wordsafe    if True, Words will not be cut in the middle
 *
 * @return string Shotened Text
 */
function pgscore_shorten_string( $string, $maxLength, $addEllipsis = true, $wordsafe = false ) {
	if ( empty( $string ) ) {
		$string;
	}
	$ellipsis  = '';
	$maxLength = max( $maxLength, 0 );
	if ( mb_strlen( $string ) <= $maxLength ) {
		return $string;
	}
	if ( $addEllipsis ) {
		$ellipsis   = mb_substr( '...', 0, $maxLength );
		$maxLength -= mb_strlen( $ellipsis );
		$maxLength  = max( $maxLength, 0 );
	}
	if ( $wordsafe ) {
		$string = preg_replace( '/\s+?(\S+)?$/', '', mb_substr( $string, 0, $maxLength ) );
	} else {
		$string = mb_substr( $string, 0, $maxLength );
	}
	if ( $addEllipsis ) {
		$string .= $ellipsis;
	}

	return $string;
}

//function to get the list of id and title of Static Blocks
if ( ! function_exists( 'pgscore_get_static_blocks' ) ) {
	function pgscore_get_static_blocks() {

		$static_blocks = array();

		$args = array(
			'post_type'      => 'static_block',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		);

		$static_block = new WP_Query( $args );

		$static_posts = get_posts( $args );

		foreach ( $static_posts as $post ) {
			// setup_postdata( $post );
			$static_blocks[$post->ID] = esc_html( $post->post_title );
		}

		wp_reset_postdata();

		return $static_blocks;
	}
}

if ( ! function_exists( 'ciyashop_get_custom_headers' ) ) {
	function ciyashop_get_custom_headers() {
		global $wpdb;

		$custom_headers = array();
		$table_name     = $wpdb->prefix . 'cs_header_builder';

		if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) == $table_name ) {

			$header_layout_data = $wpdb->get_results( "SELECT * FROM $table_name" );
			foreach ( $header_layout_data as $header_layout ) {
				$custom_headers[ $header_layout->id ] = $header_layout->name;
			}
			wp_reset_query();
		}
		return $custom_headers;
	}
}

if ( ! function_exists( 'pgscore_exclude_woo_pages' ) ) {
	function pgscore_exclude_woo_pages() {
		$exclude_pages = array();

		// Exclude Home and Blog pages.
		$show_on_front = get_option( 'show_on_front' );
		if ( $show_on_front == 'page' ) {

			$page_on_front  = get_option( 'page_on_front' );
			$page_for_posts = get_option( 'page_for_posts' );

			if ( isset( $page_on_front ) && $page_on_front != '0' ) {
				$exclude_pages[] = $page_on_front;
			}

			if ( isset( $page_for_posts ) && $page_for_posts != '0' ) {
				$exclude_pages[] = $page_for_posts;
			}
		}

		// Exclude WooCommerce pages
		if ( class_exists( 'WooCommerce' ) && is_admin() ) {
			$woocommerce_pages = array(
				'woocommerce_shop_page_id',
				'woocommerce_cart_page_id',
				'woocommerce_checkout_page_id',
				'woocommerce_pay_page_id',
				'woocommerce_thanks_page_id',
				'woocommerce_myaccount_page_id',
				'woocommerce_edit_address_page_id',
				'woocommerce_view_order_page_id',
				'woocommerce_terms_page_id',
			);
			foreach ( $woocommerce_pages as $woocommerce_page ) {
				$woocommerce_page_id = get_option( $woocommerce_page );
				if ( $woocommerce_page_id ) {
					$exclude_pages[] = $woocommerce_page_id;
				}
			}
		}

		return $exclude_pages;
	}
}

add_action( 'admin_init', 'pgscore_updater_init' );

function pgscore_updater_init() {
	if ( isset( $_GET['do_update_pgs_updater'] ) && 'posttype_updater' == $_GET['do_update_pgs_updater'] ) {

		$pgs_posttype_updater = get_option( 'pgs_posttype_updated', false );

		if ( ! $pgs_posttype_updater ) {
			pgs_post_type_update();
		}

		$send = admin_url( 'admin.php?page=ciyashop-panel' );
		wp_redirect( $send );
		exit();
	}
}

if ( ! function_exists( 'pgscore_add_metafield' ) ) {
	/**
	 * Add custom metafields.
	 */
	function pgscf_add_field_group( $field_group ) {
		new Pgs_Meataboxs( $field_group );
	}
}

function pgs_post_type_update() {
	global $wpdb;
	$table = $wpdb->prefix . 'posts';
	$data  = array( 'post_type' => 'static_block' );
	$where = array( 'post_type' => 'cms_block' );

	$update = $wpdb->update( $table, $data, $where );

	if ( false === $update ) {
		wp_die( __( 'Error in run the updater.', 'pgs-core' ) );
	} else {
		update_option( 'pgs_posttype_updated', true );
	}
}

if ( ! function_exists( 'pgscore_get_instagram_image' ) ) {

	/**
	 * Get instagram image.
	 */
	function pgscore_get_instagram_image( $item_count = 12 ) {

		$images_data = array();

		$instagram_medias = get_option( 'pgs_instawp_user_medias' );
		$app_id           = get_option( 'pgs_instawp_app_id' );
		$app_secret       = get_option( 'pgs_instawp_app_secret' );
		$access_token     = get_option( 'pgs_instawp_access_token' );

		if (
			! $instagram_medias
			|| ( empty( $app_id ) || empty( $app_secret ) || empty( $access_token ) )
		) {
			return $images_data;
		}

		// Return if no images found
		if ( count( $instagram_medias ) === 0 ) {
			return $images_data;
		}

		$images_data = $instagram_medias;

		if ( count( $instagram_medias ) > $item_count ) {
			$images_data = array_slice( $instagram_medias, 0, $item_count );
		}

		return $images_data;
	}
}
if ( ! function_exists( 'pgscore_info_box_steps_number' ) ) {

	/**
	 * Get info box steps number
	 */
	function pgscore_info_box_steps_number( $numkey = false ) {
		$steps_number = array();
		foreach ( range( 1, 99 ) as $number ) {
			$number_k = ( $number < 10 && ! $numkey ) ? "0{$number}" : "$number";
			$number_v = ( $number < 10 ) ? "0{$number}" : "$number";

			$steps_number[ $number_k ] = $number_v;
		}

		return $steps_number;
	}
}

if ( ! function_exists( 'pgscore_get_custom_footers' ) ) {
	/**
	 * Get the list of custom footers
	 */
	function pgscore_get_custom_footers() {
		global $wpdb;

		$custom_footers = array();
		$table_name     = $wpdb->prefix . 'cs_footer_builder';

		if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table_name ) ) === $table_name ) {
			$header_layout_data = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'cs_footer_builder' );
			foreach ( $header_layout_data as $header_layout ) {
				$custom_footers[ $header_layout->id ] = $header_layout->name;
			}
		}
		return $custom_footers;
	}
}

if ( ! function_exists( 'pgscore_search_post_type' ) ) {
	/**
	 * set the post type for search
	 */
	function pgscore_search_post_type( $query ) {
		if ( $query->is_main_query() && $query->is_search() ) {
			if ( isset( $_GET['post_type'] ) && $_GET['post_type'] ) {
				$query->set( 'post_type', sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) );
			}
		}
		return $query;
	}
}
add_filter( 'pre_get_posts', 'pgscore_search_post_type' );

/**
 * Get current page URL with various filtering props supported by WC.
 *
 * @return string
 * @since  3.3.0
 */
function pgs_core_get_shop_page_url() {
	if ( class_exists( 'Automattic\Jetpack\Constants' ) && Automattic\Jetpack\Constants::is_defined( 'SHOP_IS_ON_FRONT' ) ) {
		$link = home_url();
	} elseif ( is_shop() ) {
		$link = get_permalink( wc_get_page_id( 'shop' ) );
	} elseif ( is_product_category() ) {
		$link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
	} elseif ( is_product_tag() ) {
		$link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
	} else {
		$queried_object = get_queried_object();
		$link           = get_term_link( $queried_object->slug, $queried_object->taxonomy );
	}

	// Min/Max.
	if ( isset( $_GET['min_price'] ) ) {
		$link = add_query_arg( 'min_price', wc_clean( wp_unslash( $_GET['min_price'] ) ), $link );
	}

	if ( isset( $_GET['max_price'] ) ) {
		$link = add_query_arg( 'max_price', wc_clean( wp_unslash( $_GET['max_price'] ) ), $link );
	}

	// Order by.
	if ( isset( $_GET['orderby'] ) ) {
		$link = add_query_arg( 'orderby', wc_clean( wp_unslash( $_GET['orderby'] ) ), $link );
	}

	/**
	 * Search Arg.
	 * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
	 */
	if ( get_search_query() ) {
		$link = add_query_arg( 's', rawurlencode( htmlspecialchars_decode( get_search_query() ) ), $link );
	}

	// Post Type Arg.
	if ( isset( $_GET['post_type'] ) ) {
		$link = add_query_arg( 'post_type', wc_clean( wp_unslash( $_GET['post_type'] ) ), $link );

		// Prevent post type and page id when pretty permalinks are disabled.
		if ( is_shop() ) {
			$link = remove_query_arg( 'page_id', $link );
		}
	}

	// Min Rating Arg.
	if ( isset( $_GET['rating_filter'] ) ) {
		$link = add_query_arg( 'rating_filter', wc_clean( wp_unslash( $_GET['rating_filter'] ) ), $link );
	}

	// All current filters.
	if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) { // phpcs:ignore Squiz.PHP.DisallowMultipleAssignments.FoundInControlStructure, WordPress.CodeAnalysis.AssignmentInCondition.Found
		foreach ( $_chosen_attributes as $name => $data ) {
			$filter_name = wc_attribute_taxonomy_slug( $name );
			if ( ! empty( $data['terms'] ) ) {
				$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
			}
			if ( 'or' === $data['query_type'] ) {
				$link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
			}
		}
	}

	return apply_filters( 'ciyashop_widget_get_shop_page_url', $link );
}

/**
 * PGS Core ajax action functions.
 *
 * @package PGS Core
 */
add_action( 'wp_ajax_pgs_ajax_select_autocomplete', 'pgscore_elementor_control_pgs_ajax_select_callback' );
add_action( 'wp_ajax_nopriv_pgs_ajax_select_autocomplete', 'pgscore_elementor_control_pgs_ajax_select_callback' );

/**
 * Get Ajax select autocomplete data.
 * Get ajax select autocomplete data to show in elementor editor panel in select2 ajax field.
 *
 * @return void
 */
function pgscore_elementor_control_pgs_ajax_select_callback() {
	$results   = array();
	$data      = array(
		'results' => array(),
	);
	$post_list = array();
	$debug     = false;

	if ( $debug ) {
		$data['post_data'] = $_POST;
	}

	// Check for nonce security.
	if ( ! wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) ) {
		$data['error'] = esc_html__( 'Unable to verify security nonce.', 'pgs-core' );
		wp_send_json( $data );
		exit();
	}

	$source_name  = ( isset( $_POST['source_name'] ) && ! empty( $_POST['source_name'] ) ) ? sanitize_text_field( wp_unslash( $_POST['source_name'] ) ) : 'any';
	$source_type  = ( isset( $_POST['source_type'] ) && ! empty( $_POST['source_type'] ) ) ? sanitize_text_field( wp_unslash( $_POST['source_type'] ) ) : 'post';
	$action_type  = ( isset( $_POST['action_type'] ) && ! empty( $_POST['action_type'] ) ) ? sanitize_text_field( wp_unslash( $_POST['action_type'] ) ) : 'search';
	$search_term  = ( isset( $_POST['term'] ) && ! empty( $_POST['term'] ) )               ? sanitize_text_field( wp_unslash( $_POST['term'] ) )        : '';
	$param_name   = ( isset( $_POST['param_name'] ) && ! empty( $_POST['param_name'] ) )   ? sanitize_text_field( wp_unslash( $_POST['param_name'] ) )  : '';
	$ajax_params  = ( isset( $_POST['ajax_params'] ) && ! empty( $_POST['ajax_params'] ) ) ? pgscore_clean( wp_unslash( $_POST['ajax_params'] ) )  : array();
	$selected_ids = ( isset( $_POST['selected'] ) && ! empty( $_POST['selected'] ) )       ? pgscore_clean( wp_unslash( $_POST['selected'] ) )     : array();
	$selected_ids = ( is_string( $selected_ids ) )                                         ? explode( ',', $selected_ids )                              : $selected_ids;

	$source_name_k = sanitize_title_with_dashes( stripslashes( $source_name ) );
	$source_type_k = sanitize_title_with_dashes( stripslashes( $source_type ) );

	$filter_hook_1   = "pgscore_elementor_control_pgs_ajax_select_{$source_name_k}_{$source_type_k}_{$param_name}";
	$filter_hook_2   = "pgscore_elementor_control_pgs_ajax_select_{$source_name_k}_{$source_type_k}";
	$filter_hook_arg = "pgscore_elementor_control_pgs_ajax_select_{$source_name_k}_{$source_type_k}_args";

	if ( has_filter( $filter_hook_1 ) ) {
		$post_list = apply_filters( $filter_hook_1, array(), $source_name, $source_type, $action_type, $param_name, $search_term, $selected_ids, $ajax_params );
	} elseif ( has_filter( $filter_hook_2 ) ) {
		$post_list = apply_filters( $filter_hook_2, array(), $source_name, $source_type, $action_type, $param_name, $search_term, $selected_ids, $ajax_params );
	} else {
		if ( 'post_type' === $source_name ) {
			$post_data = array();
			$args      = array(
				'post_type'      => $source_type,
				'posts_per_page' => -1,
			);

			if ( 'get_titles' === $action_type ) {
				$args['post__in'] = $selected_ids;
			} else {
				if ( ! empty( $search_term ) ) {
					$args['s'] = $search_term;
				}
			}

			$args = apply_filters( $filter_hook_arg, $args, $source_name, $source_type, $action_type, $param_name, $search_term, $selected_ids, $ajax_params );

			if ( ! empty( $args ) ) {

				$the_query = new WP_Query( $args );

				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						global $post;
						$post_data_raw = array(
							'id'   => $post->ID,
							'text' => $post->post_title,
						);
						if ( in_array( $post->ID, $selected_ids ) ) {
							$post_data_raw['selected'] = true;
						}
						$post_data[] = $post_data_raw;
					}
				}
				// Restore original Post Data.
				wp_reset_postdata();
			}
			$post_list = $post_data;
		} elseif ( 'taxonomy' === $source_name ) {
			$tax_data = array();
			$args     = array(
				'hide_empty' => false,
				'orderby'    => 'name',
				'order'      => 'ASC',
				'number'     => '5',
			);

			if ( 'all' !== $source_type ) {
				$args['taxonomy'] = $source_type;
			}

			if ( 'get_titles' === $action_type ) {
				$args['include'] = $selected_ids;
			} else {
				if ( ! empty( $search_term ) ) {
					$args['search'] = $search_term;
				}
			}

			$args = apply_filters( $filter_hook_arg, $args, $source_name, $source_type, $action_type, $param_name, $search_term, $selected_ids, $ajax_params );

			$taxonomies = get_terms( $args );
			if ( ! empty( $taxonomies ) && ! is_wp_error( $taxonomies ) ) {
				foreach ( $taxonomies as $taxonomy ) {
					$tax_data_raw = array(
						'id'   => $taxonomy->term_id,
						'text' => $taxonomy->name,
					);
					if ( in_array( $taxonomy->term_id, $selected_ids ) ) {
						$tax_data_raw['selected'] = true;
					}
					$tax_data[] = $tax_data_raw;
				}
			}

			$post_list = $tax_data;
		} elseif ( 'user' === $source_name ) {
			$user_data = array();
			$args      = array(
				'role' => $source_type,
			);

			if ( 'get_titles' === $action_type ) {
				$args['include'] = $selected_ids;
			}else {
				$args['search'] = "*{$search_term}*";
			}

			$args  = apply_filters( $filter_hook_arg, $args, $source_name, $source_type, $action_type, $param_name, $search_term, $selected_ids, $ajax_params );
			$users = get_users( $args );

			foreach ( $users as $user ) {
				$user_data_raw = array(
					'id'   => $user->ID,
					'text' => $user->display_name,
				);
				if ( in_array( $user->ID, $selected_ids ) ) {
					$user_data_raw['selected'] = true;
				}
				$user_data[] = $user_data_raw;
			}

			$post_list = $user_data;
		} elseif ( 'custom' === $source_name ) {
			$filter_hook_custom_1   = "pgscore_elementor_control_pgs_ajax_select_{$source_name_k}_{$source_type_k}_{$param_name}";
			$filter_hook_custom_2   = "pgscore_elementor_control_pgs_ajax_select_{$source_name_k}_{$source_type_k}";
			if ( has_filter( $filter_hook_custom_1 ) ) {
				$post_list = apply_filters( $filter_hook_custom_1, array(), $source_name, $source_type, $action_type, $param_name, $search_term, $selected_ids, $ajax_params );
			} elseif ( has_filter( $filter_hook_custom_2 ) ) {
				$post_list = apply_filters( $filter_hook_custom_2, array(), $source_name, $source_type, $action_type, $param_name, $search_term, $selected_ids, $ajax_params );
			}
		}
	}

	if ( is_array( $post_list ) && ! empty( $post_list ) ) {
		$data['results'] = $post_list;
	}

	wp_send_json( $data );
	exit();
}

/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 *
 * @param string|array $var Data to sanitize.
 * @return string|array
 */
function pgscore_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'wc_clean', $var );
	} else {
		return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
	}
}
