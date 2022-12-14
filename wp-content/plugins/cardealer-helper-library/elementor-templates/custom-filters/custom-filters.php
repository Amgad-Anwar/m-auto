<?php
/**
 * Custom filters Elementor widget template
 *
 * @package car-dealer-helper
 */
$style             = isset( $settings['custom_filters_style'] ) ? $settings['custom_filters_style'] : 'style-1';
$filter_style      = isset( $settings['filter_style'] ) ? $settings['filter_style'] : '';
$filter_background = isset( $settings['filter_background'] ) ? $settings['filter_background'] : '';

$this->add_render_attribute(
	[
		'cdhl_custom_filters' => [
			'class'          => [
				'search-block',
				'clearfix',
				$filter_style,
				$filter_background,
			],
			'data-empty-lbl' => [
				esc_html__( '--Select--', 'cardealer-helper' ),
			],
		],
	]
);
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_custom_filters' ); ?> >
		<?php $this->get_templates( "{$this->widget_slug}/styles/" . $style, null, array( 'settings' => $settings ) ); ?>
		<div class="clearfix"></div>
		<div class="filter-loader"></div>
	</div>
</div>
