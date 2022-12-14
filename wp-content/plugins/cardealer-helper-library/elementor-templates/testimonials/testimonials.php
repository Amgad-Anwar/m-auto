<?php
/**
 * Testimonials widget template
 *
 * @package car-dealer-helper
 */

$arrow                   = 'false';
$autoplay                = 'false';
$dots                    = 'false';
$data_loop               = 'false';
$lazyload                = cardealer_lazyload_enabled();
$style                   = isset( $settings['style'] ) ? $settings['style'] : 'style-1';
$no_of_testimonials      = isset( $settings['no_of_testimonials'] ) ? $settings['no_of_testimonials'] : '-1';
$data_space              = isset( $settings['data_space'] ) ? $settings['data_space'] : 20;
$testimonials_slider_opt = isset( $settings['testimonials_slider_opt'] ) ? $settings['testimonials_slider_opt'] : array();
$data_md_items           = isset( $settings['data_md_items'] ) ? $settings['data_md_items'] : '';
$data_sm_items           = isset( $settings['data_sm_items'] ) ? $settings['data_sm_items'] : '';
$data_xs_items           = isset( $settings['data_xs_items'] ) ? $settings['data_xs_items'] : '';
$data_xx_items           = isset( $settings['data_xx_items'] ) ? $settings['data_xx_items'] : '';

$args = array(
	'post_type'      => 'testimonials',
	'posts_per_page' => $no_of_testimonials,
);

$the_query = new WP_Query( $args );

if ( ! $the_query->have_posts() || 0 === (int) $no_of_testimonials ) {
	return;
}

$this->add_render_attribute( 'cdhl_testimonials', 'class', 'testimonial page' );
$this->add_render_attribute( 'cdhl_testimonials', 'id', 'cd_testimonials_' . $this->get_id() );

if ( 'style-1' === $style ) {
	$this->add_render_attribute( 'cdhl_testimonials', 'class', 'testimonial-1 white-bg' );
} elseif ( 'style-2' === $style ) {
	$this->add_render_attribute( 'cdhl_testimonials', 'class', 'testimonial-3 white-bg' );
} elseif ( 'style-3' === $style ) {
	$this->add_render_attribute( 'cdhl_testimonials', 'class', 'testimonial-2 bg-1 bg-overlay-black-70' );
} elseif ( 'style-4' === $style ) {
	$this->add_render_attribute( 'cdhl_testimonials', 'class', 'testimonial-4 white-bg' );
} if ( 'style-5' === $style ) {
	$this->add_render_attribute( 'cdhl_testimonials', 'class', 'testimonial-5 white-bg' );
}

if ( $no_of_testimonials > 1 ) {

	if ( $testimonials_slider_opt && is_array( $testimonials_slider_opt ) ) {
		foreach ( $testimonials_slider_opt as $option ) {
			if ( 'autoplay' === $option ) {
				$autoplay = 'true';
			} elseif ( 'loop' === $option ) {
				$data_loop = 'true';
			} elseif ( 'navigation-dots' === $option ) {
				$dots = 'true';
			} elseif ( 'navigation-arrow' === $option ) {
				$arrow = 'true';
			}
		}
	}

	$this->add_render_attribute(
		[
			'cdhl_testimonials_slider' => [
				'class'          => 'owl-carousel',
				'data-nav-arrow' => $arrow,
				'data-nav-dots'  => $dots,
				'data-autoplay'  => $autoplay,
				'data-lazyload'  => $lazyload,
				'data-space'     => $data_space,
				'data-loop'      => $data_loop,
				'data-items'     => $data_md_items,
				'data-md-items'  => $data_md_items,
				'data-sm-items'  => $data_sm_items,
				'data-xs-items'  => $data_xs_items,
				'data-xx-items'  => $data_xx_items,
			],
		]
	);

} else {
	$this->add_render_attribute( 'cdhl_testimonials_slider', 'class', 'carousel' );
}

$lazyload_class  = ( 'true' === $data_loop ) ? 'cardealer-lazy-load owl-lazy' : 'cardealer-lazy-load';
if ( $the_query->post_count < $data_md_items ) {
	$lazyload_class = 'cardealer-lazy-load';
}

$settings['lazyload_class'] = $lazyload_class;
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_testimonials' ); ?>>
		<?php
		if ( 'style-3' === $style ) {
			echo '<div class="testimonial-center">';
		}
		?>
		<div <?php $this->print_render_attribute_string( 'cdhl_testimonials_slider' ); ?>>
		<?php
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			global $post;

			if ( 'style-1' === $style || 'style-5' === $style ) {
				$this->get_templates( "{$this->widget_slug}/style/style-1-5", null, array( 'settings' => $settings ) );
			} else {
				$this->get_templates( "{$this->widget_slug}/style/" . $style, null, array( 'settings' => $settings ) );
			}
		}
		wp_reset_postdata();
		?>
		</div>
		<?php
		if ( 'style-3' === $style ) {
			echo '</div>';
		}
		?>
	</div>
</div>
