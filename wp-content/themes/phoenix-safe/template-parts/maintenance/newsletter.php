<?php
/**
 * The template for displaying the newsletter
 *
 * @package Ciyashop
 */

global $ciyashop_options;

if ( ( isset( $ciyashop_options['comming_soon_newsletter'] ) && 1 === (int) $ciyashop_options['comming_soon_newsletter'] ) && ( ciyashop_check_plugin_active( 'mailchimp-for-wp/mailchimp-for-wp.php' ) ) && ( isset( $ciyashop_options['comming_page_newsletter_shortcode'] ) && ! empty( $ciyashop_options['comming_page_newsletter_shortcode'] ) ) ) {
	$mailchimp_id = $ciyashop_options['comming_page_newsletter_shortcode'];
	?>
	<div class="action-box maintenance-newsletter">
		<div class="container">
			<div class="row justify-content-center text-center">
				<div class="col-sm-8"> 
					<h5><?php esc_html_e( 'We will notify you when site is ready :', 'ciyashop' ); ?></h5>
					<h3><?php esc_html_e( 'Provide your email address!', 'ciyashop' ); ?></h3>
					<?php
					if ( $mailchimp_id ) {
						echo do_shortcode( '[mc4wp_form id=' . $mailchimp_id . ']' );
					}
					?>
				</div>			
			</div>
		</div>
	</div>
	<?php
}
