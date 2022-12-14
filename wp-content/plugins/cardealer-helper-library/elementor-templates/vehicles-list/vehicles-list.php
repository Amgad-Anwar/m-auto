<?php
/**
 * Vehicles list Elementor widget template
 *
 * @package car-dealer-helper
 */

$img_size           = '';
$lazyload           = cardealer_lazyload_enabled();
$list_style         = cardealer_get_inv_list_style();
$style              = isset( $settings['style'] ) ? $settings['style'] : 'style-1';
$vehicle_category   = isset( $settings['vehicle_category'] ) ? $settings['vehicle_category'] : '';
$item_background    = isset( $settings['item_background'] ) ? $settings['item_background'] : 'white-bg';
$car_make           = isset( $settings['car_make'] ) ? $settings['car_make'] : array();
$hide_sold_vehicles = isset( $settings['hide_sold_vehicles'] ) ? $settings['hide_sold_vehicles'] : '';
$list_type          = isset( $settings['list_type'] ) ? $settings['list_type'] : 'with_slider';
$items_type         = isset( $settings['items_type'] ) ? $settings['items_type'] : 'pgs_new_arrivals';
$number_of_item     = isset( $settings['number_of_item'] ) ? $settings['number_of_item'] : 5;
$number_of_column   = isset( $settings['number_of_column'] ) ? $settings['number_of_column'] : 3;
$arrow              = isset( $settings['arrow'] ) && $settings['arrow'] ? $settings['arrow'] : 'false';
$dots               = isset( $settings['dots'] ) && $settings['dots'] ? $settings['dots'] : 'false';
$data_md_items      = isset( $settings['data_md_items'] ) ? $settings['data_md_items'] : 4;
$data_sm_items      = isset( $settings['data_sm_items'] ) ? $settings['data_sm_items'] : 2;
$data_xs_items      = isset( $settings['data_xs_items'] ) ? $settings['data_xs_items'] : 1;
$data_xx_items      = isset( $settings['data_xx_items'] ) ? $settings['data_xx_items'] : 1;
$data_space         = isset( $settings['data_space'] ) ? $settings['data_space'] : 20;
$autoplay           = isset( $settings['autoplay'] ) && $settings['autoplay'] ? $settings['autoplay'] : 'false';
$data_loop          = isset( $settings['data_loop'] ) && $settings['data_loop'] ? $settings['data_loop'] : 'false';
$image_size_text    = isset( $settings['image_size_text'] ) && $settings['image_size_text'] ? $settings['image_size_text'] : '';
$args = array(
	'post_type'      => 'cars',
	'posts_status'   => 'publish',
	'posts_per_page' => $number_of_item,
);

if ( is_array( $car_make ) && $car_make ) {
	// Make wise filter.
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'car_make',
			'field'    => 'slug',
			'terms'    => $car_make,
		),
	);
}

if ( $vehicle_category ) {

	$vehicle_cat_array = array(
		'taxonomy' => 'vehicle_cat',
		'field'    => 'slug',
		'terms'    => $vehicle_category,
	);

	if ( isset( $args['tax_query'] ) ) {
		$car_make_array    = $args['tax_query'];
		$args['tax_query'] = array(
			'relation' => 'AND',
			$vehicle_cat_array,
			$car_make_array,
		);
	} else {
		$args['tax_query'] = array(
			$vehicle_cat_array,
		);
	}
}

// Meta_query for sold/unsold vehicles.
$car_status_query = array();
if ( 'true' === $hide_sold_vehicles ) {
	$car_status_query = array(
		'key'     => 'car_status',
		'value'   => 'sold',
		'compare' => '!=',
	);
}

if ( 'pgs_featured' === $items_type ) {
	// Featured product.
	$args['meta_query'] = array(
		'relation' => 'AND',
		array(
			'key'     => 'featured',
			'value'   => '1',
			'compare' => '=',
		),
		$car_status_query,
	);
} elseif ( 'pgs_on_sale' === $items_type ) {
	// On Sale product.
	$args['meta_query'] = array(
		'relation' => 'AND',
		array(
			'key'     => 'sale_price',
			'value'   => '',
			'compare' => '!=',
		),
		$car_status_query,
	);
} elseif ( 'pgs_cheapest' === $items_type ) {
	// Cheapest Product.
	unset( $args['meta_query'] );
	if ( ! empty( $car_status_query ) ) {
		$args['meta_query'] = array(
			$car_status_query,
		);
	}
	$args['meta_key']       = 'regular_price';
	$args['meta_value_num'] = 'regular_price';
	$args['orderby']        = 'meta_value_num';
	$args['order']          = 'ASC';
} else {
	$args['meta_query'] = array(
		$car_status_query,
	);
}

$loop = new WP_Query( $args );

// Bail if no posts found.
if ( ! $loop->have_posts() ) {
	return;
}

// Compare Cars.
if ( isset( $_COOKIE['cars'] ) && ! empty( $_COOKIE['cars'] ) ) {
	$car_in_compare = json_decode( sanitize_text_field( wp_unslash( $_COOKIE['cars'] ) ) );
}

$this->add_render_attribute( 'cdhl_vehicles_list', 'class', 'pgs_cars_carousel-items' );
if ( 'with_slider' === $list_type ) {
	$this->add_render_attribute(
		[
			'cdhl_vehicles_list' => [
				'class'          => 'owl-carousel pgs-cars-carousel',
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
}

$this->add_render_attribute( 'widget_wrapper', 'class', 'pgs_cars_carousel-wrapper' );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_vehicles_list' ); ?>>
		<?php
		$img_size = 'car_tabs_image';
		if ( ! empty($image_size_text) && in_array( $image_size_text, get_intermediate_image_sizes() )) {
			$img_size = $image_size_text;
		}

		if ( 'with_slider' !== $list_type ) {
			?>
			<div class="row">
			<?php
		}

		$img_size = apply_filters( 'vehicle_carousel_image_size', $img_size );
		while ( $loop->have_posts() ) :
			$loop->the_post();

			$item_classes = array(
				'item',
			);

			$car_item_classes = array(
				'car-item',
				'text-center',
				$item_background,
			);

			if ( 'style-2' === $style ) {
				$car_item_classes[] = 'car-item-2';
			}

			if ( 'with_slider' !== $list_type ) {
				$item_classes[] = 'col-sm-' . 12 / $number_of_column;
			}

			$item_classes     = implode( ' ', array_filter( array_unique( $item_classes ) ) );
			$car_item_classes = implode( ' ', array_filter( array_unique( $car_item_classes ) ) );
			?>
			<div class="<?php echo esc_attr( $item_classes ); ?>">
				<div class="<?php echo esc_attr( $car_item_classes ); ?>">
					<div class="car-image">
						<?php
						$v_id             = get_the_ID();
						$is_hover_overlay = cardealer_is_hover_overlay();
						do_action( 'cardealer_car_loop_link_open', $v_id, $is_hover_overlay );
						/**
						 * Hook car_before_overlay_banner.
						 *
						 * @hooked cardealer_get_cars_condition - 10
						 * @hooked cardealer_get_cars_status - 20
						 */
						do_action( 'car_before_overlay_banner', $v_id, true );
						if ( 'with_slider' !== $list_type || ! $data_loop ) {
							echo ( function_exists( 'cardealer_get_cars_image' ) ) ? cardealer_get_cars_image( $img_size ) : ''; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE
						} else {
							echo ( function_exists( 'cardealer_get_cars_owl_image' ) ) ? cardealer_get_cars_owl_image( $img_size ) : ''; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE
						}

						if ( 'yes' === $is_hover_overlay ) {
							?>
							<div class="car-overlay-banner">
								<ul>
									<?php
									/**
									 * Hook car_overlay_banner.
									 *
									 * @hooked cardealer_view_cars_overlay_link - 10
									 * @hooked cardealer_compare_cars_overlay_link - 20
									 * @hooked cardealer_images_cars_overlay_link - 30
									 */
									do_action( 'car_overlay_banner', $v_id );
									?>
								</ul>
							</div>
							<?php
						}
						do_action( 'cardealer_car_loop_link_close', $v_id, $is_hover_overlay );
						if ( 'style-2' !== $style && 'classic' !== $list_style && function_exists( 'cardealer_get_cars_list_attribute' ) ) {
							cardealer_get_cars_list_attribute();
						}
						?>
					</div>
					<?php
					if ( 'style-2' === $style && function_exists( 'cardealer_get_cars_list_attribute' ) ) {
						cardealer_get_cars_list_attribute();
					}
					?>
					<div class="car-content">
						<?php
						/**
						 * Hook cardealer_list_car_title.
						 *
						 * @hooked cardealer_list_car_link_title - 5
						 * @hooked cardealer_list_car_title_separator - 10
						 */
						do_action( 'cardealer_list_car_title' );
						if ( function_exists( 'cardealer_car_price_html' ) ) {
							cardealer_car_price_html();
						}
						cardealer_get_vehicle_review_stamps( $v_id );
						if ( 'style-2' !== $style && 'classic' === $list_style && function_exists( 'cardealer_get_cars_list_attribute' ) ) {
							cardealer_get_cars_list_attribute();
						}
						?>
					</div>
				</div>
			</div>
			<?php
		endwhile;
		wp_reset_postdata();
		if ( 'with_slider' !== $list_type ) {
			?>
			</div>
			<?php
		}
		?>
	</div>
</div>
