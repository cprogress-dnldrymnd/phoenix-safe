<?php

/**
 * Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 * @package CiyaShop
 */

/**
 * If your child theme has more than one .css file (eg. ie.css, style.css, main.css) then
 * you will have to make sure to maintain all of the parent theme dependencies.
 *
 * Make sure you're using the correct handle for loading the parent theme's styles.
 * Failure to use the proper tag will result in a CSS file needlessly being loaded twice.
 * This will usually not affect the site appearance, but it's inefficient and extends your page's loading time.
 *
 * @link https://codex.wordpress.org/Child_Themes
 */

define('theme_dir', get_stylesheet_directory_uri() . '/');
define('assets_dir', theme_dir . '/assets/');
define('image_dir', assets_dir . '/images/');
define('vendor_dir', assets_dir . '/vendors/');

function phoenix_safe_child_enqueue_styles()
{ // phpcs:ignore WordPress.WhiteSpace.ControlStructureSpacing.NoSpaceAfterOpenParenthesis

	wp_enqueue_style('ciyashop-style', get_parent_theme_file_uri('/css/style.css'), array(), '3.5.2');

	if (is_rtl()) {
		wp_enqueue_style('rtl-style', get_parent_theme_file_uri('/rtl.css'), array(), '3.5.2');
	}

	wp_enqueue_style(
		'phoenix-safe-child-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array('ciyashop-style'),
		wp_get_theme()->get('Version')
	);

	wp_enqueue_style('tissue-paper-swiper-css', vendor_dir . 'swiper/swiper-bundle.min.css');
	wp_enqueue_script('tissue-paper-swiper-js', vendor_dir . 'swiper/swiper-bundle.min.js');
	wp_enqueue_script('tissue-paper-js', assets_dir . 'js/main.js');
}
add_action('wp_enqueue_scripts', 'phoenix_safe_child_enqueue_styles', 11);


function newsletter()
{
	ob_start()
?>
	<div class="newsletter">
		<div class="row">
			<div class="col-lg-6">
				<div class="heading-box">
					<h3>
						Our Newsletter
					</h3>
				</div>
				<div class="description-box">
					<p>
						Sign up to our newsletter to get the latest news and offers.
					</p>
				</div>
			</div>
			<div class="col-lg-6">
				<?= do_shortcode('[contact-form-7 id="39193" title="Newsletter"]') ?>
				<div class="privacy-text">
					<p>
						By subscribing, you are agreeing to our <a href="<?= get_privacy_policy_url() ?>">Privacy Policy</a>.
					</p>
				</div>
			</div>
		</div>
	</div>
<?php
	return ob_get_clean();
}

add_shortcode('newsletter', 'newsletter');


/**
 * @snippet       Remove Add Cart
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 6
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

// First, remove Add to Cart Button

remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);


/*-----------------------------------------------------------------------------------*/
/* Register Carbonfields
/*-----------------------------------------------------------------------------------*/
add_action('carbon_fields_register_fields', 'tissue_paper_register_custom_fields');
function tissue_paper_register_custom_fields()
{
	require_once('includes/post-meta.php');
}

require_once('includes/woocommerce.php');


require_once('includes/ajax.php');


/*-----------------------------------------------------------------------------------*/

/* Get resources image
/*-----------------------------------------------------------------------------------*/

function get_resource_image($resource_type, $resource_thumbnail)
{


	if ($resource_type == 'Brochure') {

		$thumb = '<img src="' . get_stylesheet_directory_uri() . '/assets/images/thumb-3.jpg"/>';
	} else if ($resource_type == 'Technical Data') {

		$thumb = '<img src="' . get_stylesheet_directory_uri() . '/assets/images/thumb-1.jpg"/>';
	} else {
		$thumb = '<img src="' . get_stylesheet_directory_uri() . '/assets/images/thumb-2.jpg"/>';
	}

	if ($resource_thumbnail) {

		$return = '<img src="' . wp_get_attachment_image_url($resource_thumbnail, 'large') . '"/>';
	} else {
		$return = $thumb;
	}


	return $return;
}

function action_admin_head()
{
?>
	<style>
		#toplevel_page_ciyashop-panel .wp-menu-name {
			font-size: 0;
		}

		#toplevel_page_ciyashop-panel .wp-menu-image {
			background-image: url(<?= wp_get_attachment_image_url(92936, 'large') ?>);
			background-size: 25px;
			background-position: center;
			background-repeat: no-repeat;
		}

		#toplevel_page_ciyashop-panel .wp-menu-image img {
			display: none;
		}

		#toplevel_page_ciyashop-panel .wp-menu-name:before {
			font-size: 14px;
			content: 'Phoenix Safe';
		}

		#wp-admin-bar-ciyashop-options a {
			font-size: 0;
		}
		
		#wp-admin-bar-ciyashop-options .wp-menu-name:before {
			font-size: 14px;
			content: 'Phoenix Safe Options';
		}
	</style>
<?php
}

add_action('admin_head', 'action_admin_head');
