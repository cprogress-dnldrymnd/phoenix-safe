<?php
/**
 * Footer Builder layout list
 *
 * @package ciyashop Core
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wpdb;

$footer_lists = '';
$table_name   = $wpdb->prefix . 'cs_footer_builder';

if ( $wpdb->get_var( 'SHOW TABLES LIKE "' . $wpdb->prefix . 'cs_footer_builder"' ) === $table_name ) {
	$footer_lists = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'cs_footer_builder' );
}
?>

<div class="wrap">
	<h1 class="wp-heading-inline"> <?php esc_html_e( 'Footer Builder', 'pgs-core' ); ?> </h1>
	<hr class="wp-footer-end"/>
	<h2 class="screen-reader-text"><?php esc_html_e( 'Footer layout List', 'pgs-core' ); ?></h2>
	<div class="poststuff">
		<div class="footer-layout-list">
			<div class="footer-layout-list-title">
				<h3 class="footer-list-title"> <?php esc_html_e( 'Footer Layout List', 'pgs-core' ); ?> </h3>
				<p class="description">
				<?php
				printf(
					wp_kses(
						/* translators: %1$s is replaced with "string" */
						__( 'Here you can manage your footer layouts and create new ones. You can set which footer to use for all pages using theme settings in <a href="%s" target="_blank">Theme Options</a>', 'pgs-core' ),
						array(
							'a' => array(
								'href'   => true,
								'target' => true,
							),
						)
					),
					esc_url( admin_url( 'themes.php?page=ciyashop-options&tab=9' ) )
				)
				?>
				</p>
			</div>
		</div>
		<div class="footer-layout-lists-cover">
			<ul class="footer-layout-lists">
				<li class="footer-layout-list-item footer-layout-list-create">
					<div class="footer-layout-actions">
						<a href="<?php echo esc_url( admin_url() . 'admin.php?page=footer-layout' ); ?>" class="button button-primary button-large page-title-action add-footer-layout"> <span class="dashicons dashicons-plus-alt"></span> <?php esc_html_e( 'Create New', 'pgs-core' ); ?></a>
					</div>
				</li>
				<?php
				if ( ! empty( $footer_lists ) ) {
					foreach ( $footer_lists as $footer_list ) {
						?>
						<li class="footer-layout-list-item">
							<div class="footer-layout-list-item-inner">
								<a href="<?php echo esc_url( admin_url() . 'admin.php?page=footer-layout&footer_id=' . $footer_list->id ); ?>"><?php echo esc_html( $footer_list->name ); ?></a>
								<div class="footer-layout-list-actions">
									<a href="<?php echo esc_url( admin_url() . 'admin.php?page=footer-layout&footer_id=' . $footer_list->id ); ?>" class="footer-layout-action footer-layout-edit" title="<?php esc_html_e( 'Edit Layout', 'pgs-core' ); ?>" ><span class="dashicons dashicons-edit"></span></a>
									<a href="<?php echo esc_url( admin_url() . 'admin.php?page=footer-layout&footer_id=' . $footer_list->id ); ?>" class="footer-layout-action footer-layout-clone" data-footer_id="<?php echo esc_attr( $footer_list->id ); ?>" title="<?php esc_html_e( 'Clone Layout', 'pgs-core' ); ?>"><span class="dashicons dashicons-admin-page"></span></a>
									<a href="javascript:void(0)" class="footer-layout-action footer-layout-delete" data-footer_id="<?php echo esc_attr( $footer_list->id ); ?>" title="<?php esc_html_e( 'Delete Layout', 'pgs-core' ); ?>"><span class="dashicons dashicons-trash"></span></a>
								</div>
							</div>
						</li>
						<?php
					}
				}
				?>
			</ul>
		</div>
	</div>
</div>
