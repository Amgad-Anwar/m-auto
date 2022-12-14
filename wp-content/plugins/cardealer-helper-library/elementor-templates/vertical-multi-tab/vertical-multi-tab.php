<?php
/**
 * Vehicle Search Elementor widget template
 *
 * @package car-dealer-helper
 */

$vehicle_category   = isset( $settings['vehicle_category'] ) ? $settings['vehicle_category'] : '';
$tab_type           = isset( $settings['tab_type'] ) ? $settings['tab_type'] : '';
$car_make_slugs     = isset( $settings['car_make_slugs'] ) ? $settings['car_make_slugs'] : '';
$number_of_item     = isset( $settings['number_of_item'] ) ? $settings['number_of_item'] : '';
$hide_sold_vehicles = isset( $settings['hide_sold_vehicles'] ) ? $settings['hide_sold_vehicles'] : '';
$advertise_img_id   = isset( $settings['advertise_img']['id'] ) ? $settings['advertise_img']['id'] : '';
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

$this->add_render_attribute( 'cdhl_vertical_multi_tab', 'class', 'tab-vertical tabs-left' );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_vertical_multi_tab' ); ?>>
		<div class="left-tabs-block">
			<ul class="nav nav-tabs vartical-tab-nav" id="vertical-tab">
				<?php
				$i = 1;
				foreach ( $car_make_slugs as $car_tab ) {
					$car_term     = get_term_by( 'slug', $car_tab, 'car_make' );
					$make_name    = ( ! is_wp_error( $car_term ) && $car_term ) ? $car_term->name : '';
					$make_term_id = ( ! is_wp_error( $car_term ) && $car_term ) ? $car_term->term_id : '';
					?>
					<li class="<?php echo ( 1 === (int) $i ) ? 'active' : ''; ?>">
						<a href="#<?php echo esc_attr( $make_term_id . '_' . $this->get_id() ); ?>" data-toggle="tab"><?php echo esc_html( $make_name ); ?></a>
					</li>
					<?php
					$i++;
				};
				?>
			</ul>
			<?php
			$img_url = '';
			if ( $advertise_img_id ) {
				$img_url = wp_get_attachment_url( $advertise_img_id, 'full' );
				$img_alt = get_post_meta( $advertise_img_id, '_wp_attachment_image_alt', true );
			}
			if ( $img_url ) {
				?>
				<div class="ads-img">
					<?php
					if ( cardealer_lazyload_enabled() ) {
						?>
						<img class="cardealer-lazy-load" data-src="<?php echo esc_url( $img_url ); ?>" src="<?php echo esc_url( LAZYLOAD_IMG ); ?>">
						<?php
					} else {
						?>
						<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>">
						<?php
					}
					?>
				</div>
				<?php
			}
			?>
		</div>
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
			$args['order']          = 'ASC';
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
			$args['order']          = 'ASC';
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
		?>
		<div class="tab-content">
			<?php
			$t = 1;
			foreach ( $car_make_slugs as $car_tab ) :
				$car_term     = get_term_by( 'slug', $car_tab, 'car_make' );
				$make_term_id = ( ! is_wp_error( $car_term ) && ! empty( $car_term ) ) ? $car_term->term_id : '';
				$get_id       = $make_term_id . '_' . $this->get_id();

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

				$loop = new WP_Query( $args );
				?>
				<div class="tab-pane <?php echo ( 1 === (int) $t ) ? 'active' : ''; ?>" id="<?php echo esc_attr( $get_id ); ?>">
					<?php
					if ( $loop->have_posts() ) {
						while ( $loop->have_posts() ) :
							$loop->the_post();

							$cars_cat_slug = '';
							$terms         = get_the_terms( get_the_ID(), 'car_make' );
							if ( ! $terms ) {
								echo '<div class="grid-item no-data ' . esc_attr( $get_id ) . '"><div class="no-data-found">' . esc_html__( 'No vehicle found.', 'cardealer-helper' ) . '</div></div>';
							} else {

								foreach ( $terms as $tm ) {
									$cars_cat_id   = $tm->term_id;
									$cars_cat_slug = $tm->slug . '_' . $this->get_id();
								}
								?>
								<div class="grid-item <?php echo esc_attr( $cars_cat_slug ); ?>">
									<div class="car-item text-center car-item-2 style-<?php echo esc_attr( $list_style ); ?>">
										<div class='car-image'>
											<?php
											$car_id           = get_the_ID();
											$is_hover_overlay = cardealer_is_hover_overlay();
											do_action( 'cardealer_car_loop_link_open', $car_id, $is_hover_overlay );
											/**
											 * Hook car_before_overlay_banner.
											 *
											 * @hooked cardealer_get_cars_condition - 10
											 * @hooked cardealer_get_cars_status - 20
											 */
											do_action( 'car_before_overlay_banner', $car_id, true );
											echo ( function_exists( 'cardealer_get_cars_image' ) ) ? cardealer_get_cars_image( $img_size ) : ''; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE
											if ( 'yes' === $is_hover_overlay ) {
												?>
												<div class='car-overlay-banner'>
													<ul>
														<?php
														if ( 'classic' === $list_style ) {
															/**
															 * Hook vehicle_classic_grid_overlay.
															 *
															 * @hooked cardealer_compare_cars_overlay_link - 10
															 * @hooked cardealer_images_cars_overlay_link - 10
															 */
															do_action( 'vehicle_classic_grid_overlay', $car_id );
														} else {
															/**
															 * Hook car_overlay_banner.
															 *
															 * @hooked cardealer_view_cars_overlay_link - 10
															 * @hooked cardealer_compare_cars_overlay_link - 20
															 * @hooked cardealer_images_cars_overlay_link - 30
															 */
															do_action( 'car_overlay_banner', $car_id );
														}
														?>
													</ul>
												</div>
												<?php
											}
											do_action( 'cardealer_car_loop_link_close', $car_id, $is_hover_overlay );
											?>
										</div>
										<?php
										if ( 'classic' === $list_style ) {
											?>
											<div class='car-content'>
												<?php
												/**
												 * Hook cardealer_list_car_title.
												 *
												 * @hooked cardealer_list_car_link_title - 10
												 */
												do_action( 'cardealer_classic_list_car_title' );
												cardealer_get_cars_list_attribute();
												cardealer_get_vehicle_review_stamps( $car_id );
												?>
												<ul class="car-bottom-actions classic-grid">
													<?php
													cardealer_classic_view_cars_overlay_link( $car_id );
													cardealer_classic_vehicle_video_link( $car_id );
													?>
												</ul>
												<?php
												cardealer_car_price_html();
												?>
											</div>
											<?php
										} else {
											cardealer_get_cars_list_attribute();
											?>
											<div class='car-content'>
												<?php
												/**
												 * Hook cardealer_list_car_title.
												 *
												 * @hooked cardealer_list_car_link_title - 5
												 * @hooked cardealer_list_car_title_separator - 10
												 */
												do_action( 'cardealer_list_car_title' );
												cardealer_get_vehicle_review_stamps( $car_id );
												cardealer_car_price_html();
												?>
											</div>
											<?php
										}
										?>
									</div>
								</div>
								<?php
							}
						endwhile;
						wp_reset_postdata();
						// End cars type tab.
					} else {
						echo '<div class="grid-item no-data ' . esc_attr( $get_id ) . '"><div class="no-data-found">' . esc_html__( 'No vehicle found.', 'cardealer-helper' ) . '</div></div>';
					}
					?>
				</div>
				<?php
				$t++;
			endforeach;
			?>
		</div>
	</div>
</div>
