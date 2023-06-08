<?php
global $ciyashop_globals;

$menu_title = isset( $settings['menu_title'] ) ? $settings['menu_title'] : '';

if ( ! has_nav_menu( 'shortcode_v_menu' ) ) {
	if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
		?>
		<div class="alert alert-danger" role="alert" style="margin: 0;">
			<h4 class="alert-heading"><?php esc_html_e( 'Important Note', 'pgs-core' ); ?></h4>
			<p><?php
			echo wp_kses(
				__( 'To Display the menu on front, you have to select checkbox <strong>Shortcode - Vertical Menu</strong> in <strong>Appearance > Menus > Menu Settings.</strong>', 'pgs-core' ),
				array(
					'strong' => array(),
				)
			);
			?>
			</p>
		</div>
		<?php
	}
	return;
}

if ( isset( $ciyashop_globals['shortcode_v_menu'] ) ) {
	$ciyashop_globals['shortcode_v_menu'] = $ciyashop_globals['shortcode_v_menu'] + 1;
} else {
	$ciyashop_globals['shortcode_v_menu'] = 1;
}

$this->add_render_attribute( 'pgscore_vertical_menu', 'class', 'pgscore_v_menu-main' );
$this->add_render_attribute( 'pgscore_vertical_menu', 'data-menu_title', $menu_title );
$theme_locations = get_nav_menu_locations();
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div class="pgscore_v_menu">
		<div class="pgscore_v_menu-inner">
			<?php
			if ( $menu_title ) {
				?>
				<div class="pgscore_v_menu-header">
					<i class="fas fa-bars"></i><?php echo esc_html( $menu_title ); ?>
				</div>
				<?php
			}
			?>
			<div <?php $this->print_render_attribute_string( 'pgscore_vertical_menu' ); ?>>
				<?php
				$menu_obj            = '';
				$cs_mega_menu_enable = '';

				if ( isset( $theme_locations['shortcode_v_menu'] ) ) {

					$menu_obj = get_term( $theme_locations['shortcode_v_menu'], 'nav_menu' );

					if ( isset( $menu_obj->term_id ) && $menu_obj->term_id ) {
						$menu_id             = $menu_obj->term_id;
						$cs_mega_menu_enable = get_post_meta( $menu_id, 'cs_megamenu_enable', true );
					}
				}

				$arg = array(
					'theme_location'  => 'shortcode_v_menu',
					'container_id'    => 'pgscore_v_menu__menu-' . $ciyashop_globals['shortcode_v_menu'],
					'container_class' => 'pgscore_v_menu__menu_wrap',
					'menu_id'         => 'pgscore_v_menu__nav-' . $ciyashop_globals['shortcode_v_menu'],
					'menu_class'      => 'pgscore_v_menu__nav menu',
				);

				if ( 'true' === (string) $cs_mega_menu_enable ) {
					$arg['menu_class'] = $arg['menu_class'] . ' pgs_megamenu-enable';
					$arg['walker']     = new CiyaShop_Walker_Nav_Menu();
				}

				wp_nav_menu( $arg );
				?>
			</div>
		</div>
	</div>
</div>
