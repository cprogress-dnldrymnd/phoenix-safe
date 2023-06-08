<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function pgssl_component_networks_sidebar() {
	// HOOKABLE:
	do_action( "pgssl_component_networks_sidebar_start" );

	$sections = array(
		// 'add_more_providers' => 'pgssl_component_networks_sidebar_add_more_providers',
		'custom_integration' => 'pgssl_component_networks_sidebar_custom_integration',
	);

	$sections = apply_filters( 'pgssl_component_networks_sidebar_alter_sections', $sections );

	foreach( $sections as $section => $action ) {
		add_action( 'pgssl_component_networks_sidebar_sections', $action );
	}

	// HOOKABLE:
	do_action( 'pgssl_component_networks_sidebar_sections' );
}

function pgssl_component_networks_sidebar_add_more_providers() {
	$providers_config = pgssl_get_providers();
	?>
	<div class="postbox">
		<div class="inside">
			<h3><?php echo __("Add more providers", 'pgs-core' ) ?></h3>

			<p>
				<?php echo __('We have enabled <b>Facebook</b> and <b>Google</b></b> by default, however you may add even more by clicking below icon(s).', 'pgs-core') ?>
			</p>

			<div class="new-provider-list">
				<?php
				$nb_used = count( $providers_config );

				foreach( $providers_config AS $item ) {
					$provider_id   = isset( $item["provider_id"]   ) ? $item["provider_id"]   : '';
					$provider_name = isset( $item["provider_name"] ) ? $item["provider_name"] : '';

					if( isset( $item["default_network"] ) && $item["default_network"] ) {
						continue;
					}

					if( ! get_option( 'pgssl_settings_' . $provider_id . '_enabled' ) ) {
						$provider_icon = pgssl_get_icon( $provider_id );
						$link_params = array(
							'page' => 'pgssl_settings',
						);

						if ( isset($_GET['pgssl_page']) && $_GET['pgssl_page'] ) {
							$link_params['pgssl_page'] = $_GET['pgssl_page'];
						}
						$link_params['enable'] = $provider_id;

						$link = add_query_arg( $link_params, pgssl_get_menu_path() );
						?>
						<a href="<?php echo esc_url($link);?>">
							<?php
							if( $provider_icon ){
								?>
								<span class="pgssl-nework-setup-icon"><?php echo $provider_icon;?></span>
								<?php
							}else{
								echo esc_html($provider_name);
							}
							?>
						</a>
						<?php
						$nb_used--;
					}
				}

				if( $nb_used == count( $providers_config ) ) {
					echo __("Well! none left.", 'pgs-core');
				}
				?>
			</div>
		</div>
	</div>
	<?php
}

function pgssl_component_networks_sidebar_custom_integration() {
	?>
	<div class="postbox">
		<div class="inside">
			<h3><?php echo __("Custom integration", 'pgs-core') ?></h3>

			<div>
				<p>
					<?php esc_html_e("If you want to add the widget to another location in your website, you can insert the following code in that location:", 'pgs-core') ?>
					<pre class="pgssl-custom-integration-pre pgssl-custom-integration-pre-action">&lt;?php
do_action( 'pgs_social_login' );
?&gt;</pre>
				</p>
				<p>
					<?php esc_html_e("For posts and pages, you may use this shortcode:", 'pgs-core') ?>
					<pre class="pgssl-custom-integration-pre pgssl-custom-integration-pre-shortcode">[pgs_social_login]</pre>
				</p>
			</div>
			<p>
				<?php echo __('Notes', 'pgs-core') ?>:
				<ol>
					<li><?php echo __('PGS Social Login icon will only show up for non connected users.', 'pgs-core') ?></li>
					<li><?php echo __('In case you are using a caching plugin on your website, you might need to empty the cache for any change to take effect.', 'pgs-core') ?></li>
					<li><?php echo __('Adblock Plus users with &ldquo;<a href="https://adblockplus.org/en/features#socialmedia" target="_blank">antisocial filter</a>&rdquo; enabled may not see the providers icons.', 'pgs-core') ?></li>
				</ol>
			</p>
		</div>
	</div>
	<?php
}
