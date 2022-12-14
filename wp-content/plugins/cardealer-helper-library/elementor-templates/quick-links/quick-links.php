<?php
/**
 * Quick links Elementor widget template
 *
 * @package car-dealer-helper
 */

$url        = isset( $settings['url'] ) ? $settings['url'] : '';
$list_items = isset( $settings['list_items'] ) ? $settings['list_items'] : '';

if ( ! is_array( $list_items ) || empty( $list_items ) || ( ( 1 === (int) count( $list_items ) ) && empty( $list_items[0] ) ) ) {
	return;
}
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<?php
	foreach ( $list_items as $list_item ) {
		$el_id               = isset( $list_item['_id'] ) ? $list_item['_id'] : uniqid();
		$cdhl_quick_links_id = 'cdhl_quick_links_' . $el_id;
		$hover_style         = isset( $list_item['hover_style'] ) ? $list_item['hover_style'] : '';

		$this->add_render_attribute( $cdhl_quick_links_id, 'class', 'q-link' );
		if ( $hover_style ) {
			$this->add_render_attribute( $cdhl_quick_links_id, 'class', 'box-hover' );
		}
		if ( isset( $list_item['url']['is_external'] ) && $list_item['url']['is_external'] ) {
			$this->add_render_attribute( $cdhl_quick_links_id, 'target', '_blank' );
		}
		if ( isset( $list_item['url']['nofollow'] ) && $list_item['url']['nofollow'] ) {
			$this->add_render_attribute( $cdhl_quick_links_id, 'rel', 'nofollow' );
		}
		if ( isset( $list_item['url']['url'] ) && $list_item['url']['url'] ) {
			$this->add_render_attribute( $cdhl_quick_links_id, 'href', $list_item['url']['url'] );
		}
		$this->add_render_attribute( $cdhl_quick_links_id, 'id', $el_id );
		?>
		<a <?php $this->print_render_attribute_string( $cdhl_quick_links_id ); ?>>
			<?php
			\Elementor\Icons_Manager::render_icon( $list_item['icon'], [ 'aria-hidden' => 'true' ] );
			if ( $list_item['title'] ) {
				?>
				<h6><?php echo esc_html( $list_item['title'] ); ?></h6>
				<?php
			}
			?>
		</a>
		<?php
	}
	?>
</div>
