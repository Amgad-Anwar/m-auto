<?php
/**
 * Multi Tab Elementor widget template
 *
 * @package car-dealer-helper
 */

$style              = isset( $settings['style'] ) ? $settings['style'] : '';
$vehicle_category   = isset( $settings['vehicle_category'] ) ? $settings['vehicle_category'] : '';
$tab_type           = isset( $settings['tab_type'] ) ? $settings['tab_type'] : '';
$car_make_slugs     = isset( $settings['car_make_slugs'] ) ? $settings['car_make_slugs'] : '';
$number_of_item     = isset( $settings['number_of_item'] ) ? $settings['number_of_item'] : '';
$number_of_column   = isset( $settings['number_of_column'] ) ? $settings['number_of_column'] : '';
$hide_sold_vehicles = isset( $settings['hide_sold_vehicles'] ) ? $settings['hide_sold_vehicles'] : '';
$image_size_text    = isset( $settings['image_size_text'] ) && $settings['image_size_text'] ? $settings['image_size_text'] : '';

if ( ! $car_make_slugs ) {
	return;
}

$img_size = 'car_tabs_image';
if ( ! empty($image_size_text) && in_array( $image_size_text, get_intermediate_image_sizes() )) {
	$img_size = $image_size_text;
}

$list_style = cardealer_get_inv_list_style();

// car compare code.
if ( isset( $_COOKIE['cars'] ) && ! empty( $_COOKIE['cars'] ) ) {
	$car_in_compare = json_decode( sanitize_text_field( wp_unslash( $_COOKIE['cars'] ) ) );
}

$car_term            = get_term_by( 'slug', $car_make_slugs[0], 'car_make' );
$make_active_term_id = ( ! is_wp_error( $car_term ) && $car_term ) ? $car_term->term_id : '';
$unique_number       = wp_rand( 0, 9999 ) . time();

$this->add_render_attribute(
	[
		'cdhl_multi_tab' => [
			'class'             => [
				'isotope-wrapper',
			],
			'data-layout'       => [
				'grid',
			],
			'data-unique_class' => [
				$this->get_id(),
			],
		],
	]
);

$this->add_render_attribute( 'cdhl_multi_tab_inner', 'class', 'isotope-filters multi-tab multi-tab-isotope-filter  multi-tab-isotope-filter-' . $this->get_id() );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_multi_tab' ); ?>>
		<div <?php $this->print_render_attribute_string( 'cdhl_multi_tab_inner' ); ?>>
			<div class="isotope-filters">
			<?php
			foreach ( $car_make_slugs as $car_tab ) {
				$class        = '';
				$car_term     = get_term_by( 'slug', $car_tab, 'car_make' );
				$make_name    = ( ! is_wp_error( $car_term ) && $car_term ) ? $car_term->name : '';
				$make_term_id = ( ! is_wp_error( $car_term ) && $car_term ) ? $car_term->term_id : '';
				$d_filter     = $make_term_id . $unique_number;

				if ( isset( $car_term->count ) && 0 === (int) $car_term->count ) {
					$d_filter = $unique_number;
				}

				if ( $make_active_term_id === $make_term_id ) {
					$class = 'active';
				}
				?>
				<button class="<?php echo esc_attr( $class ); ?>" data-filter="<?php echo esc_attr( $d_filter ); ?>"><?php echo esc_html( $make_name ); ?></button>
				<?php
			}
			?>
			</div>
		</div>
		<div class="<?php echo esc_attr( $this->get_id() ); ?>">
			<div class="horizontal-tabs isotope cd-multi-tab-isotope-<?php echo esc_attr( $this->get_id() ); ?> column-<?php echo esc_attr( $number_of_column ); ?> filter-container">
				<?php
				$args = array(
					'post_type'      => 'cars',
					'posts_status'   => 'publish',
					'posts_per_page' => $number_of_item,
				);

				// meta_query for sold/unsold vehicles.
				$car_status_query = array();
				if ( 'true' === $hide_sold_vehicles ) {
					$car_status_query = array(
						'key'     => 'car_status',
						'value'   => 'sold',
						'compare' => '!=',
					);
				}

				if ( 'pgs_featured' === $tab_type ) {
					/* Featured cars */
					$args['meta_query'] = array(
						'relation' => 'AND',
						array(
							'key'     => 'featured',
							'value'   => '1',
							'compare' => '=',
						),
						$car_status_query,
					);
				} elseif ( 'pgs_on_sale' === $tab_type ) {
					/* On Sale cars */
					$args['meta_query']     = array(
						'relation' => 'AND',
						array(
							'key'     => 'sale_price',
							'value'   => '',
							'compare' => '!=',
							'type'    => 'NUMERIC',
						),
						array(
							'key'     => 'regular_price',
							'value'   => '',
							'compare' => '!=',
							'type'    => 'NUMERIC',
						),
						$car_status_query,
					);
					$args['meta_value_num'] = 'sale_price';
					$args['orderby']        = 'meta_value_num';
					$args['order']          = 'asc';
				} elseif ( 'pgs_cheapest' === $tab_type ) {
					/* Cheapest Product */
					unset( $args['meta_query'] );
					$args['meta_query']     = array(
						'relation' => 'AND',
						array(
							'key'     => 'final_price',
							'value'   => '',
							'compare' => '!=',
							'type'    => 'NUMERIC',
						),
						$car_status_query,
					);
					$args['meta_value_num'] = 'final_price';
					$args['orderby']        = 'meta_value_num';
					$args['order']          = 'asc';
				} else {
					$args['meta_query'] = array(
						$car_status_query,
					);
				}

				$vehicle_category = trim( $vehicle_category );
				if ( $vehicle_category ) {
					$vehicle_cat_array = array(
						'taxonomy' => 'vehicle_cat',
						'field'    => 'slug',
						'terms'    => $vehicle_category,
					);
				}

				foreach ( $car_make_slugs as $car_tab ) :

					$car_make_array = array(
						'taxonomy' => 'car_make',
						'field'    => 'slug',
						'terms'    => $car_tab,
					);

					if ( $vehicle_category ) {
						$args['tax_query'] = array(
							'relation' => 'AND',
							$vehicle_cat_array,
							$car_make_array,
						);
					} else {
						$args['tax_query'] = array(
							$car_make_array,
						);
					}

					$get_term         = get_term_by( 'slug', $car_tab, 'car_make' );
					$make_term_id     = ( ! is_wp_error( $get_term ) && $car_term ) ? $get_term->term_id : '';
					$is_hover_overlay = cardealer_is_hover_overlay();
					$loop             = new WP_Query( $args );

					if ( $loop->have_posts() ) {
						while ( $loop->have_posts() ) :
							$loop->the_post();

							$cars_cat_slug = '';
							$terms         = get_the_terms( get_the_ID(), 'car_make' );

							if ( ! $terms ) {
								echo '<div class="grid-item no-data ' . esc_attr( $make_term_id . $unique_number ) . '" data-groups="[' . esc_attr( $make_term_id . $unique_number ) . ']"><div class="no-data-found">' . esc_html__( 'No vehicle found', 'cardealer-helper' ) . '.</div></div>';
							} else {
								foreach ( $terms  as $car_term ) {
									$cars_cat_id    = $car_term->term_id;
									$cars_cat_slug .= $make_term_id . $unique_number;
									$carscatslug[]  = $car_term->slug;
								}
								?>
								<div class="grid-item <?php echo esc_attr( $cars_cat_slug ); ?> grid-item-<?php echo esc_attr( $this->get_id() ); ?>" data-groups="[<?php echo esc_attr( $cars_cat_slug ); ?>]">
									<?php
									$cur_id = get_the_ID();
									if ( 'style-2' === $style ) {
										?>
										<div class='car-item text-center style-<?php echo esc_attr( $list_style ); ?>'>
										<?php
										if ( 'classic' === $list_style ) {
											?>
											<div class="car-image">
												<?php
												do_action( 'cardealer_car_loop_link_open', $cur_id, $is_hover_overlay );
												/**
												 * Hook car_before_overlay_banner.
												 *
												 * @hooked cardealer_get_cars_condition - 10
												 * @hooked cardealer_get_cars_status - 20
												 */
												do_action( 'car_before_overlay_banner', $cur_id, true );
												echo ( function_exists( 'cardealer_get_cars_image' ) ) ? cardealer_get_cars_image( $img_size ) : ''; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE
												if ( 'yes' === $is_hover_overlay ) {
													?>
													<div class='car-overlay-banner'>
														<ul>
															<?php
															/**
															 * Hook vehicle_classic_grid_overlay.
															 *
															 * @hooked cardealer_compare_cars_overlay_link - 10
															 * @hooked cardealer_images_cars_overlay_link - 10
															 */
															do_action( 'vehicle_classic_grid_overlay', $cur_id );
															?>

														</ul>
													</div>
													<?php
												}
												do_action( 'cardealer_car_loop_link_close', $cur_id, $is_hover_overlay );
												?>
											</div>
											<div class='car-content'>
												<?php
												/**
												 * Hook cardealer_classic_list_car_title.
												 *
												 * @hooked cardealer_list_car_link_title - 10
												 */

												do_action( 'cardealer_classic_list_car_title' );
												cardealer_car_price_html();
												cardealer_get_cars_list_attribute( $cur_id );
												cardealer_get_vehicle_review_stamps( $cur_id );
												?>
												<ul class="car-bottom-actions classic-grid">
													<?php
													cardealer_classic_view_cars_overlay_link( $cur_id );
													cardealer_classic_vehicle_video_link( $cur_id );
													?>
												</ul>
											</div>
											<?php
										} else {
											?>
											<div class='car-image'>
												<?php
												do_action( 'cardealer_car_loop_link_open', $cur_id, $is_hover_overlay );
												/**
												 * Hook car_before_overlay_banner.
												 *
												 * @hooked cardealer_get_cars_condition - 10
												 * @hooked cardealer_get_cars_status - 20
												 */
												do_action( 'car_before_overlay_banner', $cur_id, true );
												echo ( function_exists( 'cardealer_get_cars_image' ) ) ? cardealer_get_cars_image( $img_size ) : ''; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE
												if ( 'yes' === $is_hover_overlay ) {
													?>
													<div class='car-overlay-banner'>
														<ul>
															<?php
															/**
															 * Hook car_overlay_banner.
															 *
															 * @hooked cardealer_view_cars_overlay_link - 10
															 * @hooked cardealer_compare_cars_overlay_link - 20
															 * @hooked cardealer_images_cars_overlay_link - 30
															 */
															do_action( 'car_overlay_banner', $cur_id );
															?>
														</ul>
													</div>
													<?php
												}
												do_action( 'cardealer_car_loop_link_close', $cur_id, $is_hover_overlay );
												if ( function_exists( 'cardealer_get_cars_list_attribute' ) ) {
													cardealer_get_cars_list_attribute( $cur_id );}
												?>
											</div>
											<div class='car-content'>
												<?php
												/**
												 * Hook cardealer_list_car_title.
												 *
												 * @hooked cardealer_list_car_link_title - 5
												 * @hooked cardealer_list_car_title_separator - 10
												 */
												do_action( 'cardealer_list_car_title' );
												cardealer_car_price_html();
												cardealer_get_vehicle_review_stamps( $cur_id );
												?>
											</div>
											<?php
										}
										?>
										</div>
										<?php
									} else {
										?>
										<div class="car-item-3">
											<?php echo cardealer_get_cars_image( $img_size ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE ?>
											<div class="car-popup">
												<a class="popup-img" href="<?php echo esc_url( get_the_permalink() ); ?>"><i class="fas fa-plus"></i></a>
											</div>
											<div class="car-overlay text-center">
												<a class="link" href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
											</div>
										</div>
										<?php
									}
									?>
								</div>
								<?php
							}
						endwhile;
						wp_reset_postdata();
					} else {
						echo '<div class="grid-item no-data ' . $make_term_id . '_' . $this->get_id() . '" data-groups="[' . esc_attr( $make_term_id . $unique_number ) . ']"><div class="no-data-found">' . esc_html__( 'No vehicle found', 'cardealer-helper' ) . '.</div></div>'; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE
					}
				endforeach;
				/*End cars type tab */
				?>
			</div>
		</div>
	</div>
</div>
