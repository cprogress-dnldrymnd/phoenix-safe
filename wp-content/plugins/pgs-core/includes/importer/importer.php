<?php
/**
 * Plugin: WordPress Importer
 * Version: 0.7
 *
 * @package WordPress
 * @subpackage Importer
 */

if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
	define('WP_LOAD_IMPORTERS', true);
}

/** Display verbose errors */
if ( ! defined( 'PGSCORE_HELPER_IMPORT_DEBUG' ) ) {
	define( 'PGSCORE_HELPER_IMPORT_DEBUG', false );
}

/** WordPress Import Administration API */
require_once ABSPATH . 'wp-admin/includes/import.php';

if ( ! class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if ( file_exists( $class_wp_importer ) )
		require $class_wp_importer;
}

/** Functions missing in older WordPress versions. */
require_once trailingslashit( PGSCORE_PATH ) . 'includes/importer/compat.php';

/** WXR_Parser class */
require_once trailingslashit( PGSCORE_PATH ) . 'includes/importer/parsers/class-pgscore-helper-wxr-parser.php';

/** WXR_Parser_SimpleXML class */
require_once trailingslashit( PGSCORE_PATH ) . 'includes/importer/parsers/class-pgscore-helper-wxr-parser-simplexml.php';

/** WXR_Parser_XML class */
require_once trailingslashit( PGSCORE_PATH ) . 'includes/importer/parsers/class-pgscore-helper-wxr-parser-xml.php';

/** WXR_Parser_Regex class */
require_once trailingslashit( PGSCORE_PATH ) . 'includes/importer/parsers/class-pgscore-helper-wxr-parser-regex.php';

/** WP_Import class */
require_once trailingslashit( PGSCORE_PATH ) . 'includes/importer/class-pgscore-helper-wp-import.php';

function pgscore_wordpress_importer_init() {
	// load_plugin_textdomain( 'wordpress-importer' );

	/**
	 * WordPress Importer object for registering the import callback
	 * @global Pgscore_Helper_WP_Import $pgscore_wp_import
	 */
	$GLOBALS['pgscore_wp_import'] = new Pgscore_Helper_WP_Import();
	// phpcs:ignore WordPress.WP.CapitalPDangit
	// register_importer( 'wordpress', 'WordPress', wp_kses( __('Import <strong>posts, pages, comments, custom fields, categories, and tags</strong> from a WordPress export file.', 'pgs-core'), array( 'strong' => array() ) ), array( $GLOBALS['pgscore_wp_import'], 'dispatch' ) );
}
add_action( 'admin_init', 'pgscore_wordpress_importer_init' );
