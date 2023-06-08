<?php
/**
 * Shortcode main file.
 *
 * @package pgs-core
 */

// Enable shortcodes in widgets.
add_filter( 'widget_text', 'do_shortcode' );

/**
 * Shortcodes loader new.
 *
 * @return false|void
 */
function pgscore_shortcodes_loader() {

	// Return if vc is not active.
	if ( ! class_exists( 'WPBakeryVisualComposerAbstract' ) ) {
		return false;
	}

	// Return if no shortcode support.
	if ( ! current_theme_supports( 'pgscore_shortcodes' ) ) {
		return false;
	}

	// Shortcodes List.
	$shortcodes = array(
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/address_block.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/banner.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/clients.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/countdown.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/image_slider.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/info_box.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/info_box_2.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/instagram_v2.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/instagram_v3.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/kite_box.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/list.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/newsletter.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/opening_hours.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/portfolio.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/recent_posts.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/social_icons.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/team_members.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/testimonials.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/vertical_menu.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/progress_bar.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/search.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/section_title.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/button.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/timeline.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/image_gallery.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/video.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/callout.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/hotspot.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/counter.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/html_block.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/menu_list.php',
		trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/smart_image_view.php',
	);

	if ( class_exists( 'WooCommerce' ) ) {
		$shortcodes = array_merge(
			$shortcodes,
			array(
				trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/categorybox.php',
				trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/product_cat_carousel.php',
				trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/multi_tab_products_listing.php',
				trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/product_deal.php',
				trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/product_deals.php',
				trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/product_showcase.php',
				trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/products_listing.php',
				trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/single_product_slider.php',
				trailingslashit( PGSCORE_PATH ) . 'includes/shortcodes/pricing.php',
			)
		);
	}

	$shortcodes = apply_filters( 'pgscore_shortcodes', $shortcodes );

	// Sort shortcodes.
	asort( $shortcodes );

	foreach ( $shortcodes as $shortcode_file ) {

		if ( file_exists( $shortcode_file ) ) {

			$shortcode_pathinfo = pathinfo( $shortcode_file );

			$shortcode_tag = 'pgscore_' . $shortcode_pathinfo['filename'];

			include_once $shortcode_file;
			add_shortcode( $shortcode_tag, 'pgscore_shortcode_' . $shortcode_pathinfo['filename'] );
		}
	}
}
add_action( 'init', 'pgscore_shortcodes_loader', 12 );

if ( ! function_exists( 'pgscore_get_year' ) ) {
	/**
	 * Get year shortcode.
	 *
	 * @param array $atts Shortcode attributes array.
	 * @return string
	 */
	function pgscore_get_year( $atts ) {
		$atts = shortcode_atts(
			array(
				'year' => date( 'Y' ), // phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date
			),
			$atts
		);

		return $atts['year'];
	}
}
add_shortcode( 'pgscore-year', 'pgscore_get_year' );


if ( ! function_exists( 'pgscore_get_site_title' ) ) {
	/**
	 * Get site title shortcode.
	 *
	 * @param array $atts Shortcode attributes array.
	 * @return string
	 */
	function pgscore_get_site_title( $atts ) {
		$atts = shortcode_atts(
			array(
				'site'     => get_bloginfo(),
				'site_url' => get_site_url(),
			),
			$atts
		);

		$site_name = '';

		if ( ! empty( $atts['site'] ) && ! empty( $atts['site_url'] ) ) {
			$site_name = sprintf(
				wp_kses(
					'<a href="%1$s" target="_blank">%2$s</a>',
					array(
						'a' => array(
							'href'   => true,
							'target' => true,
						),
					)
				),
				$atts['site_url'],
				$atts['site']
			);
		}
		return $site_name;
	}
}
add_shortcode( 'pgscore-site-title', 'pgscore_get_site_title' );

if ( ! function_exists( 'pgscore_get_footer_menu' ) ) {
	/**
	 * Get footer menu shortcode.
	 *
	 * @param array $atts Shortcode attributes array.
	 * @return string
	 */
	function pgscore_get_footer_menu( $atts ) {
		$atts = shortcode_atts(
			array(
				'class' => 'list-inline text-right',
			),
			$atts
		);

		ob_start();
		if ( has_nav_menu( 'footer_menu' ) ) {
			wp_nav_menu(
				apply_filters(
					'pgscore_footer_menu_shortcode',
					array(
						'theme_location' => 'footer_menu',
						'menu_class'     => $atts['class'],
						'menu_id'        => 'footer-menu',
						'depth'          => 1,
					)
				)
			);
		}
		return ob_get_clean();
	}
}
add_shortcode( 'pgscore-footer-menu', 'pgscore_get_footer_menu' );

if ( ! function_exists( 'pgscore_popup_close' ) ) {
	/**
	 * Popup close shortcode.
	 *
	 * @param array $atts Shortcode attributes array.
	 * @return string
	 */
	function pgscore_popup_close( $atts ) {
		$atts = shortcode_atts(
			array(
				'message' => esc_html__( "Don't show this popup again", 'pgs-core' ),
			),
			$atts
		);

		$popup_close = '';

		if ( ! empty( $atts['message'] ) ) {
			$popup_close = '<label for="hide_promo_popup"><input type="checkbox" name="hide_promo_popup" id="hide_promo_popup" />&nbsp;' . $atts['message'] . '</label>';
		}

		return $popup_close;
	}
}
add_shortcode( 'pgscore-popup-close', 'pgscore_popup_close' );

// If vc is not active.
if ( ! class_exists( 'WPBakeryVisualComposerAbstract' ) && ! shortcode_exists( 'pgscore_newsletter' ) ) {

	if ( ! function_exists( 'pgscore_newsletter' ) ) {
		/**
		 * Newsletter shortcode.
		 *
		 * @param array $atts Shortcode attributes array.
		 * @return string
		 */
		function pgscore_newsletter( $atts ) {
			ob_start();
			?>
			<div class="pgscore_newsletter_wrapper">
				<?php
				$form_id = uniqid( 'pgscore_newsletter_form_' );
				?>
				<div class="newsletter-wrapper">
					<div class="newsletter">
						<div class="section-field">
							<div class="field-widget clearfix">
								<form class="newsletter_form" id="<?php echo esc_attr( $form_id ); ?>">
									<div class="input-area">
										<input type="text" class="placeholder newsletter-email" name="newsletter_email" placeholder="<?php echo esc_attr__( 'Enter your email', 'pgs-core' ); ?>">
									</div>
									<div class="button-area">
										<span class="input-group-btn">
											<button class="btn btn-icon newsletter-mailchimp submit" type="submit" data-form-id="<?php echo esc_attr( $form_id ); ?>"><?php echo esc_html__( 'Subscribe', 'pgs-core' ); ?></button>
										</span>
										<span class="newsletter-spinner spinimg-<?php echo esc_attr( $form_id ); ?>"></span>
									</div>
									<p class="newsletter-msg"></p>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
			return ob_get_clean();
		}
	}
	add_shortcode( 'pgscore_newsletter', 'pgscore_newsletter' );
}
