<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function pgssl_component_config_sidebar() {
	$sections = array(
		'save_settings'         => 'pgssl_component_config_sidebar_save_settings',
	);

	$sections = apply_filters( 'pgssl_component_config_sidebar_alter_sections', $sections );

	foreach( $sections as $section => $action ) {
		add_action( 'pgssl_component_config_sidebar_sections', $action );
	}

	do_action( "pgssl_component_config_sidebar_start" );
	?>
	<div>
		<?php do_action( 'pgssl_component_config_sidebar_sections' );?>
	</div>
	<?php
	do_action( "pgssl_component_config_sidebar_end" );
}

function pgssl_component_config_sidebar_save_settings() {
	?>
	<div class="postbox">
		<div class="inside">
			<h3><?php echo __("Save Settings", 'pgs-core') ?></h3>
			<div style="padding:0 20px;">
				<input type="submit" class="button-primary" value="<?php echo esc_attr__("Save Settings", 'pgs-core') ?>" />
			</div>
		</div>
	</div>
	<?php
}
