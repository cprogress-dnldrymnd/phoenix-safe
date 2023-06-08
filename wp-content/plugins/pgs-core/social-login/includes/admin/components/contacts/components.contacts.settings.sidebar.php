<?php
/**
* BuddyPress integration.
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function pgssl_component_contacts_settings_sidebar() {
	$sections = array(
		'what_is_this' => 'pgssl_component_contacts_settings_sidebar_what_is_this',
	);

	$sections = apply_filters( 'pgssl_component_contacts_settings_sidebar_alter_sections', $sections );

	foreach( $sections as $section => $action ) {
		add_action( 'pgssl_component_contacts_settings_sidebar_sections', $action );
	}

	// HOOKABLE:
	do_action( 'pgssl_component_contacts_settings_sidebar_sections' );
}

function pgssl_component_contacts_settings_sidebar_what_is_this() {
?>
<div class="postbox">
	<div class="inside">
		<h3><?php echo __("User contacts import", 'pgs-core') ?></h3>

		<div style="padding:0 20px;">
			<p>
				<?php echo __( 'PGS Social Login also allow you to import users contact list from Google Gmail, Facebook, Windows Live, LinkedIn  and Vkontakte', 'pgs-core') ?>.
			</p>

			<p>
				<?php echo __( 'When enabled, users authenticating through PGS Social Login will be asked for the authorisation to import their contact list. Note that some social networks do not provide certain of their users information like contacts emails, photos and or profile urls', 'pgs-core') ?>.
			</p>
			<hr />
			<p>
				<b><?php echo __("Notes", 'pgs-core') ?>:</b>
			</p>

			<ul style="margin-left:15px;margin-top:0px;">
				<li><?php echo __('To enable contacts import from these social network, you need first to enabled them on the <a href="admin.php?page=pgssl_settings&pgssl_page=networks"><b>Networks</b></a> tab and register the required application', 'pgs-core') ?>.</li>
				<li><?php echo __("<b>PGS Social Login</b> will try to import as much information about a user contacts as he was able to pull from the social networks APIs.", 'pgs-core') ?></li>
				<li><?php echo __('All contacts data are sotred into your database on the table: <code>`pgssl_userscontacts`</code>', 'pgs-core') ?>.</li>
			</ul>
		</div>
	</div>
</div>
<?php
}
