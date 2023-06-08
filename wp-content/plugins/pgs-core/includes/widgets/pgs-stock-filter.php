<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Adds PGS Stok Filter widget.
 *
 * @package CiyaShop/Widgets
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

class PGS_Stock_filter_Widget extends WC_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {

		$this->widget_cssclass    = 'pgs_stock_filter_Widget';
		$this->widget_description = esc_html__( 'This wil display the products in sale and in stock.', 'pgs-core' );
		$this->widget_id          = 'PGS_Stock_filter_Widget';
		$this->widget_name        = esc_html__( 'PGS Stock Filter', 'pgs-core' );
		parent::__construct();

		add_action( 'woocommerce_product_query', array( $this, 'show_products_in_stock' ) );
		add_filter( 'loop_shop_post_in', array( $this, 'show_products_on_sale' ) );
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WC_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		global $ciyashop_options;

		if ( ! is_shop() && ! is_product_taxonomy() ) {
			return;
		}

		echo $args['before_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped

		$title                = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance );
		$current_stock_status = isset( $_GET['stock_status'] ) ? explode( ',', $_GET['stock_status'] ) : array();
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
		}
		?>
		<ul class="pgs-woocommerce-widget-stock-status-widget">
			<?php if ( $instance['onsale'] ) : ?>
				<li class="pgs-woocommerce-widget-stock-status-widget-item onsale <?php echo in_array( 'onsale', $current_stock_status, true ) ? 'active' : ''; ?>">
					<a href="<?php echo esc_url( $this->get_field_link( 'onsale' ) ); ?>" class="<?php echo in_array( 'onsale', $current_stock_status, true ) ? 'active' : ''; ?>">
						<span class="pgs-checkbox"></span>
						<?php esc_html_e( 'On sale', 'pgs-core' ); ?>
					</a>
				</li>
			<?php endif; ?>

			<?php if ( $instance['instock'] ) : ?>
				<li class="pgs-woocommerce-widget-stock-status-widget-item instock <?php echo in_array( 'instock', $current_stock_status, true ) ? 'active' : ''; ?>">
					<a href="<?php echo esc_url( $this->get_field_link( 'instock' ) ); ?>" class="<?php echo in_array( 'instock', $current_stock_status, true ) ? 'active' : ''; ?>">
						<span class="pgs-checkbox"></span>
						<?php esc_html_e( 'In stock', 'pgs-core' ); ?>
					</a>
				</li>
			<?php endif; ?>

			<?php if ( $instance['onbackorder'] ) : ?>
				<li class="pgs-woocommerce-widget-stock-status-widget-item onbackorder <?php echo in_array( 'onbackorder', $current_stock_status, true ) ? 'active' : ''; ?>">
					<a href="<?php echo esc_url( $this->get_field_link( 'onbackorder' ) ); ?>" class="<?php echo in_array( 'onbackorder', $current_stock_status, true ) ? 'active' : ''; ?>">
						<span class="pgs-checkbox"></span>
						<?php esc_html_e( 'On Backorder', 'pgs-core' ); ?>
					</a>
				</li>
			<?php endif; ?>
		</ul>
		<?php

		echo $args['after_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title       = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Stock Filter', 'pgs-core' );
		$onsale      = ! empty( $instance['onsale'] ) ? $instance['onsale'] : '';
		$instock     = ! empty( $instance['instock'] ) ? $instance['instock'] : '';
		$onbackorder = ! empty( $instance['onbackorder'] ) ? $instance['onbackorder'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'pgs-core' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" type="text" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<input type="checkbox" class="ciyashop-checkbox" name="<?php echo esc_attr( $this->get_field_name( 'onsale' ) ); ?>" value="1" <?php checked( $onsale, 1 ); ?>>
			<?php esc_html_e( 'On sale', 'pgs-core' ); ?>
		</p>
		<p>
			<input type="checkbox" class="ciyashop-checkbox" name="<?php echo esc_attr( $this->get_field_name( 'instock' ) ); ?>" value="1" <?php checked( $instock, 1 ); ?>>
			<?php esc_html_e( 'In stock', 'pgs-core' ); ?>
		</p>
		<p>
			<input type="checkbox" class="ciyashop-checkbox" name="<?php echo esc_attr( $this->get_field_name( 'onbackorder' ) ); ?>" value="1" <?php checked( $onbackorder, 1 ); ?>>
			<?php esc_html_e( 'On backorder', 'pgs-core' ); ?>
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                = array();
		$instance['title']       = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['onsale']      = ( ! empty( $new_instance['onsale'] ) ) ? wp_strip_all_tags( $new_instance['onsale'] ) : '';
		$instance['instock']     = ( ! empty( $new_instance['instock'] ) ) ? wp_strip_all_tags( $new_instance['instock'] ) : '';
		$instance['onbackorder'] = ( ! empty( $new_instance['onbackorder'] ) ) ? wp_strip_all_tags( $new_instance['onbackorder'] ) : '';

		return $instance;
	}

	/**
	 * Get the link for current filter
	 *
	 * @param string $status
	 *
	 * @return string link of for the filter.
	 */
	public function get_field_link( $status ) {
		$base_link            = pgs_core_get_shop_page_url();
		$link                 = remove_query_arg( 'stock_status', $base_link );
		$current_stock_status = isset( $_GET['stock_status'] ) ? explode( ',', $_GET['stock_status'] ) : array();
		$option_is_set        = in_array( $status, $current_stock_status );

		if ( ! in_array( $status, $current_stock_status ) ) {
			$current_stock_status[] = $status;
		}

		foreach ( $current_stock_status as $key => $value ) {
			if ( $option_is_set && $value === $status ) {
				unset( $current_stock_status[ $key ] );
			}
		}

		if ( $current_stock_status ) {
			asort( $current_stock_status );
			$link = add_query_arg( 'stock_status', implode( ',', $current_stock_status ), $link );
			$link = str_replace( '%2C', ',', $link );
		}

		return $link;
	}

	/**
	 * Show in stock products.
	 *
	 * @param object $query
	 */
	public function show_products_in_stock( $query ) {
		$current_stock_status = isset( $_GET['stock_status'] ) ? explode( ',', $_GET['stock_status'] ) : array(); //phpcs:ignore

		if ( in_array( 'instock', $current_stock_status, true ) || in_array( 'onbackorder', $current_stock_status, true ) ) {
			$meta_query = array(
				'relation' => 'AND',
			);

			if ( in_array( 'instock', $current_stock_status, true ) ) {
				$meta_query[] = array(
					'key'     => '_stock_status',
					'value'   => 'instock',
					'compare' => '=',
				);
			}

			if ( in_array( 'onbackorder', $current_stock_status, true ) ) {
				$meta_query[] = array(
					'key'     => '_stock_status',
					'value'   => 'onbackorder',
					'compare' => '=',
				);
			}

			$query->set( 'meta_query', array_merge( WC()->query->get_meta_query(), $meta_query ) );
		}
	}

	/**
	 * Show product on sale.
	 *
	 * @param array $ids array of id.
	 */
	public function show_products_on_sale( $ids ) {
		$current_stock_status = isset( $_GET['stock_status'] ) ? explode( ',', $_GET['stock_status'] ) : array();
		if ( in_array( 'onsale', $current_stock_status ) ) {
			$ids = array_merge( $ids, wc_get_product_ids_on_sale() );
		}

		return $ids;
	}
}
