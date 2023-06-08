<?php
/**
 * Class to display PGS Campaigns.
 *
 * @link       http://www.potenzaglobalsolutions.com/
 * @since 4.9.1
 *
 * @package CiyaShop
 */

/**
 * The PGS_Campaigns class.
 */
class PGS_Campaigns {

	/**
	 * Campaign URL.
	 *
	 * @var string
	 */
	public $campaign_url = 'https://dinesh4monto.gitlab.io/pgs-campaigns/ciyashop.json';

	/**
	 * Campaign dismiss key.
	 *
	 * @var string
	 */
	public $campaign_dismiss_key = 'pgs_campaign_solo_dismissed';

	/**
	 * Campaign data key.
	 *
	 * @var string
	 */
	public $campaign_data_key = 'pgs_campaign_solo_data';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 4.9.1
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'fetch_campaign_solo_data_cronjob' ) );
		add_action( 'wp_ajax_hide_campaign_solo', array( $this, 'hide_campaign_solo_ajax' ) );
		add_action( 'admin_notices', array( $this, 'campaign_solo_notice' ) );
		add_action( 'admin_head', array( $this, 'campaign_solo_css' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Get campaign url.
	 *
	 * @return string
	 */
	public function get_campaign_url() {
		return apply_filters( 'pgs_campaigns_get_campaign_url', $this->campaign_url );
	}

	/**
	 * Get campaign expiration time.
	 *
	 * @return string
	 */
	public function get_dismiss_expiration() {
		return apply_filters( 'pgs_campaign_dismiss_expiration', MONTH_IN_SECONDS );
	}

	/**
	 * Cronjob function.
	 *
	 * @return void
	 */
	public function fetch_campaign_solo_data_cronjob() {
		add_action( 'pgs_campaign_solo_cron_action', array( $this, 'fetch_campaign_solo_data' ) );
		if ( ! wp_next_scheduled( 'pgs_campaign_solo_cron_action' ) ) {
			wp_schedule_event( time(), 'daily', 'pgs_campaign_solo_cron_action' );
			do_action( 'pgs_campaign_solo_cron_action' );
		}
	}

	/**
	 * Function to fetch campaign data from the server.
	 *
	 * @return void
	 */
	public function fetch_campaign_solo_data() {

		$campaign_url = $this->get_campaign_url();
		$response     = wp_remote_get( $campaign_url );

		if ( is_array( $response ) && ! is_wp_error( $response ) ) {
			$response_body         = wp_remote_retrieve_body( $response );
			$response_body_decoded = json_decode( $response_body, true );
			$new_data              = false;

			if ( $response_body_decoded && null !== $response_body_decoded ) {
				$new_data = $response_body_decoded;
			}

			if ( $new_data && is_array( $new_data ) && ! empty( $new_data ) ) {

				$old_data      = $this->get_campaign_solo_data();
				$old_data_hash = md5( serialize( $old_data ) );
				$new_data_hash = md5( serialize( $new_data ) );

				if ( $old_data_hash !== $new_data_hash ) {
					update_option( $this->campaign_data_key, wp_json_encode( $new_data ) );
				}
			}
		}
	}

	/**
	 * Update status on Ajax request.
	 *
	 * @return void
	 */
	public function hide_campaign_solo_ajax() {
		check_ajax_referer( 'hide_campaign_solo_action', 'campaign_solo_nonce' );

		if ( ! current_user_can( 'edit_theme_options' ) ) {
			wp_die( -1 );
		}

		$dismiss_expiration = $this->get_dismiss_expiration();
		set_transient( $this->campaign_dismiss_key, 1, $dismiss_expiration );

		wp_die( 1 );
	}

	/**
	 * Get campaign dismissed status.
	 *
	 * @return boolean
	 */
	public function campaign_solo_dismissed() {

		$campaign_dismissed = get_transient( $this->campaign_dismiss_key );
		$campaign_dismissed = filter_var( $campaign_dismissed, FILTER_VALIDATE_BOOLEAN );

		return $campaign_dismissed;
	}

	/**
	 * Get campaign enabled status.
	 *
	 * @return boolean
	 */
	public function campaign_solo_enabled() {

		$campaign_enabled = true;
		$campaign_data    = $this->get_campaign_solo_data();
		$curretn_time     = time();
		$campaign_old     = false;

		// Campaign debug.
		$campaign_debug = false;
		if ( defined( 'PGS_CAMPAIGN_DEBUG' ) && PGS_CAMPAIGN_DEBUG ) {
			$campaign_debug = true;
		}

		if ( $campaign_debug ) {
			echo '<pre>';
			print_r( $campaign_data );
			echo '</pre>';
			$campaign_debug_data = array();
			foreach ( $campaign_data as $k => $v ) {
				if ( in_array( $k, array( 'start_date', 'end_date', 'last_modified' ), true ) ) {
					$date = $this->timestamp_to_datetime( $v );
					$date->setTimezone( new DateTimeZone( 'Asia/Calcutta' ) );
					$campaign_debug_data[ str_pad( $k, strlen( 'last_modified' ) ) ] = $date->format( 'Y-m-d H:i:s' );
				}
			}
			echo '<pre>';
			print_r( $campaign_debug_data );
			echo '</pre>';
		}

		if ( isset( $campaign_data['end_date'] ) && ! empty( $campaign_data['end_date'] ) && $campaign_data['end_date'] < $curretn_time ) {
			$campaign_enabled = false;
			$campaign_old     = true;
		}

		$campaign_dismissed = $this->campaign_solo_dismissed();

		if ( $campaign_dismissed ) {
			$campaign_enabled = false;
		}

		if ( $campaign_debug ) {
			var_dump( $campaign_dismissed ? 'Campaign Dismissed' : 'Campaign NOT Dismissed' );
			var_dump( $campaign_old ? 'Campaign OLD' : 'Campaign NEW' );
		}

		return $campaign_enabled;
	}

	/**
	 * Get campaign data.
	 *
	 * @return mixed
	 */
	public function get_campaign_solo_data() {
		$campaign_data      = false;
		$saved_data         = get_option( $this->campaign_data_key );
		$saved_data_decoded = json_decode( $saved_data, true );

		if ( $saved_data_decoded && null !== $saved_data_decoded ) {
			$campaign_data = $saved_data_decoded;
		}

		return $campaign_data;
	}

	/**
	 * Display notice.
	 *
	 * @return void
	 */
	public function campaign_solo_notice() {

		$campaign_enabled = $this->campaign_solo_enabled();

		if ( ! $campaign_enabled ) {
			return;
		}

		$screens       = array( 'dashboard' );
		$campaign_data = $this->get_campaign_solo_data();
		$screen        = get_current_screen();

		if ( isset( $campaign_data['screens'] ) && ! empty( $campaign_data['screens'] ) ) {
			$screens = explode( ',', $campaign_data['screens'] );
			$screens = array_filter( $screens );
			$screens = array_map( 'trim', $screens );
		}

		if ( ! in_array( $screen->id, $screens, true ) ) {
			return;
		}

		$show_campaign = false;

		if (
			! empty( $campaign_data )
			&& is_array( $campaign_data )
			&& ( isset( $campaign_data['link'] ) && ! empty( $campaign_data['link'] ) )
			&& ( isset( $campaign_data['image'] ) && ! empty( $campaign_data['image'] ) )
		) {
			$show_campaign = true;
		}

		if ( ! $show_campaign ) {
			return;
		}

		$link  = $campaign_data['link'];
		$image = $campaign_data['image'];

		$class   = 'pgs-campaign-solo notice is-dismissible';
		$message = sprintf(
			'<a class="pgs-campaign-solo-banner-link" href="%1$s" target="_blank"><img class="pgs-campaign-solo-banner-img" src="%2$s"></a><a href="#" class="pgs-campaign-solo-dismiss button">%3$s</a>',
			$link,
			$image,
			esc_html__( 'Dismiss', 'ciyashop' )
		);

		printf(
			'<div class="%1$s">%2$s</div>',
			esc_attr( $class ),
			wp_kses(
				$message,
				array(
					'img' => array(
						'class' => true,
						'src'   => true,
					),
					'a'   => array(
						'href'   => true,
						'target' => true,
						'class'  => true,
					),
				)
			)
		);
	}

	/**
	 * Enqueue CSS.
	 *
	 * @return void
	 */
	public function campaign_solo_css() {
		?>
		<style>
		.wp-core-ui .notice.pgs-campaign-solo {
			border: none;
			padding: 0;
			display: grid;
		}
		.wp-core-ui .notice.pgs-campaign-solo .pgs-campaign-solo-banner-link {
			display: inline-flex;
		}
		.wp-core-ui .notice.pgs-campaign-solo .pgs-campaign-solo-banner-img {
			width: 100%;
			height: auto;
		}
		.wp-core-ui .notice.pgs-campaign-solo .pgs-campaign-solo-dismiss {
			position: absolute;
			bottom: 10px;
			left: 10px;
		}
		.wp-core-ui .notice.pgs-campaign-solo .notice-dismiss {
			background-color: rgba(255, 255, 255, 0.25);
		}
		</style>
		<?php
	}

	/**
	 * Enqueue JS.
	 *
	 * @return void
	 */
	public function admin_scripts() {
		$dismiss_url_args = array(
			'action'              => 'hide_campaign_solo',
			'campaign_solo_nonce' => wp_create_nonce( 'hide_campaign_solo_action' ),
		);

		$dismiss_url = add_query_arg( $dismiss_url_args, admin_url( 'admin-ajax.php' ) );

		ob_start();
		?>
		(function($){
			"use strict";

			$( window ).load(function() {
				$(".wp-core-ui .notice.pgs-campaign-solo .pgs-campaign-solo-dismiss").click(function(e){
					e.preventDefault();

					var data;
					var campaign_solo_post_url = '<?php echo $dismiss_url; ?>';

					// Hide it
					$(".wp-core-ui .notice.pgs-campaign-solo").hide();

					// Save this preference.
					$.post(campaign_solo_post_url, data, function(response) {
						//alert(response);
					});
				});
			});

		})(jQuery);
		<?php
		$jquery_script = ob_get_clean();
		wp_enqueue_script( 'jquery' );
		wp_add_inline_script( 'jquery', $jquery_script );
	}

	/**
	 * Convert timestamp to datetime object.
	 *
	 * @param int|string $timestamp Timestamp.
	 * @return DateTime
	 */
	public function timestamp_to_datetime( $timestamp ) {

		$dt_new = new DateTime();
		$dt_new->setTimestamp( $timestamp );

		return $dt_new;
	}
}
new PGS_Campaigns();
