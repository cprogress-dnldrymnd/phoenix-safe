<?php
/**
 * ciyashop footer Builder Class
 *
 * @author      Potenza Team
 * @package     ciyashop
 * @version     1.0.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Ciyashop_Footer_Builder' ) ) {
	/**
	 * Footer builder.
	 */
	class Ciyashop_Footer_Builder {

		/**
		 * Footer builder elements.
		 *
		 * @var $elements
		 */
		public $elements = '';

		public $ciyashop_footer_builder;

		/**
		 * Ciyashop_Footer_Builder construct
		 */
		public function __construct() {

			add_action( 'admin_menu', array( $this, 'register_footer_builder_menu' ) );
			add_action( 'admin_init', array( $this, 'create_footer_builder_table' ) );

			add_action( 'wp_ajax_clone_footer', array( $this, 'clone_footer' ) );
			add_action( 'wp_ajax_nopriv_clone_footer', array( $this, 'clone_footer' ) );

			add_action( 'wp_ajax_save_footer_builder', array( $this, 'save_footer_builder' ) );
			add_action( 'wp_ajax_nopriv_save_footer_builder', array( $this, 'save_footer_builder' ) );

			add_action( 'wp_ajax_delete_footer', array( $this, 'delete_footer' ) );
			add_action( 'wp_ajax_nopriv_delete_footer', array( $this, 'delete_footer' ) );
		}

		/**
		 * Register menu for footer builder.
		 */
		public function register_footer_builder_menu() {
			$this->ciyashop_footer_builder = add_menu_page(
				__( 'Footer Builder', 'pgs-core' ),       // Page Title
				__( 'Footer Builder', 'pgs-core' ),       // Menu Title
				'manage_options',                             // Capability
				'footer-builder',                             // Slug
				array( $this, 'footer_bulder_list' ),         // Callback
				'dashicons-tagcloud',                         // Icon
				50                                            // Position
			);
			add_submenu_page(
				'footer-builder',
				__( 'All Layouts', 'pgs-core' ),
				__( 'All Layouts', 'pgs-core' ),
				'manage_options',
				'footer-builder',
				array( $this, 'footer_bulder_list' )
			);
			add_submenu_page(
				'footer-builder',
				__( 'Layout Setting', 'pgs-core' ),
				__( 'Add New Layout', 'pgs-core' ),
				'manage_options',
				'footer-layout',
				array( $this, 'footer_bulder_create' )
			);
		}

		/**
		 * Footer list.
		 */
		public function footer_bulder_list() {
			require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/footer-builder/footer-layout-lists.php';
		}

		/**
		 * Create the footer layout.
		 */
		public function footer_bulder_create() {
			require_once trailingslashit( PGSCORE_PATH ) . 'includes/admin/footer-builder/footer-layout.php';
		}

		/**
		 * Create the footer builder table.
		 */
		public function create_footer_builder_table() {
			global $wpdb;
			$charset_collate = $wpdb->get_charset_collate();

			$table_name = $wpdb->prefix . 'cs_footer_builder';

			$sql = "CREATE TABLE $table_name (
				  id mediumint(9) NOT NULL AUTO_INCREMENT,
				  name tinytext NOT NULL,
				  value longtext NULL,
				  PRIMARY KEY  (id)
				) $charset_collate;";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );

		}

		/**
		 * Save footer builder.
		 */
		public function save_footer_builder() {
			$data = isset( $_POST['footer_settings'] ) ? wp_unslash( $_POST['footer_settings'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

			if ( empty( $data ) ) {
				return;
			}

			global $wpdb;

			$table_name = $wpdb->prefix . 'cs_footer_builder';
			$title      = ( isset( $data['layout_name'] ) ) ? $data['layout_name'] : '';
			$footer_id  = ( isset( $data['footer_id'] ) ) ? $data['footer_id'] : '';
			$value      = serialize( $data );
			$redirect   = false;

			if ( $footer_id > 0 ) {
				$footer_layout_data = $wpdb->get_results(
					$wpdb->prepare(
						'
						SELECT * FROM ' . $wpdb->prefix . 'cs_footer_builder
						WHERE id = %d
						',
						$footer_id
					)
				);

				if ( ! empty( $footer_layout_data ) ) {
					$wpdb->update(
						$table_name,
						array(
							'name'  => $title,
							'value' => $value,
						),
						array( 'id' => $footer_id )
					);
					$redirect = true;
				}
			} else {
				$wpdb->insert(
					$table_name,
					array(
						'name'  => $title,
						'value' => $value,
					)
				);
				$footer_id = $wpdb->insert_id;
				$redirect  = true;
			}

			$return_data = array(
				'footer_id' => $footer_id,
				'redirect'  => $redirect,
			);

			echo json_encode( $return_data );
			exit();
		}

		/**
		 * Clone footer.
		 */
		public function clone_footer() {
			global $wpdb;

			$hdr_id = isset( $_POST['footerId'] ) ? (int) $_POST['footerId'] : '';

			$table_name         = $wpdb->prefix . 'cs_footer_builder';
			$footer_layout_data = $wpdb->get_results(
				$wpdb->prepare(
					'
					SELECT * FROM ' . $wpdb->prefix . 'cs_footer_builder
					WHERE id = %d
					',
					$hdr_id
				)
			);

			$footer_builder_title = $footer_layout_data[0]->name;
			$footer_builder_value = $footer_layout_data[0]->value;

			$wpdb->insert(
				$table_name,
				array(
					'name'  => $footer_builder_title . ' ( ' . __( 'Copy', 'pgs-core' ) . ' )',
					'value' => $footer_builder_value,
				)
			);

			$footer_id = $wpdb->insert_id;

			$return_data = array(
				'footer_title' => $footer_builder_title . ' ( ' . __( 'Copy', 'pgs-core' ) . ' )',
				'footer_id'    => $footer_id,
			);

			echo json_encode( $return_data );
			exit();
		}

		/**
		 * Delete the footer.
		 */
		public function delete_footer() {
			$hdr_id = isset( $_POST['footerId'] ) ? (int) $_POST['footerId'] : '';

			if ( empty( $hdr_id ) ) {
				return;
			}

			global $wpdb;
			$table_name = $wpdb->prefix . 'cs_footer_builder';

			$wpdb->delete( $table_name, array( 'id' => $hdr_id ) );

			$return_data = array(
				'success' => true,
			);

			echo json_encode( $return_data );

			exit();
		}
	}
}

new Ciyashop_Footer_Builder();
