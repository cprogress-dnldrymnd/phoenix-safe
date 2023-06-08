<?php
/**
* Watchdog - Log viewer.
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function pgssl_component_watchdog() {
 	if( ! get_option( 'pgssl_settings_debug_mode_enabled' ) ) {
		return __("<p>Debug mode is disabled.</p>", 'pgs-core');
	}

	if( get_option( 'pgssl_settings_debug_mode_enabled' ) == 1 ) {
		return pgssl_component_watchdog_files();
	}

	pgssl_component_watchdog_database();
}

pgssl_component_watchdog();

function pgssl_component_watchdog_files() {
?>
<div style="padding: 5px 20px; border: 1px solid #ddd; background-color: #fff;">
	<h3></h3>
	<h3><?php echo __("Authentication log files viewer", 'pgs-core') ?></h3>

	<form method="post" action="" style="float: right;margin-top:-45px">
		<select name="log_file">
			<option value=""> &mdash; <?php echo __("Select a log file to display", 'pgs-core') ?> &mdash;</option>

			<?php
				$wp_upload_dir = wp_upload_dir();
				$pgssl_path = $wp_upload_dir['basedir'] . '/pgssl-logs';

				$selected = isset( $_REQUEST['log_file'] ) ? $_REQUEST['log_file'] : '';

				$files = scandir( $pgssl_path );

				if( $files )
				foreach( $files as $file ) {
					if( in_array( $file, array( '.', '..', '.htaccess', 'index.html' ) ) )
					continue;

					?>
						<option value="<?php echo $file; ?>" <?php if( $selected == $file ) echo 'selected'; ?>><?php echo $file; ?></option>
					<?php
				}
			?>
		</select>

		<input type="submit" value="<?php echo esc_attr__("View", 'pgs-core') ?>" class="button">
	</form>

	<textarea rows="25" cols="70" wrap="off" style="width:100%;height:580px;margin-bottom:15px;font-family: monospace;font-size: 12px;"><?php if( $selected && file_exists( $pgssl_path . '/' . $selected ) ) echo file_get_contents( $pgssl_path . '/' . $selected ); ?></textarea>
</div>
<?php
}

function pgssl_component_watchdog_database() {
	$assets_base_url = PGS_SOCIAL_LOGIN_PLUGIN_URL . 'assets/img/icons/16x16/';

	global $wpdb, $pgssl_tbl_watchdog;

	// If action eq delete user profiles
	if( isset( $_REQUEST['delete'] ) && isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( $_REQUEST['_wpnonce'] ) ) {
		if( $_REQUEST['delete'] == 'log' ) {
			$wpdb->query( "TRUNCATE TABLE {$wpdb->prefix}{$pgssl_tbl_watchdog}" );
		}
	}
?>
<style>
	.widefatop td, .widefatop th { border: 1px solid #DDDDDD; }
	.widefatop th label { font-weight: bold; }
</style>

<div style="padding: 5px 20px; border: 1px solid #ddd; background-color: #fff;">

	<h3><?php echo __("Authentication log viewer - latest activity", 'pgs-core') ?></h3>

	<p style="float: right;margin-top:-45px">
		<?php
			$delete_url = wp_nonce_url( 'admin.php?page=pgssl_settings&pgssl_page=watchdog&delete=log' );
		?>
		<a class="button button-secondary" style="background-color: #da4f49;border-color: #bd362f;text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);color: #ffffff;" href="<?php echo $delete_url ?>" onClick="return confirm('Are you sure?');"><?php echo __("Delete PGSSL Log", 'pgs-core'); ?></a>
	</p>

	<hr />

	<?php
		$list_sessions = $wpdb->get_results( "SELECT user_ip, session_id, provider, max(id) as max_id FROM `{$wpdb->prefix}{$pgssl_tbl_watchdog}` GROUP BY session_id, provider ORDER BY max_id DESC LIMIT 25" );

		if( ! $list_sessions ) {
			echo __("<p>No log found!</p>", 'pgs-core');
		} else {
			foreach( $list_sessions as $seesion_data ) {
				$user_ip    = $seesion_data->user_ip;
				$session_id = $seesion_data->session_id;
				$provider   = $seesion_data->provider;

				if( ! $provider ) {
					continue;
				}

				?>
				<div style="padding: 15px; margin-bottom: 8px; border: 1px solid #ddd; background-color: #fff;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
					<img src="<?php echo $assets_base_url . strtolower( $provider ) . '.png' ?>" style="vertical-align:top;width:16px;height:16px;" /> <?php echo sprintf( __("<b>%s</b> : %s - %s", 'pgs-core'), $provider, $user_ip, $session_id ) ?>
				</div>

				<table class="wp-list-table widefat widefatop">
					<tr>
						<th>#</th>
						<th>Action</th>
						<th>Args</th>
						<th>Time</th>
						<th>User</th>
						<th style="text-align:center">&#916;</th>
					</tr>
			<?php
				$list_calls = $wpdb->get_results( "SELECT * FROM `{$wpdb->prefix}{$pgssl_tbl_watchdog}` WHERE session_id = '$session_id' AND provider = '$provider' ORDER BY id ASC LIMIT 500" );

				$abandon    = false;
				$newattempt = false;
				$newsession = true;
				$functcalls = 0;
				$exectime   = 0;
				$oexectime  = 0;
				$texectime  = 0;

				foreach( $list_calls as $call_data ) {
					$exectime = (float) $call_data->created_at - ( $oexectime ? $oexectime : (float) $call_data->created_at );
					$oexectime = (float) $call_data->created_at;
					$texectime += $exectime;

					$call_data->action_args = json_decode( $call_data->action_args );

					$newattempt = false;

					$action_name_uid = uniqid();

					$action_desc = 'N.A.';
					?>
					<tr  style="<?php if( stristr( $call_data->action_name, 'dbg:' ) ) echo 'background-color:#fffcf5;'; ?> <?php if( 'pgssl_render_login_form_user_loggedin' == $call_data->action_name || $call_data->action_name == 'pgssl_hook_process_login_before_wp_set_auth_cookie' ) echo 'background-color:#edfff7;'; ?><?php if( 'pgssl_process_login_complete_registration_start' == $call_data->action_name ) echo 'background-color:#fefff0;'; ?><?php if( 'pgssl_process_login_render_error_page' == $call_data->action_name || $call_data->action_name == 'pgssl_process_login_render_notice_page' ) echo 'background-color:#fffafa;'; ?>">
						<td nowrap width="10">
							<?php echo $call_data->id; ?>
						</td>
						<td nowrap width="350">
							<span style="color:#<?php
											if( stristr( $call_data->action_name, 'dbg:' ) ){
												echo '333333';
											}

											if( 'pgssl_hook_process_login_before_wp_safe_redirect' == $call_data->action_name ){
												echo 'a6354b';
											}

											if( 'pgssl_hook_process_login_before_wp_set_auth_cookie' == $call_data->action_name ){
												echo '9035a6';
											}

											if( 'pgssl_process_login_render_error_page' == $call_data->action_name ){
												echo 'f50505';
											}

											if( 'pgssl_process_login_render_notice_page' == $call_data->action_name ){
												echo 'fa1797';
											}
										?>"
										><?php echo $call_data->action_name; ?></span>
						</td>
						<td>
							<span style="float:right;"><a style="font-size:25px" href="javascript:void(0);" onClick="action_args_toggle( '<?php echo $action_name_uid; ?>' )">+</a></span>
							<a href="javascript:alert('<?php echo $call_data->url; ?>');">
								<small>
									<?php
										echo substr( $call_data->url, 0, 100 );
										echo strlen( $call_data->url ) > 100 ? '...' : '';
									?>
								</small>
							</a>
							<pre style="display:none; overflow:scroll; background-color:#fcfcfc; color:#808080;font-size:11px;max-width:750px;" class="action_args_<?php echo $action_name_uid; ?>"><?php echo htmlentities( print_r( $call_data->action_args, true ) ); ?></pre>
						</td>
						<td nowrap width="115">
							<?php echo date( "Y-m-d h:i:s", $call_data->created_at ); ?>
						</td>
						<td nowrap width="40">
							<?php if( $call_data->user_id ) echo '<a href="admin.php?page=pgssl_settings&pgssl_page=users&uid=' . $call_data->user_id . '">#' . $call_data->user_id . '</a>'; ?>
						</td>
						<td nowrap width="10" style="<?php if( $exectime > 0.5 ) echo 'color: #f44 !important;'; ?>">
							<?php echo number_format( $exectime, 3, '.', '' ); ?>
						</td>
					</tr>
				<?php
				}
			?>
			</table>
			<?php
				echo number_format( $texectime, 3, '.', '' );
				echo '<br />';
			}
		}
	?>
	<script>
		function action_args_toggle( action ) {
			jQuery('.action_args_' + action ).toggle();

			return false;
		}
	</script>
</div>
<?php
}
