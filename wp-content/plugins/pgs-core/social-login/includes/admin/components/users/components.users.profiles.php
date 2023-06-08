<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function pgssl_component_users_profiles( $user_id ) {
	// HOOKABLE:
	do_action( "pgssl_component_users_profiles_start" );

	$assets_base_url = PGS_SOCIAL_LOGIN_PLUGIN_URL . 'assets/img/icons/16x16/';

	$linked_accounts = pgssl_get_stored_hybridauth_user_profiles_by_user_id( $user_id );

	// is it a PGS Social Login user?
	if( ! $linked_accounts ) {
?>
<div style="padding: 15px; margin-bottom: 8px; border: 1px solid #ddd; background-color: #fff;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
	<?php echo __( "This's not a PGS Social Login user!", 'pgs-core' ); ?>.
</div>
<?php
		return;
	}

	# http://hybridauth.sourceforge.net/userguide/Profile_Data_User_Profile.html
	$ha_profile_fields = array(
		array( 'field' => 'identifier'  , 'label' => __( "Provider user ID" , 'pgs-core'), 'description' => __( "The Unique user's ID on the connected provider. Depending on the provider, this field can be an number, Email, URL, etc", 'pgs-core') ),
		array( 'field' => 'profileURL'  , 'label' => __( "Profile URL"      , 'pgs-core'), 'description' => __( "Link to the user profile on the provider web site"                                                                      , 'pgs-core') ),
		array( 'field' => 'webSiteURL'  , 'label' => __( "Website URL"      , 'pgs-core'), 'description' => __( "User website, blog or web page"                                                                                         , 'pgs-core') ),
		array( 'field' => 'photoURL'    , 'label' => __( "Photo URL"        , 'pgs-core'), 'description' => __( "Link to user picture or avatar on the provider web site"                                                                , 'pgs-core') ),
		array( 'field' => 'displayName' , 'label' => __( "Display name"     , 'pgs-core'), 'description' => __( "User Display name. If not provided by social network, PGS Social Login will return a concatenation of the user first and last name"  , 'pgs-core') ),
		array( 'field' => 'description' , 'label' => __( "Description"      , 'pgs-core'), 'description' => __( "A short about me"                                                                                                       , 'pgs-core') ),
		array( 'field' => 'firstName'   , 'label' => __( "First name"       , 'pgs-core'), 'description' => __( "User's first name"                                                                                                      , 'pgs-core') ),
		array( 'field' => 'lastName'    , 'label' => __( "Last name"        , 'pgs-core'), 'description' => __( "User's last name"                                                                                                       , 'pgs-core') ),
		array( 'field' => 'gender'      , 'label' => __( "Gender"           , 'pgs-core'), 'description' => __( "User's gender. Values are 'female', 'male' or blank"                                                                    , 'pgs-core') ),
		array( 'field' => 'language'    , 'label' => __( "Language"         , 'pgs-core'), 'description' => __( "User's language"                                                                                                        , 'pgs-core') ),
		array( 'field' => 'age'         , 'label' => __( "Age"              , 'pgs-core'), 'description' => __( "User' age. Note that PGS Social Login do not calculate this field. We return it as it was provided"                                  , 'pgs-core') ),
		array( 'field' => 'birthDay'    , 'label' => __( "Birth day"        , 'pgs-core'), 'description' => __( "The day in the month in which the person was born. Not to confuse it with 'Birth date'"                                 , 'pgs-core') ),
		array( 'field' => 'birthMonth'  , 'label' => __( "Birth month"      , 'pgs-core'), 'description' => __( "The month in which the person was born"                                                                                 , 'pgs-core') ),
		array( 'field' => 'birthYear'   , 'label' => __( "Birth year"       , 'pgs-core'), 'description' => __( "The year in which the person was born"                                                                                  , 'pgs-core') ),
		array( 'field' => 'email'       , 'label' => __( "Email"            , 'pgs-core'), 'description' => __( "User's email address. Note: some providers like Facebook and Google can provide verified emails. Users with the same verified email will be automatically linked", 'pgs-core') ),
		array( 'field' => 'phone'       , 'label' => __( "Phone"            , 'pgs-core'), 'description' => __( "User's phone number"                                                                                                    , 'pgs-core') ),
		array( 'field' => 'address'     , 'label' => __( "Address"          , 'pgs-core'), 'description' => __( "User's address"                                                                                                         , 'pgs-core') ),
		array( 'field' => 'country'     , 'label' => __( "Country"          , 'pgs-core'), 'description' => __( "User's country"                                                                                                         , 'pgs-core') ),
		array( 'field' => 'region'      , 'label' => __( "Region"           , 'pgs-core'), 'description' => __( "User's state or region"                                                                                                 , 'pgs-core') ),
		array( 'field' => 'city'        , 'label' => __( "City"             , 'pgs-core'), 'description' => __( "User's city"                                                                                                            , 'pgs-core') ),
		array( 'field' => 'zip'         , 'label' => __( "Zip"              , 'pgs-core'), 'description' => __( "User's zipcode"                                                                                                         , 'pgs-core') ),
	);

	$user_data = get_userdata( $user_id );

	add_thickbox();

	$actions = array(
		'edit_details'  => '<a class="button button-secondary thickbox" href="' . admin_url( 'user-edit.php?user_id=' . $user_id . '&TB_iframe=true&width=1150&height=550' ) . '">' . __( 'Edit user details', 'pgs-core' ) . '</a>',
		'show_contacts'  => '<a class="button button-secondary" href="' . admin_url( 'admin.php?page=pgssl_settings&pgssl_page=contacts&uid=' . $user_id ) . '">' . __( 'Show user contacts list', 'pgs-core' ) . '</a>',
	);

	// HOOKABLE:
	$actions = apply_filters( 'pgssl_component_users_profiles_alter_actions_list', $actions, $user_id );
?>
<style>
	table td, table th { border: 1px solid #DDDDDD; }
	table th label { font-weight: bold; }
	.form-table th { width:120px; text-align:right; }
	p.description { font-size: 11px ! important; margin:0 ! important;}
</style>

<script>
	function confirmDeletePGSSLUser() {
		return confirm( <?php echo json_encode( __("Are you sure you want to delete the user's social profiles and contacts?\n\nNote: The associated WordPress user won't be deleted.", 'pgs-core') ) ?> );
	}
</script>

<div style="margin-top: 15px;padding: 15px; margin-bottom: 8px; border: 1px solid #ddd; background-color: #fff;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
 	<h3 style="margin:0;"><?php echo sprintf( __("%s's social profiles", 'pgs-core'), $user_data->display_name ) ?></h3>

	<p style="float: <?php if( is_rtl() ) echo 'left'; else echo 'right'; ?>;margin-top:-23px">
		<?php
			echo implode( ' ', $actions );
		?>
	</p>
</div>

<div style="padding: 20px; border: 1px solid #ddd; background-color: #fff;">
	<table class="wp-list-table widefat">
		<tr><th width="200"><label><?php echo __("Wordpress User ID", 'pgs-core'); ?></label></th><td><?php echo $user_data->ID; ?></td></tr>
		<tr><th width="200"><label><?php echo __("Username", 'pgs-core'); ?></label></th><td><?php echo $user_data->user_login; ?></td></tr>
		<tr><th><label><?php echo __("Display name", 'pgs-core'); ?></label></th><td><?php echo $user_data->display_name; ?></td></tr>
		<tr><th><label><?php echo __("E-mail", 'pgs-core'); ?></label></th><td><a href="mailto:<?php echo $user_data->user_email; ?>" target="_blank"><?php echo $user_data->user_email; ?></a></td></tr>
		<tr><th><label><?php echo __("Website", 'pgs-core'); ?></label></th><td><a href="<?php echo $user_data->user_url; ?>" target="_blank"><?php echo $user_data->user_url; ?></a></td></tr>
		<tr><th><label><?php echo __("Registered", 'pgs-core'); ?></label></th><td><?php echo $user_data->user_registered; ?></td></tr>
		</tr>
	 </table>
</div>

<?php
	foreach( $linked_accounts AS $link ) {
?>
<div style="margin-top:15px;padding: 5px 20px 20px; border: 1px solid #ddd; background-color: #fff;">

<h4><img src="<?php echo $assets_base_url . strtolower( $link->provider ) . '.png' ?>" style="vertical-align:top;width:16px;height:16px;" /> <?php echo __("User profile", 'pgs-core'); ?> <small><?php echo sprintf( __( "as provided by %s", 'pgs-core'), $link->provider ); ?> </small></h4>

<table class="wp-list-table widefat">
	<?php
		$profile_fields = (array) $link;

		foreach( $ha_profile_fields as $item ) {
			$item['field'] = strtolower( $item['field'] );
		?>
			<tr>
				<th width="200">
					<label><?php echo $item['label']; ?></label>
				</th>
				<td>
					<?php
						if( isset( $profile_fields[ $item['field'] ] ) && $profile_fields[ $item['field'] ] ) {
							$field_value = $profile_fields[ $item['field'] ];

							if( in_array( $item['field'], array( 'profileurl', 'websiteurl', 'email' ) ) ) {
								?>
									<a href="<?php if( $item['field'] == 'email' ) echo 'mailto:'; echo $field_value; ?>" target="_blank"><?php echo $field_value; ?></a>
								<?php
							} elseif( $item['field'] == 'photourl' ) {
								?>
									<a href="<?php echo $field_value; ?>" target="_blank"><img width="36" height="36" align="left" src="<?php echo $field_value; ?>" style="margin-right: 5px;" > <?php echo $field_value; ?></a>
								<?php
							} else {
								echo $field_value;
							}

							?>
								<p class="description">
									<?php echo $item['description']; ?>.
								</p>
							<?php
						}
					?>
				</td>
			</tr>
		<?php
		}
	?>
</table>
</div>
<?php
	}

	// HOOKABLE:
	do_action( "pgssl_component_users_profiles_end" );
}
