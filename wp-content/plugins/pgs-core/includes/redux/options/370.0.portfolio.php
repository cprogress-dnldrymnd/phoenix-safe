<?php
return array(
	'title'            => esc_html__( 'Portfolio', 'pgs-core' ),
	'id'               => 'portfolio_section',
	'customizer_width' => '400px',
	'icon'             => 'el el-th',
	'fields'           => array(
		array(
			'id'     => 'portfolio_list_start',
			'type'   => 'section',
			'title'  => esc_html__( 'Portfolio Listing', 'pgs-core' ),
			'indent' => true,
		),
		array(
			'id'      => 'portfolio_sidebar',
			'type'    => 'image_select',
			'title'   => esc_html__( 'Portfolio Sidebar', 'pgs-core' ),
			'desc'    => esc_html__( 'Select Portfolio sidebar alignment.', 'pgs-core' ),
			'options' => array(
				'full_width'    => array(
					'alt' => 'Full Width',
					'img' => PGSCORE_URL . 'images/options/blog_sidebar/full_width.png',
				),
				'left_sidebar'  => array(
					'alt' => 'Left Sidebar',
					'img' => PGSCORE_URL . 'images/options/blog_sidebar/left_sidebar.png',
				),
				'right_sidebar' => array(
					'alt' => 'Right Sidebar',
					'img' => PGSCORE_URL . 'images/options/blog_sidebar/right_sidebar.png',
				),
			),
			'default' => 'full_width',
		),
		array(
			'id'       => 'portfolio_column_size',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Portfolio Column Size', 'pgs-core' ),
			'options'  => array(
				'2' => '2 Column',
				'3' => '3 Column',
				'4' => '4 Column',
				'6' => '6 Column',
			),
			'default'  => '3',
			'required' => array(
				array( 'portfolio_sidebar', 'equals', 'full_width' ),
			),
		),
		array(
			'id'       => 'portfolio_space',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Space between Portfolio', 'pgs-core' ),
			'subtitle' => esc_html__( 'Select Space between Portfolio in px.', 'pgs-core' ),
			'options'  => array(
				'0'  => '0',
				'5'  => '5',
				'10' => '10',
				'15' => '15',
				'20' => '20',
				'25' => '25',
				'30' => '30',
			),
			'default'  => '10',
		),
		array(
			'id'       => 'portfolio_style',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Portfolio Style', 'pgs-core' ),
			'subtitle' => esc_html__( 'Select portfolio style.', 'pgs-core' ),
			'options'  => array(
				'style-1' => array(
					'alt' => esc_html__( 'Style 1', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/shortcodes/portfolio/style1.jpg',
				),
				'style-2' => array(
					'alt' => esc_html__( 'Style 2', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/shortcodes/portfolio/style2.jpg',
				),
				'style-3' => array(
					'alt' => esc_html__( 'Style 3', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/shortcodes/portfolio/style3.jpg',
				),
				'style-4' => array(
					'alt' => esc_html__( 'Style 4', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/shortcodes/portfolio/style4.jpg',
				),
				'style-5' => array(
					'alt' => esc_html__( 'Style 5', 'pgs-core' ),
					'img' => PGSCORE_URL . 'images/shortcodes/portfolio/style5.jpg',
				),
			),
			'default'  => 'style-1',
		),
		array(
			'id'      => 'display_portfolio_categories_filters',
			'type'    => 'switch',
			'title'   => esc_html__( 'Show categories filters', 'pgs-core' ),
			'default' => true,
		),
		array(
			'id'      => 'portfolio_pagination',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Portfolio Pagination', 'pgs-core' ),
			'options' => array(
				'pagination'      => esc_html__( 'Pagination', 'pgs-core' ),
				'load_more'       => esc_html__( 'Load More', 'pgs-core' ),
				'infinite_scroll' => esc_html__( 'Infinite Scroll', 'pgs-core' ),
			),
			'default' => 'pagination',
		),
		array(
			'id'            => 'portfolio_per_page',
			'type'          => 'slider',
			'title'         => esc_html__( 'Number of portfolio per Page', 'pgs-core' ),
			'subtitle'      => esc_html__( 'Select number of portfolio to display per page.', 'pgs-core' ),
			'default'       => '9',
			'min'           => 1,
			'step'          => 1,
			'max'           => 40,
			'display_value' => 'text',
		),
		array(
			'id'       => 'portfolio_order_by',
			'type'     => 'select',
			'title'    => esc_html__( 'Portfolio Order By', 'pgs-core' ),
			'subtitle' => esc_html__( 'Portfolio order by options', 'pgs-core' ),
			'options'  => array(
				'title'        => esc_html__( 'Title', 'pgs-core' ),
				'publish_date' => esc_html__( 'Date', 'pgs-core' ),
				'modified'     => esc_html__( 'Modified', 'pgs-core' ),
				'ID'           => esc_html__( 'ID', 'pgs-core' ),
			),
			'default'  => 'title',
		),
		array(
			'id'       => 'portfolio_order',
			'type'     => 'select',
			'title'    => esc_html__( 'Portfolio Order', 'pgs-core' ),
			'subtitle' => esc_html__( 'Select portfolio order', 'pgs-core' ),
			'options'  => array(
				'ASC'  => esc_html__( 'ASC', 'pgs-core' ),
				'DESC' => esc_html__( 'DESC', 'pgs-core' ),
			),
			'default'  => 'ASC',
		),
		array(
			'id'       => 'portfolio_fullscreen',
			'type'     => 'switch',
			'title'    => esc_html__( 'Portfolio Fullscreen', 'pgs-core' ),
			'default'  => false,
			'required' => array(
				array( 'portfolio_sidebar', 'equals', 'full_width' ),
			),
		),
		array(
			'id'     => 'portfolio_list_end',
			'type'   => 'section',
			'indent' => false,
		),
		array(
			'id'     => 'portfolio_single_start',
			'type'   => 'section',
			'title'  => esc_html__( 'Portfolio Details', 'pgs-core' ),
			'indent' => true,
		),
		array(
			'id'      => 'display_portfolio_navigation',
			'type'    => 'switch',
			'title'   => esc_html__( 'Display Portfolio Navigation', 'pgs-core' ),
			'default' => true,
		),
		array(
			'id'      => 'display_related_portfolio',
			'type'    => 'switch',
			'title'   => esc_html__( 'Display Related Portfolio', 'pgs-core' ),
			'default' => true,
		),
		array(
			'id'       => 'related_portfolio_title',
			'type'     => 'text',
			'title'    => esc_html__( 'Related Portfolio Title', 'pgs-core' ),
			'desc'     => esc_html__( 'Enter related portfolio title.', 'pgs-core' ),
			'default'  => 'Related Portfolio',
			'required' => array(
				array( 'display_related_portfolio', '=', true ),
			),
		),
		array(
			'id'            => 'no_of_related_portfolio',
			'type'          => 'slider',
			'title'         => esc_html__( 'Number of Related Portfolio', 'pgs-core' ),
			'desc'          => esc_html__( 'Enter number of related portfolio.', 'pgs-core' ),
			'default'       => '4',
			'min'           => 1,
			'step'          => 1,
			'max'           => 20,
			'display_value' => 'text',
			'required'      => array(
				array( 'display_related_portfolio', '=', true ),
			),
		),
		array(
			'id'     => 'portfolio_single_end',
			'type'   => 'section',
			'indent' => false,
		),
	),
);
