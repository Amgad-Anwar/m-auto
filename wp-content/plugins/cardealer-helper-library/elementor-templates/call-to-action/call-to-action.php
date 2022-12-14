<?php
/**
 * Call to cation Elementor widget template
 *
 * @package car-dealer-helper
 */

$box_bg_image = array();
$icon         = isset( $settings['icon'] ) ? $settings['icon'] : '';
$action_title = isset( $settings['title'] ) ? $settings['title'] : '';
$description  = isset( $settings['description'] ) ? $settings['description'] : '';

if ( isset( $settings['readmore_link']['url'] ) && $settings['readmore_link']['url'] ) {
	if ( isset( $settings['readmore_link']['is_external'] ) && $settings['readmore_link']['is_external'] ) {
		$this->add_render_attribute( 'cdhl_call_to_action_button', 'target', '_blank' );
	}
	if ( isset( $settings['readmore_link']['nofollow'] ) && $settings['readmore_link']['nofollow'] ) {
		$this->add_render_attribute( 'cdhl_call_to_action_button', 'rel', 'nofollow' );
	}
	if ( isset( $settings['readmore_link']['url'] ) && $settings['readmore_link']['url'] ) {
		$this->add_render_attribute( 'cdhl_call_to_action_button', 'href', $settings['readmore_link']['url'] );
	}
}

if ( isset( $settings['box_bg_image'] ) && isset( $settings['box_bg_image']['id'] ) && $settings['box_bg_image']['id'] ) {
	$box_bg_image = wp_get_attachment_image_src( $settings['box_bg_image']['id'], 'full' );
}

if ( ! $action_title || ! $description ) {
	return;
}

$this->add_render_attribute(
	[
		'cdhl_call_to_action' => [
			'class' => [
				'call-to-action',
				'text-center',
			],
			'id'    => [
				'cd_call_to_action_' . $this->get_id(),
			],
		],
	]
);
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_call_to_action' ); ?>>
		<div class="action-info">
			<?php
			if ( $icon ) {
				\Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
			}
			?>
			<h5><?php echo esc_html( $action_title ); ?></h5>
			<p><?php echo esc_html( $description ); ?></p>
		</div>
		<a <?php $this->print_render_attribute_string( 'cdhl_call_to_action_button' ); ?>>
			<?php echo esc_html__( 'Read more', 'cardealer-helper' ); ?>
		</a>
		<?php
		if ( isset( $box_bg_image[0] ) && $box_bg_image[0] ) {
			$this->add_render_attribute( 'cdhl_call_to_action_bg_image', 'class', 'action-img' );
			$this->add_render_attribute( 'cdhl_call_to_action_bg_image', 'style', 'background-image: url(' . esc_url( $box_bg_image[0] ) . ');' );
			?>
			<div <?php $this->print_render_attribute_string( 'cdhl_call_to_action_bg_image' ); ?>></div>
			<?php
		}
		?>
		<span class="border"></span>
	</div>
</div>
