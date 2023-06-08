<?php
/**
* BuddyPress integration.
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function pgssl_component_buddypress_setup() {
	$sections = array(
		'user_avatar'     => 'pgssl_component_buddypress_setup_user_avatar',
		'profile_mapping' => 'pgssl_component_buddypress_setup_profile_mapping',
	);

	$sections = apply_filters( 'pgssl_component_buddypress_setup_alter_sections', $sections );

	foreach( $sections as $section => $action ) {
		add_action( 'pgssl_component_buddypress_setup_sections', $action );
	}
?>
<div>
	<?php
		// HOOKABLE:
		do_action( 'pgssl_component_buddypress_setup_sections' );
	?>

	<br />

	<div style="margin-left:5px;margin-top:-20px;">
		<input type="submit" class="button-primary" value="<?php echo esc_attr__("Save Settings", 'pgs-core') ?>" />
	</div>
</div>
<?php
}

function pgssl_component_buddypress_setup_user_avatar() {
?>
<div class="stuffbox">
	<h3>
		<label><?php echo __("Users avatars", 'pgs-core') ?></label>
	</h3>
	<div class="inside">
		<p>
			<?php
			if( pgssl_users_avatars() == 1 ){
				echo __("<b>Users avatars</b> is currently set to: <b>Display users avatars from social networks when available.</b>", 'pgs-core');
			} else {
				echo __("<b>Users avatars</b> is currently set to: <b>Display the default WordPress avatars.</b>", 'pgs-core');
			}
			?>
		</p>

		<p class="description">
			<?php echo __("To change this setting, go to <b>Widget</b> &gt; <b>Basic Settings</b> &gt <b>Users avatars</b>, then select the type of avatars that you want to display for your users.", 'pgs-core') ?>
		</p>
	</div>
</div>
<?php
}

function pgssl_component_buddypress_setup_profile_mapping() {
	$assets_base_url = PGS_SOCIAL_LOGIN_PLUGIN_URL . 'assets/img/';

	$pgssl_settings_buddypress_enable_mapping = get_option( 'pgssl_settings_buddypress_enable_mapping' );
	$pgssl_settings_buddypress_xprofile_map   = get_option( 'pgssl_settings_buddypress_xprofile_map' );

	# http://hybridauth.sourceforge.net/userguide/Profile_Data_User_Profile.html
	$ha_profile_fields = array(
		array( 'field' => 'provider'    , 'label' => __( "Provider name"            , 'pgs-core'), 'description' => __( "The the provider or social network name the user used to connected"                                                     , 'pgs-core') ),
		array( 'field' => 'identifier'  , 'label' => __( "Provider user Identifier" , 'pgs-core'), 'description' => __( "The Unique user's ID on the connected provider. Depending on the provider, this field can be an number, Email, URL, etc", 'pgs-core') ),
		array( 'field' => 'profileURL'  , 'label' => __( "Profile URL"              , 'pgs-core'), 'description' => __( "Link to the user profile on the provider web site"                                                                      , 'pgs-core') ),
		array( 'field' => 'webSiteURL'  , 'label' => __( "Website URL"              , 'pgs-core'), 'description' => __( "User website, blog or web page"                                                                                         , 'pgs-core') ),
		array( 'field' => 'photoURL'    , 'label' => __( "Photo URL"                , 'pgs-core'), 'description' => __( "Link to user picture or avatar on the provider web site"                                                                , 'pgs-core') ),
		array( 'field' => 'displayName' , 'label' => __( "Display name"             , 'pgs-core'), 'description' => __( "User Display name. If not provided by social network, PGS Social Login will return a concatenation of the user first and last name"  , 'pgs-core') ),
		array( 'field' => 'description' , 'label' => __( "Description"              , 'pgs-core'), 'description' => __( "A short about me"                                                                                                       , 'pgs-core') ),
		array( 'field' => 'firstName'   , 'label' => __( "First name"               , 'pgs-core'), 'description' => __( "User's first name"                                                                                                      , 'pgs-core') ),
		array( 'field' => 'lastName'    , 'label' => __( "Last name"                , 'pgs-core'), 'description' => __( "User's last name"                                                                                                       , 'pgs-core') ),
		array( 'field' => 'gender'      , 'label' => __( "Gender"                   , 'pgs-core'), 'description' => __( "User's gender. Values are 'female', 'male' or blank"                                                                    , 'pgs-core') ),
		array( 'field' => 'language'    , 'label' => __( "Language"                 , 'pgs-core'), 'description' => __( "User's language"                                                                                                        , 'pgs-core') ),
		array( 'field' => 'age'         , 'label' => __( "Age"                      , 'pgs-core'), 'description' => __( "User' age. Note that PGS Social Login do not calculate this field. We return it as it was provided"                                  , 'pgs-core') ),
		array( 'field' => 'birthDay'    , 'label' => __( "Birth day"                , 'pgs-core'), 'description' => __( "The day in the month in which the person was born. Not to confuse it with 'Birth date'"                                 , 'pgs-core') ),
		array( 'field' => 'birthMonth'  , 'label' => __( "Birth month"              , 'pgs-core'), 'description' => __( "The month in which the person was born"                                                                                 , 'pgs-core') ),
		array( 'field' => 'birthYear'   , 'label' => __( "Birth year"               , 'pgs-core'), 'description' => __( "The year in which the person was born"                                                                                  , 'pgs-core') ),
		array( 'field' => 'birthDate'   , 'label' => __( "Birth date"               , 'pgs-core'), 'description' => __( "Complete birthday in which the person was born. Format: YYYY-MM-DD"                                                     , 'pgs-core') ),
		array( 'field' => 'email'       , 'label' => __( "Email"                    , 'pgs-core'), 'description' => __( "User's email address. Not all of provider grant access to the user email"                                               , 'pgs-core') ),
		array( 'field' => 'phone'       , 'label' => __( "Phone"                    , 'pgs-core'), 'description' => __( "User's phone number"                                                                                                    , 'pgs-core') ),
		array( 'field' => 'address'     , 'label' => __( "Address"                  , 'pgs-core'), 'description' => __( "User's address"                                                                                                         , 'pgs-core') ),
		array( 'field' => 'country'     , 'label' => __( "Country"                  , 'pgs-core'), 'description' => __( "User's country"                                                                                                         , 'pgs-core') ),
		array( 'field' => 'region'      , 'label' => __( "Region"                   , 'pgs-core'), 'description' => __( "User's state or region"                                                                                                 , 'pgs-core') ),
		array( 'field' => 'city'        , 'label' => __( "City"                     , 'pgs-core'), 'description' => __( "User's city"                                                                                                            , 'pgs-core') ),
		array( 'field' => 'zip'         , 'label' => __( "Zip"                      , 'pgs-core'), 'description' => __( "User's zipcode"                                                                                                         , 'pgs-core') ),
	);
?>
<div class="stuffbox">
	<h3>
		<label><?php echo __("Profile mappings", 'pgs-core') ?></label>
	</h3>
	<div class="inside">
		<p>
			<?php echo __("When <b>Profile mapping</b> is enabled, PGS Social Login will try to automatically fill in Buddypress users profiles from their social networks profiles", 'pgs-core') ?>.
		</p>

		<p>
			<b><?php echo __('Notes', 'pgs-core') ?>:</b>
		</p>

		<p class="description">
			1. <?php echo __('<b>Profile mapping</b> will only work for new users. Profile mapping for returning users will implemented in future version.', 'pgs-core') ?>.
			<br />
			2. <?php echo __('Not all the mapped fields will be filled. Some providers and social networks do not give away many information about their users', 'pgs-core') ?>.
			<br />
			3. <?php echo __('PGS Social Login can only map <b>Single Fields</b>. Supported fields types are: Multi-line Text Areax, Text Box, URL, Date Selector and Number', 'pgs-core') ?>.
		</p>

		<table width="100%" border="0" cellpadding="5" cellspacing="2" style="border-top:1px solid #ccc;">
		  <tr>
			<td width="200" align="right"><strong><?php echo __("Enable profile mapping", 'pgs-core') ?> :</strong></td>
			<td>
				<select name="pgssl_settings_buddypress_enable_mapping" id="pgssl_settings_buddypress_enable_mapping" style="width:100px" onChange="toggleMapDiv();">
					<option <?php if( $pgssl_settings_buddypress_enable_mapping == 1 ) echo "selected"; ?> value="1"><?php echo __("Yes", 'pgs-core') ?></option>
					<option <?php if( $pgssl_settings_buddypress_enable_mapping == 2 ) echo "selected"; ?> value="2"><?php echo __("No", 'pgs-core') ?></option>
				</select>
			</td>
		  </tr>
		</table>
		<br>
	</div>
</div>

<div id="xprofilemapdiv" class="stuffbox" style="<?php if( $pgssl_settings_buddypress_enable_mapping == 2 ) echo "display:none;"; ?>">
	<h3>
		<label><?php echo __("Fields Map", 'pgs-core') ?></label>
	</h3>

	<div class="inside">
		<p>
			<?php echo __("Here you can create a new map by placing PGS Social Login users profiles fields to the appropriate destination fields", 'pgs-core') ?>.
			<?php echo __('The left column shows the available <b>PGS Social Login users profiles fields</b>: These select boxes are called <b>source</b> fields', 'pgs-core') ?>.
			<?php echo __('The right column shows the list of <b>Buddypress profiles fields</b>: Those are the <b>destination</b> fields', 'pgs-core') ?>.
			<?php echo __('If you don\'t want to map a particular Buddypress field, then leave the source for that field blank', 'pgs-core') ?>.
		</p>

		<hr />

		<?php
			if ( bp_has_profile() ) {
				while ( bp_profile_groups() ) {
					global $group;

					bp_the_profile_group();
					?>
						<h4><?php echo sprintf( __("Fields Group '%s'", 'pgs-core'), $group->name ) ?> :</h4>

						<table width="100%" border="0" cellpadding="5" cellspacing="2" style="border-top:1px solid #ccc;">
							<?php
								while ( bp_profile_fields() ) {
									global $field;

									bp_the_profile_field();
									?>
										<tr>
											<td width="270" align="right" valign="top">
												<?php
													$map = isset( $pgssl_settings_buddypress_xprofile_map[$field->id] ) ? $pgssl_settings_buddypress_xprofile_map[$field->id] : 0;
													$can_map_it = true;

													if( ! in_array( $field->type, array( 'textarea', 'textbox', 'url', 'datebox', 'number' ) ) ){
														$can_map_it = false;
													}
												?>
												<select name="pgssl_settings_buddypress_xprofile_map[<?php echo $field->id; ?>]" style="width:255px" id="bb_profile_mapping_selector_<?php echo $field->id; ?>" onChange="showMappingConfirm( <?php echo $field->id; ?> );" <?php if( ! $can_map_it ) echo "disabled"; ?>>
													<option value=""></option>
													<?php
														if( $can_map_it ){
															foreach( $ha_profile_fields as $item ){
															?>
																<option value="<?php echo $item['field']; ?>" <?php if( $item['field'] == $map ) echo "selected"; ?> ><?php echo $item['label']; ?></option>
															<?php
															}
														}
													?>
												</select>
											</td>
											<td valign="top" align="center" width="50">
												<img src="<?php echo $assets_base_url; ?>arr_right.png" />
											</td>
											<td valign="top">
												<strong><?php echo $field->name; ?></strong>
												<?php
													if( ! $can_map_it ){
													?>
														<p class="description">
															<?php echo __("<b>PGS Social Login</b> can not map this field. Supported field types are: <em>Multi-line Text Areax, Text Box, URL, Date Selector and Number</em>", 'pgs-core'); ?>.
														</p>
													<?php
													} else {
													?>
														<?php
															foreach( $ha_profile_fields as $item ){
														?>
															<p class="description bb_profile_mapping_confirm_<?php echo $field->id; ?>" style="margin-left:0;<?php if( $item['field'] != $map ) echo "display:none;"; ?>" id="bb_profile_mapping_confirm_<?php echo $field->id; ?>_<?php echo $item['field']; ?>">
																<?php echo sprintf( __( "PGS Social Login <b>%s</b> is mapped to Buddypress <b>%s</b> field", 'pgs-core' ), $item['label'], $field->name ); ?>.
																<br />
																<em><b><?php echo $item['label']; ?>:</b> <?php echo $item['description']; ?>.</em>
															</p>
														<?php
															}
														?>
													<?php
													}
												?>
											</td>
										</tr>
									<?php
								}
							?>
						</table>
					<?php
				}
			}
		?>
	</div>
</div>
<script>
	function toggleMapDiv(){
		if(typeof jQuery=="undefined"){
			alert( "Error: PGS Social Login require jQuery to be installed on your wordpress in order to work!" );

			return false;
		}

		var em = jQuery( "#pgssl_settings_buddypress_enable_mapping" ).val();

		if( em == 2 ) jQuery( "#xprofilemapdiv" ).hide();
		else jQuery( "#xprofilemapdiv" ).show();
	}

	function showMappingConfirm( field ){
		if(typeof jQuery=="undefined"){
			alert( "Error: PGS Social Login require jQuery to be installed on your wordpress in order to work!" );

			return false;
		}

		var el = jQuery( "#bb_profile_mapping_selector_" + field ).val();

		jQuery( ".bb_profile_mapping_confirm_" + field ).hide();

		jQuery( "#bb_profile_mapping_confirm_" + field + "_" + el ).show();
	}
</script>
<?php
}
