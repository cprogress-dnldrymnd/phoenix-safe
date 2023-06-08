<?php do_action( "pgssl_admin_ui_fail_start" ); ?>
<div class="pgssl-settings-meta-box-wrap">
	<div style="background: none repeat scroll 0 0 #fff;border: 1px solid #e5e5e5;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);padding:20px;">
		<h1><?php _e("PGS Social Login - FAIL!", 'pgs-core' ) ?></h1>

		<hr />

		<p>
			<?php _e('Despite the efforts, put into <b>PGS Social Login</b> in terms of reliability, portability, and maintenance by the plugin <a href="http://profiles.wordpress.org/miled/" target="_blank">author</a> and <a href="https://github.com/hybridauth/WordPress-Social-Login/graphs/contributors" target="_blank">contributors</a>', 'pgs-core') ?>.
			<b style="color:red;"><?php _e('Your server failed the requirements check for this plugin', 'pgs-core') ?>:</b>
		</p>

		<p>
			<?php _e('These requirements are usually met by default by most "modern" web hosting providers, however some complications may occur with <b>shared hosting</b> and, or <b>custom wordpress installations</b>', 'pgs-core') ?>.
		</p>

		<p>
			<?php echo __("The minimum server requirements are", 'pgs-core') ?>:
		</p>

		<ul style="margin-left:60px;">
			<li><?php echo __("PHP >= 7.2.0 installed", 'pgs-core') ?></li>
			<li><?php echo __("PGSSL Endpoint URLs reachable", 'pgs-core') ?></li>
			<li><?php echo __("PHP's default SESSION handling", 'pgs-core') ?></li>
			<li><?php echo __("PHP/CURL/SSL Extension enabled", 'pgs-core') ?></li>
			<li><?php echo __("PHP/JSON Extension enabled", 'pgs-core') ?></li>
			<li><?php echo __("PHP/REGISTER_GLOBALS Off", 'pgs-core') ?></li>
			<li><?php echo __("jQuery installed on WordPress backoffice", 'pgs-core') ?></li>
		</ul>
	</div>
	<?php
	include_once( trailingslashit( PGS_SOCIAL_LOGIN_ABS_PATH ) . 'includes/admin/components/tools/components.tools.actions.job.php' );

	pgssl_component_tools_do_diagnostics();
	?>
</div>
<style>.pgssl-settings-meta-box-wrap .button-secondary { display:none; }</style>
<?php
do_action( "pgssl_admin_ui_fail_end" );
