<?php
/**
 * Icon Elementor widget template
 *
 * @package car-dealer-helper
 */

$icon = isset( $settings['icon'] ) ? $settings['icon'] : '';

$this->add_render_attribute( 'cdhl_icon', 'class', 'potenza-icon' );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_icon' ); ?> >
		<?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
	</div>
</div>
