<?php
/**
 * Clients Elementor widget template
 *
 * @package car-dealer-helper
 */

$clients_images   = isset( $settings['clients_images'] ) ? $settings['clients_images'] : '';
$list_style       = isset( $settings['list_style'] ) ? $settings['list_style'] : '';
$number_of_column = isset( $settings['number_of_column'] ) ? $settings['number_of_column'] : 2;
$arrow            = isset( $settings['arrow'] ) && $settings['arrow'] ? $settings['arrow'] : 'false';
$dots             = isset( $settings['dots'] ) && $settings['dots'] ? $settings['dots'] : 'false';
$data_md_items    = isset( $settings['data_md_items'] ) ? $settings['data_md_items'] : 3;
$data_sm_items    = isset( $settings['data_sm_items'] ) ? $settings['data_sm_items'] : 2;
$data_xs_items    = isset( $settings['data_xs_items'] ) ? $settings['data_xs_items'] : 1;
$data_xx_items    = isset( $settings['data_xx_items'] ) ? $settings['data_xx_items'] : 1;
$data_space       = isset( $settings['data_space'] ) ? $settings['data_space'] : 20;
$autoplay         = isset( $settings['autoplay'] ) && $settings['autoplay'] ? $settings['autoplay'] : 'false';
$data_loop        = isset( $settings['data_loop'] ) && $settings['data_loop'] ? $settings['data_loop'] : 'false';
$lazyload         = cardealer_lazyload_enabled();
$lazyload_class   = ( 'true' === $data_loop && 'with_slider' === $list_style ) ? 'cardealer-lazy-load owl-lazy' : 'cardealer-lazy-load';

if ( ! $clients_images ) {
	return;
}

$this->add_render_attribute( 'cdhl_clients', 'class', 'our-clients' );
$this->add_render_attribute( 'cdhl_clients_grid_class', 'class', 'col-lg-12 col-md-12' );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_clients' ); ?> >
		<div <?php $this->print_render_attribute_string( 'cdhl_clients_grid_class' ); ?> >
			<?php
			if ( 'with_slider' === $list_style ) {
				$this->add_render_attribute(
					[
						'cdhl_clients_slider' => [
							'class'          => 'owl-carousel',
							'data-nav-arrow' => $arrow,
							'data-nav-dots'  => $dots,
							'data-autoplay'  => $autoplay,
							'data-space'     => $data_space,
							'data-loop'      => $data_loop,
							'data-lazyLoad'  => $lazyload,
							'data-items'     => $data_md_items,
							'data-md-items'  => $data_md_items,
							'data-sm-items'  => $data_sm_items,
							'data-xs-items'  => $data_xs_items,
							'data-xx-items'  => $data_xx_items,
						],
					]
				);
				?>
				<div <?php $this->print_render_attribute_string( 'cdhl_clients_slider' ); ?> >
				<?php
			}
			$k = 0;
			foreach ( $clients_images as $clients_image ) {
				$img_url = wp_get_attachment_url( $clients_image['id'], 'full' );
				$img_alt = get_post_meta( $clients_image['id'], '_wp_attachment_image_alt', true );

				if ( 'with_slider' === $list_style ) {
					?>
					<div class="item">
						<?php
						if ( $lazyload ) {
							?>
							<img class="center-block <?php echo esc_attr( $lazyload_class ); ?>" data-src="<?php echo esc_html( $img_url ); ?>" src="<?php echo esc_url( LAZYLOAD_IMG ); ?>" alt="<?php echo esc_html( $img_alt ); ?>">
							<?php
						} else {
							?>
							<img class="center-block" src="<?php echo esc_html( $img_url ); ?>" alt="<?php echo esc_html( $img_alt ); ?>">
							<?php
						}
						?>
					</div>
					<?php
				} else {
					$i = (int) ( 12 / $number_of_column );
					if ( 0 === (int) $k % $number_of_column ) {
						?>
						<div class="row">
						<?php
					}
					?>
					<div class="col-sm-<?php echo esc_attr( $i ); ?>">
						<div class="item">
							<?php
							if ( $lazyload ) {
								?>
								<img class="center-block <?php echo esc_attr( $lazyload_class ); ?>" data-src="<?php echo esc_html( $img_url ); ?>" src="<?php echo esc_url( LAZYLOAD_IMG ); ?>" alt="<?php echo esc_html( $img_alt ); ?>">
								<?php
							} else {
								?>
								<img class="center-block" src="<?php echo esc_html( $img_url ); ?>" alt="<?php echo esc_html( $img_alt ); ?>">
								<?php
							}
							?>
						</div>
					</div>
					<?php
					$k++;
					if ( ( 0 === (int) $k % $number_of_column ) || ( count( $clients_images ) === $k ) ) {
						?>
						</div>
						<?php
					}
				}
			}
			if ( 'with_slider' === $list_style ) {
				?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
