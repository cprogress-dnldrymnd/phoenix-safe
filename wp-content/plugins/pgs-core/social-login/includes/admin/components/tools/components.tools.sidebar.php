<?php
/**
* BuddyPress integration.
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function pgssl_component_tools_sidebar() {
	$sections = array(
		'what_is_this' => 'pgssl_component_tools_sidebar_what_is_this',
	);

	$sections = apply_filters( 'pgssl_component_tools_sidebar_alter_sections', $sections );

	foreach( $sections as $section => $action ) {
		add_action( 'pgssl_component_tools_sidebar_sections', $action );
	}

	// HOOKABLE:
	do_action( 'pgssl_component_tools_sidebar_sections' );
}

function pgssl_component_tools_sidebar_what_is_this() {
?>
<div class="postbox">
	<div class="inside">
		<h3><?php echo __("PGS Social Login Tools", 'pgs-core') ?></h3>

		<div style="padding:0 20px;">
			<p>
				<?php echo __( 'Here you can found a set of tools to help you find and hopefully fix any issue you may encounter', 'pgs-core') ?>.
			</p>
			<p>
				<?php echo __( 'You can also delete all Wordpress Social Login tables and stored options from the <b>Uninstall</b> section down below', 'pgs-core') ?>.
			</p>
		</div>
	</div>
</div>
<?php
}
