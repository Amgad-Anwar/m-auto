<?php
/**
 * Timeline Elementor widget template
 *
 * @package car-dealer-helper
 */

$list_items = isset( $settings['list'] ) ? $settings['list'] : '';

if ( ! is_array( $list_items ) || ! $list_items || ! $list_items[0] ) {
	return;
}

// Sort List items by date.
cdhl_array_sort_by_column( $list_items, 'timeline_date' );

$this->add_render_attribute( 'cdhl_timeline', 'class', 'cd_timeline cd_timeline-vertical our-history' );
$this->add_render_attribute( 'cdhl_timeline', 'id', $this->get_id() );

$this->add_render_attribute( 'cdhl_timeline_list', 'class', 'timeline list-style-none' );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_timeline' ); ?>>
		<ul <?php $this->print_render_attribute_string( 'cdhl_timeline_list' ); ?>>
			<?php
			$timeline_sr = 1;
			foreach ( $list_items as $list_item ) {
				$item_classes   = array();
				$item_classes[] = 'timeline-item';
				$item_classes[] = $timeline_sr % 2 ? 'timeline-item-odd' : 'timeline-item-even timeline-inverted';
				$item_classes   = implode( ' ', array_filter( array_unique( $item_classes ) ) );
				if ( ! empty( $list_item ) ) {
					?>
					<li class="<?php echo esc_attr( $item_classes ); ?>">
						<div class="timeline-badge"><h4><?php echo esc_html( $timeline_sr ); ?></h4></div>
						<div class="timeline-panel">
							<div class="timeline-heading">
								<?php
								if ( isset( $list_item['timeline_title'] ) ) {
									?>
									<h5><?php echo esc_html( $list_item['timeline_title'] ); ?></h5>
									<?php
								}
								?>
							</div>
							<?php
							if ( isset( $list_item['timeline_description'] ) ) {
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
				}
				$timeline_sr++;
			}
			?>
		</ul>
	</div>
</div>
