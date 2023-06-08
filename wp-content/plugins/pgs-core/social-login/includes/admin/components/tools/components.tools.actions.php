<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function pgssl_component_tools_sections() {
	$sections = array(
		'auth_playground'    => 'pgssl_component_tools_auth_playground'    ,
		'diagnostics'        => 'pgssl_component_tools_diagnostics'        ,
		'system_information' => 'pgssl_component_tools_system_information' ,
		'repair_pgssl_tables'  => 'pgssl_component_tools_repair_pgssl_tables'  ,
		'debug_mode'         => 'pgssl_component_tools_debug_mode'         ,
		'development_mode'   => 'pgssl_component_tools_development_mode'   ,
		'uninstall'          => 'pgssl_component_tools_uninstall'          ,
	);

	$sections = apply_filters( 'pgssl_component_tools_alter_sections', $sections );

	foreach( $sections as $section => $action ) {
		add_action( 'pgssl_component_tools_sections', $action );
	}

	// HOOKABLE:
	do_action( 'pgssl_component_tools_sections' );
}

function pgssl_component_tools_auth_playground() {
?>
<div class="stuffbox">
	<h3>
		<label><?php echo __("Authentication Playground", 'pgs-core') ?></label>
	</h3>
	<div class="inside">
		<p>
			<?php echo __('Authentication Playground will let you authenticate with the enabled social networks without creating any new user account. This tool will also give you a direct access to social networks apis via a lightweight console', 'pgs-core') ?>.
		</p>

		<a class="button-primary"  href="<?php echo wp_nonce_url( 'admin.php?page=pgssl_settings&pgssl_page=auth-paly'); ?>"><?php echo __("Go to the authentication playground", 'pgs-core') ?></a>
	</div>
</div>
<?php
}

function pgssl_component_tools_diagnostics() {
?>
<div class="stuffbox">
	<h3>
		<label><?php echo __("PGS Social Login Diagnostics", 'pgs-core') ?></label>
	</h3>
	<div class="inside">
		<p>
			<?php echo __('This tool will check for the common issues and for the minimum system requirements', 'pgs-core') ?>.
		</p>

		<a class="button-primary" href="<?php echo wp_nonce_url( 'admin.php?page=pgssl_settings&pgssl_page=tools&do=diagnostics'); ?>"><?php echo __("Run PGS Social Login Diagnostics", 'pgs-core') ?></a>
	</div>
</div>
<?php
}

function pgssl_component_tools_system_information() {
?>
<div class="stuffbox">
	<h3>
		<label><?php echo __("System information", 'pgs-core') ?></label>
	</h3>
	<div class="inside">
		<p>
			<?php echo __('This tool will gather and display your website and server info. Please include these information when posting support requests, it will help me immensely to better understand any issues', 'pgs-core') ?>.
		</p>

		<a class="button-primary"  href="<?php echo wp_nonce_url( 'admin.php?page=pgssl_settings&pgssl_page=tools&do=sysinfo'); ?>"><?php echo __("Display your system information", 'pgs-core') ?></a>
	</div>
</div>
<?php
}

function pgssl_component_tools_repair_pgssl_tables() {
?>
<a name="repair-tables"></a>
<div class="stuffbox">
	<h3>
		<label><?php echo __("Repair PGS Social Login tables", 'pgs-core') ?></label>
	</h3>
	<div class="inside">
		<p>
			<?php echo __('This will attempt recreate PGS Social Login databases tables if they do not exist and will also add any missing field', 'pgs-core') ?>.
		</p>

		<a class="button-primary" href="<?php echo wp_nonce_url( 'admin.php?page=pgssl_settings&pgssl_page=tools&do=repair'); ?>"><?php echo __("Repair PGS Social Login databases tables", 'pgs-core') ?></a>
	</div>
</div>
<?php
}

function pgssl_component_tools_debug_mode() {
	$pgssl_settings_debug_mode_enabled = get_option( 'pgssl_settings_debug_mode_enabled' );
?>
<a name="debug-mode"></a>
<div class="stuffbox">
	<h3>
		<label><?php echo __("Debug mode", 'pgs-core') ?></label>
	</h3>
	<div class="inside">
		<p>
			<?php echo __('The <b>Debug mode</b> is an internal development tool built to track every action made by PGS Social Login during the authentication proces, which can be useful when debugging this plugin but note that it is highly technical and not documented', 'pgs-core') ?>.
		</p>

		<p>
			<?php echo __('When Debug mode is enabled and set to <code>Log actions in a file</code>, PGS Social Login will attempt to generate its log files under <em>/wp-content/uploads/pgssl-logs</em>', 'pgs-core') ?>.
		</p>

		<p>
			<?php echo __('When Debug mode is enabled and set to <code>Log actions to database</code>, will create a new database table <code>pgssl_watchdog</code> and insert all actions names and arguments', 'pgs-core') ?>.
		</p>

		<p>
			<?php echo __('For more information, refer to PGS Social Login documentation under Advanced Troubleshooting &gt; <a href="http://miled.github.io/wordpress-social-login/troubleshooting-advanced.html" target="_blank">Debug Mode</a>', 'pgs-core') ?>.
		</p>

		<form method="post" id="pgssl_setup_form" action="options.php">
			<?php settings_fields( 'pgssl_settings-group-debug' ); ?>

			<select name="pgssl_settings_debug_mode_enabled">
				<option <?php if(    ! $pgssl_settings_debug_mode_enabled ) echo "selected"; ?> value="0"><?php echo __("Disabled", 'pgs-core') ?></option>
				<option <?php if( $pgssl_settings_debug_mode_enabled == 1 ) echo "selected"; ?> value="1"><?php echo __("Enabled &mdash; Log actions in a file", 'pgs-core') ?></option>
				<option <?php if( $pgssl_settings_debug_mode_enabled == 2 ) echo "selected"; ?> value="2"><?php echo __("Enabled &mdash; Log actions to database", 'pgs-core') ?></option>
			</select>

			<input type="submit" class="button-primary" value="<?php echo esc_attr__("Save Settings", 'pgs-core') ?>" />

			<?php if( $pgssl_settings_debug_mode_enabled ): ?>
				<a class="button-secondary" href="admin.php?page=pgssl_settings&pgssl_page=watchdog"><?php echo __('View PGS Social Login logs', 'pgs-core') ?></a>
			<?php endif; ?>
		</form>
	</div>
</div>
<?php
}

function pgssl_component_tools_development_mode() {
	$pgssl_settings_development_mode_enabled = get_option( 'pgssl_settings_development_mode_enabled' );
?>
<a name="dev-mode"></a>
<div class="stuffbox">
	<h3>
		<label><?php echo __("Development mode", 'pgs-core') ?></label>
	</h3>
	<div class="inside">
		<p>
			<?php echo __('When <b>Development Mode</b> is enabled, this plugin will display a debugging area on the footer of admin interfaces. <b>Development Mode</b> will also try generate and display a technical reports when something goes wrong. This report can help you figure out the root of the issues you may runs into', 'pgs-core') ?>.
		</p>

		<p>
			<?php echo __('Please, do not enable <b>Development Mode</b>, unless you are a developer or you have basic PHP knowledge', 'pgs-core') ?>.
		</p>

		<p>
			<?php echo __('For security reasons, <b>Development Mode</b> will auto switch to <b>Disabled</b> each time the plugin is <b>reactivated</b>', 'pgs-core') ?>.
		</p>

		<p>
			<?php echo __('It\'s highly recommended to keep the <b>Development Mode</b> <b style="color:#da4f49">Disabled</b> on production as it would be a security risk otherwise', 'pgs-core') ?>.
		</p>

		<p>
			<?php echo __('For more information, refer to PGS Social Login documentation under Advanced Troubleshooting &gt; <a href="http://miled.github.io/wordpress-social-login/troubleshooting-advanced.html" target="_blank">Development Mode</a>', 'pgs-core') ?>.
		</p>

		<form method="post" id="pgssl_setup_form" action="options.php" <?php if( ! $pgssl_settings_development_mode_enabled ) { ?>onsubmit="return confirm('Do you really want to enable Development Mode?\n\nPlease confirm that you have read and understood the abovementioned by clicking OK.');"<?php } ?>>
			<?php settings_fields( 'pgssl_settings-group-development' ); ?>

			<select name="pgssl_settings_development_mode_enabled">
				<option <?php if( ! $pgssl_settings_development_mode_enabled ) echo "selected"; ?> value="0"><?php echo __("Disabled", 'pgs-core') ?></option>
				<option <?php if(   $pgssl_settings_development_mode_enabled ) echo "selected"; ?> value="1"><?php echo __("Enabled", 'pgs-core') ?></option>
			</select>

			<input type="submit" class="button-danger" value="<?php echo esc_attr__("Save Settings", 'pgs-core') ?>" />
		</form>
	</div>
</div>
<?php
}

function pgssl_component_tools_uninstall() {
?>
<div class="stuffbox">
	<h3>
		<label><?php echo __("Uninstall", 'pgs-core') ?></label>
	</h3>
	<div class="inside">
		<p>
			<?php echo __('This will permanently delete all Wordpress Social Login tables and stored options from your WordPress database', 'pgs-core') ?>.
			<?php echo __('Once you delete PGS Social Login database tables and stored options, there is NO going back. Please be certain', 'pgs-core') ?>.
		</p>

		<a class="button-danger" href="<?php echo wp_nonce_url( 'admin.php?page=pgssl_settings&pgssl_page=tools&do=uninstall'); ?>" onClick="return confirm('Do you really want to Delete all Wordpress Social Login tables and options?\n\nPlease confirm that you have read and understood the abovementioned by clicking OK.');"><?php echo __("Delete all Wordpress Social Login tables and options", 'pgs-core') ?></a>
	</div>
</div>
<?php
}
