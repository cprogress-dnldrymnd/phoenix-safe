<?php
$reference_array  = array();
$style            = isset( $settings['style'] ) ? $settings['style'] : '';
$box_shape        = isset( $settings['box_shape'] ) ? $settings['box_shape'] : '';
$list_items       = isset( $settings['list'] ) ? $settings['list'] : '';

if ( ! is_array( $list_items ) || ! $list_items || ! $list_items[0] ) {
	return null;
}

foreach ( $list_items as $key => $row ) {
	if ( isset( $row['timeline_date'] ) ) {
		$reference_array[ $key ] = $row['timeline_date'];
	}
}
if ( sizeof( $reference_array ) == sizeof( $list_items ) ) {
	array_multisort( $reference_array, $list_items, $direction );
}

$this->add_render_attribute( 'pgscore_timeline', 'class', 'pgscore-timeline timeline list-style-none pgscore-timeline-' . $style );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<ul <?php $this->print_render_attribute_string( 'pgscore_timeline' ); ?>>
		<?php
		$timeline_sr = 1;
		foreach ( $list_items as $list_item ) {
			$item_classes   = array();
			$item_classes[] = 'timeline-item';
			$item_classes[] = $timeline_sr % 2 ? 'timeline-item-odd' : 'timeline-item-even timeline-inverted';
			$item_classes   = implode( ' ', $item_classes );

			if ( ( isset( $list_item['timeline_title'] ) && $list_item['timeline_title'] ) || isset( $list_item['timeline_description'] ) && $list_item['timeline_description'] ) {
				?>
				<li class="<?php echo esc_attr( $item_classes ); ?>">
					<div class="timeline-badge">
						<h4><?php echo esc_html( $timeline_sr ); ?></h4>
					</div>
					<div class="timeline-panel timeline-<?php echo esc_attr( $box_shape ); ?>">
						<div class="timeline-heading">
							<?php
							if ( isset( $list_item['timeline_title'] ) && $list_item['timeline_title'] ) {
								?>
								<h5 class="timeline-title"><?php echo esc_html( $list_item['timeline_title'] ); ?></h5>
								<?php
							}
							?>
						</div>
						<?php
						if ( isset( $list_item['timeline_description'] ) && $list_item['timeline_description'] ) {
							?>
							<div class="timeline-body">
								<p><?php echo esc_html( $list_item['timeline_description'] ); ?></p>
							</div>
							<?php
						}
						?>
					</div>
				</li>
				<?php
				$timeline_sr++;
			}
		}
		?>
	</ul>
</div>
