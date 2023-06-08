<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function pgssl_component_contacts_settings_setup() {
	$sections = array(
		'google'    => 'pgssl_component_contacts_settings_setup_google',
		'facebook'  => 'pgssl_component_contacts_settings_setup_facebook',
		'twitter'   => 'pgssl_component_contacts_settings_setup_twitter',
		'linkedin'  => 'pgssl_component_contacts_settings_setup_linkedin',
		'live'      => 'pgssl_component_contacts_settings_setup_live',
		'vkontakte' => 'pgssl_component_contacts_settings_setup_vkontakte',
	);

	$sections = apply_filters( 'pgssl_component_buddypress_setup_alter_sections', $sections );

	foreach( $sections as $section => $action ) {
		add_action( 'pgssl_component_contacts_settings_setup_sections', $action );
	}
?>
<div>
	<?php
		// HOOKABLE:
		do_action( 'pgssl_component_contacts_settings_setup_sections' );
	?>

	<br />

	<div style="margin-left:5px;margin-top:-20px;">
		<input type="submit" class="button-primary" value="<?php echo esc_attr__("Save Settings", 'pgs-core') ?>" />
	</div>
</div>
<?php
}

function pgssl_component_contacts_settings_setup_google() {
?>
<div class="stuffbox">
	<h3>
		<label><?php echo __("Google", 'pgs-core') ?></label>
	</h3>
	<div class="inside">
		<p class="description">
			<?php echo __( 'To import Google\'s users contacts list you will have to go to <a href="https://console.developers.google.com" target="_blank">https://console.developers.google.com</a>, then <b>APIs &amp; auth</b> &gt; <b>APIs</b> and enable <b>Contacts API</b>', 'pgs-core') ?>
		</p>
		<hr />
		<select name="pgssl_settings_contacts_import_google" <?php if( ! get_option( 'pgssl_settings_Google_enabled' ) ) echo "disabled" ?> >
			<option <?php if( get_option( 'pgssl_settings_contacts_import_google' ) == 1 ) echo "selected"; ?> value="1"><?php echo __("Enabled", 'pgs-core') ?></option>
			<option <?php if( get_option( 'pgssl_settings_contacts_import_google' ) == 2 ) echo "selected"; ?> value="2"><?php echo __("Disabled", 'pgs-core') ?></option>
		</select>
	</div>
</div>
<?php
}

function pgssl_component_contacts_settings_setup_facebook() {
?>
<div class="stuffbox">
	<h3>
		<label><?php echo __("Facebook", 'pgs-core') ?></label>
	</h3>
	<div class="inside">
		<p class="description">
			<?php echo __( 'When enabled, Facebook\'s users will be asked for an extra permission to get access for their friends lists', 'pgs-core') ?>
		</p>
		<hr />
		<select name="pgssl_settings_contacts_import_facebook" <?php if( ! get_option( 'pgssl_settings_Facebook_enabled' ) ) echo "disabled" ?> >
			<option <?php if( get_option( 'pgssl_settings_contacts_import_facebook' ) == 1 ) echo "selected"; ?> value="1"><?php echo __("Enabled", 'pgs-core') ?></option>
			<option <?php if( get_option( 'pgssl_settings_contacts_import_facebook' ) == 2 ) echo "selected"; ?> value="2"><?php echo __("Disabled", 'pgs-core') ?></option>
		</select>
	</div>
</div>
<?php
}

function pgssl_component_contacts_settings_setup_twitter() {
?>
<div class="stuffbox">
	<h3>
		<label><?php echo __("Twitter", 'pgs-core') ?></label>
	</h3>
	<div class="inside">
		<p class="description">
			<?php echo __( 'This will only import the Twitter\'s users followed by the connected user on your website', 'pgs-core') ?>
		</p>
		<hr />
		<select name="pgssl_settings_contacts_import_twitter" <?php if( ! get_option( 'pgssl_settings_Twitter_enabled' ) ) echo "disabled" ?> >
			<option <?php if( get_option( 'pgssl_settings_contacts_import_twitter' ) == 1 ) echo "selected"; ?> value="1"><?php echo __("Enabled", 'pgs-core') ?></option>
			<option <?php if( get_option( 'pgssl_settings_contacts_import_twitter' ) == 2 ) echo "selected"; ?> value="2"><?php echo __("Disabled", 'pgs-core') ?></option>
		</select>
	</div>
</div>
<?php
}

function pgssl_component_contacts_settings_setup_linkedin() {
?>
<div class="stuffbox">
	<h3>
		<label><?php echo __("LinkedIn", 'pgs-core') ?></label>
	</h3>
	<div class="inside">
		<p class="description">
			<?php echo __( 'To import LinkedIn\'s users contacts list you will have to go to <a href="https://www.linkedin.com/secure/developer" target="_blank">https://www.linkedin.com/secure/developer</a>, then <b>Default scope</b> and check <b>r_network</b>', 'pgs-core') ?>
		</p>
		<hr />
		<select name="pgssl_settings_contacts_import_linkedin" <?php if( ! get_option( 'pgssl_settings_LinkedIn_enabled' ) ) echo "disabled" ?> >
			<option <?php if( get_option( 'pgssl_settings_contacts_import_linkedin' ) == 1 ) echo "selected"; ?> value="1"><?php echo __("Enabled", 'pgs-core') ?></option>
			<option <?php if( get_option( 'pgssl_settings_contacts_import_linkedin' ) == 2 ) echo "selected"; ?> value="2"><?php echo __("Disabled", 'pgs-core') ?></option>
		</select>
	</div>
</div>
<?php
}

function pgssl_component_contacts_settings_setup_live() {
?>
<div class="stuffbox">
	<h3>
		<label><?php echo __("Windows Live", 'pgs-core') ?></label>
	</h3>
	<div class="inside">
		<hr />
		<select name="pgssl_settings_contacts_import_live" <?php if( ! get_option( 'pgssl_settings_Live_enabled' ) ) echo "disabled" ?> >
			<option <?php if( get_option( 'pgssl_settings_contacts_import_live' ) == 1 ) echo "selected"; ?> value="1"><?php echo __("Enabled", 'pgs-core') ?></option>
			<option <?php if( get_option( 'pgssl_settings_contacts_import_live' ) == 2 ) echo "selected"; ?> value="2"><?php echo __("Disabled", 'pgs-core') ?></option>
		</select>
	</div>
</div>
<?php
}

function pgssl_component_contacts_settings_setup_vkontakte() {
?>
<div class="stuffbox">
	<h3>
		<label><?php echo __("Vkontakte", 'pgs-core') ?></label>
	</h3>
	<div class="inside">
		<hr />
		<select name="pgssl_settings_contacts_import_vkontakte" <?php if( ! get_option( 'pgssl_settings_Vkontakte_enabled' ) ) echo "disabled" ?> >
			<option <?php if( get_option( 'pgssl_settings_contacts_import_vkontakte' ) == 1 ) echo "selected"; ?> value="1"><?php echo __("Enabled", 'pgs-core') ?></option>
			<option <?php if( get_option( 'pgssl_settings_contacts_import_vkontakte' ) == 2 ) echo "selected"; ?> value="2"><?php echo __("Disabled", 'pgs-core') ?></option>
		</select>
	</div>
</div>
<?php
}
