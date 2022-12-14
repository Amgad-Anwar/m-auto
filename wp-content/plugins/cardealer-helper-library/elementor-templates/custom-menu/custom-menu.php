<?php
/**
 * Custom Menu Elementor widget template
 *
 * @package car-dealer-helper
 */

global $wp_widget_factory;

$atts              = array();
$nav_menu          = isset( $settings['nav_menu'] ) ? $settings['nav_menu'] : '';
$extra_classes     = isset( $settings['extra_classes'] ) ? $settings['extra_classes'] : '';
$custom_menu_style = isset( $settings['custom_menu_style'] ) ? $settings['custom_menu_style'] : '';

if ( ! $nav_menu ) {
	return;
}

$menu_obj = get_term_by( 'slug', $nav_menu, 'nav_menu' );
if ( ! $menu_obj ) {
	return;
} else {
	$atts['nav_menu'] = $menu_obj->term_id;
}

$this->add_render_attribute(
	[
		'cdhl_custom_menu' => [
			'class' => [
				'cd_custommenu',
				'potenza-custom-menu',
				$extra_classes,
				$custom_menu_style,
			],
			'id'    => [
				'cd_custom_menu_' . $this->get_id(),
			],
		],
	]
);
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_custom_menu' ); ?> >
		<?php
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets['WP_Nav_Menu_Widget'] ) ) {
			the_widget( 'WP_Nav_Menu_Widget', $atts, array() );
		} else {
			esc_html_e( 'Widget WP_Nav_Menu_Widget Not found in custommenu', 'cardealer-helper' );
		}
		?>
	</div>
</div>
