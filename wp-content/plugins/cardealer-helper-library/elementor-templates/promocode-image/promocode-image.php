<?php
/**
 * Promocode Image Elementor widget template
 *
 * @package car-dealer-helper
 */

$print_btn_title = isset( $settings['print_btn_title'] ) ? $settings['print_btn_title'] : '';

$promocode_image_title = esc_html__( 'Promocode Image', 'cardealer-helper' );
if ( isset( $settings['promocode_image'] ) && isset( $settings['promocode_image']['id'] ) && $settings['promocode_image']['id'] ) {
	$promocode_image_data = wp_get_attachment_image_src( $settings['promocode_image']['id'], 'full' );
	$promocode_image_arr  = ( function_exists( 'cardealer_get_attachment_detail' ) ) ? cardealer_get_attachment_detail( $settings['promocode_image']['id'] ) : '';

	if ( isset( $promocode_image_arr['alt'] ) && $promocode_image_arr['alt'] ) {
		$promocode_image_title = $promocode_image_arr['alt'];
	}
} else {
	return;
}

if ( isset( $promocode_image_data[0] ) && $promocode_image_data[0] ) {
	$image = $promocode_image_data[0];
} else {
	$image = '';
}

$this->add_render_attribute( 'cdhl_promocode_image', 'class', 'pgs_promocode_image' );
$this->add_render_attribute( 'cdhl_promocode_image', 'id', $this->get_id() );

$this->add_render_attribute( 'cdhl_promocode_image_container', 'class', 'promocode_img_container' );
$this->add_render_attribute( 'cdhl_promocode_image_container', 'id', 'promocode_img_' . $this->get_id() );

$this->add_render_attribute(
	[
		'cdhl_promocode_image_button' => [
			'class'         => [
				'button',
				'pgs_print_btn',
				'default',
				'large',
			],
			'href'          => [
				'javascript:void(0)',
			],
			'data-print_id' => [
				'promocode_img_' . $this->get_id(),
			],
		],
	]
);
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_promocode_image' ); ?>>
		<div <?php $this->print_render_attribute_string( 'cdhl_promocode_image_container' ); ?>>
			<?php
			if ( $image ) {
				if ( cardealer_lazyload_enabled() ) {
					?>
					<img class="img-responsive cardealer-lazy-load" src="<?php echo esc_url( LAZYLOAD_IMG ); ?>" data-src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $promocode_image_title ); ?>">
					<?php
				} else {
					?>
					<img class="img-responsive" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $promocode_image_title ); ?>">
					<?php
				}
			}
			?>
		</div>
		<a <?php $this->print_render_attribute_string( 'cdhl_promocode_image_button' ); ?>><?php echo esc_html( $print_btn_title ); ?></a>
	</div>
</div>
