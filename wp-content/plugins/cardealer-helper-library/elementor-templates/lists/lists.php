<?php
/**
 * List Elementor widget template
 *
 * @package car-dealer-helper
 */

$icon       = isset( $settings['icon'] ) ? $settings['icon'] : '';
$add_icon   = isset( $settings['add_icon'] ) ? $settings['add_icon'] : '';
$list_items = isset( $settings['list_items'] ) ? $settings['list_items'] : '';

if ( ! is_array( $list_items ) || empty( $list_items ) || ( ( 1 === (int) count( $list_items ) ) && empty( $list_items[0] ) ) ) {
	return;
}

$this->add_render_attribute( 'cdhl_list', 'class', 'list' );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<ul <?php $this->print_render_attribute_string( 'cdhl_list' ); ?>>
		<?php
		foreach ( $list_items as $list_item ) {
			if ( $list_item['content'] ) {
				?>
				<li>
					<?php
					if ( 'yes' === $add_icon ) {
						\Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
					}
					?>
					<span><?php echo esc_html( $list_item['content'] ); ?></span>
				</li>
				<?php
			}
		}
		?>
	</ul>
</div>
