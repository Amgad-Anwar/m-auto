<?php
/**
 * Image slider widget template
 *
 * @package car-dealer-helper
 */

$lazyload      = cardealer_lazyload_enabled();
$slider_images = isset( $settings['slider_images'] ) ? $settings['slider_images'] : '';
$arrow         = isset( $settings['arrow'] ) && $settings['arrow'] ? $settings['arrow'] : 'false';
$dots          = isset( $settings['dots'] ) && $settings['dots'] ? $settings['dots'] : 'false';
$autoplay      = isset( $settings['autoplay'] ) && $settings['autoplay'] ? $settings['autoplay'] : 'false';
$data_loop     = isset( $settings['data_loop'] ) && $settings['data_loop'] ? $settings['data_loop'] : 'false';

if ( ! $slider_images ) {
	return;
}

$this->add_render_attribute(
	[
		'cdhl_image_slider' => [
			'class'          => 'owl-carousel',
			'data-nav-arrow' => $arrow,
			'data-nav-dots'  => $dots,
			'data-autoplay'  => $autoplay,
			'data-lazyload'  => $lazyload,
			'data-loop'      => $data_loop,
			'data-items'     => 1,
			'data-md-items'  => 1,
			'data-sm-items'  => 1,
			'data-xs-items'  => 1,
			'data-md-items'  => 1,
		],
	]
);
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_image_slider' ); ?> >
		<?php
		foreach ( $slider_images as $slider_image ) {
			$img_url = wp_get_attachment_url( $slider_image['id'], 'full' );
			$img_alt = get_post_meta( $slider_image['id'], '_wp_attachment_image_alt', true );
			?>
			<div class="item">
				<?php
				if ( $lazyload ) {
					$lazyload_class = ( 'true' === $data_loop ) ? 'cardealer-lazy-load owl-lazy' : 'cardealer-lazy-load';
					?>
					<img class="center-block <?php echo esc_attr( $lazyload_class ); ?>" src="<?php echo esc_url( LAZYLOAD_IMG ); ?>" data-src="<?php echo esc_html( $img_url ); ?>" alt="<?php echo esc_html( $img_alt ); ?>">
					<?php
				} else {
					?>
					<img class="center-block" src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>">
					<?php
				}
				?>
			</div>
			<?php
		}
		?>
	</div>
</div>
