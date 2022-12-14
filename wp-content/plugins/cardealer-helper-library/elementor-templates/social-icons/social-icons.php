<?php
/**
 * Social icons widget template
 *
 * @package car-dealer-helper
 */

$style      = isset( $settings['style'] ) ? $settings['style'] : '';
$list_items = isset( $settings['list_items'] ) ? $settings['list_items'] : array();

if ( ! is_array( $list_items ) || empty( $list_items ) || ( 1 === (int) ( count( $list_items ) ) && empty( $list_items[0] ) ) ) {
	return;
}

$this->add_render_attribute(
	[
		'cdhl_social_icons' => [
			'class' => [
				'social',
				$style,
			],
			'id'    => [
				$this->get_id(),
			],
		],
	]
);
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_social_icons' ); ?>>
		<?php
		foreach ( $list_items as $list_item ) {
			$el_id = isset( $list_item['_id'] ) ? $list_item['_id'] : uniqid();
			if ( isset( $list_item['link_url']['url'] ) && $list_item['link_url']['url'] ) {
				if ( isset( $list_item['link_url']['is_external'] ) && $list_item['link_url']['is_external'] ) {
					$this->add_render_attribute( 'cdhl_social_icons_' . $el_id, 'target', '_blank' );
				}
				if ( isset( $list_item['link_url']['nofollow'] ) && $list_item['link_url']['nofollow'] ) {
					$this->add_render_attribute( 'cdhl_social_icons_' . $el_id, 'rel', 'nofollow' );
				}
				if ( isset( $list_item['link_url']['url'] ) && $list_item['link_url']['url'] ) {
					$this->add_render_attribute( 'cdhl_social_icons_' . $el_id, 'href', $list_item['link_url']['url'] );
				}
				if ( isset( $list_item['title'] ) && $list_item['title'] ) {
					$this->add_render_attribute( 'cdhl_social_icons_' . $el_id, 'title', $list_item['title'] );
				}
			}
			?>
			<a <?php $this->print_render_attribute_string( 'cdhl_social_icons_' . $el_id ); ?>>
				<?php
				if ( isset( $list_item['icon_class'] ) && $list_item['icon_class'] ) {
					?>
					<i class="<?php echo esc_attr( $list_item['icon_class'] ); ?>"></i>
					<?php
				}
				?>
			</a>
			<?php
		}
		?>
	</div>
</div>
