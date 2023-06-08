<?php
$loop           = isset( $settings['loop'] ) ? $settings['loop'] : '';
$grid_column_xl = isset( $settings['grid_column_xl'] ) ? $settings['grid_column_xl'] : 3;

$this->add_render_attribute(
	[
		'pgscore_recent_posts_grid' => [
			'class' => [
				'col-xs-12 col-sm-12 col-md-12 col-lg-6',
				'col-xl-' . ( 12 / $grid_column_xl ),
			],
		],
	]
);
?>
<div class="row">
	<?php
	while ( $loop->have_posts() ) {
		$loop->the_post();
		?>
		<div <?php $this->print_render_attribute_string( 'pgscore_recent_posts_grid' ); ?>>
			<?php $this->get_templates( "{$this->widget_slug}/loop/content", null, array( 'settings' => $settings ) ); ?>
		</div>
		<?php
	}
	/* Restore original Post Data */
	wp_reset_postdata();
	?>
</div>
