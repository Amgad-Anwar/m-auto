<?php
/**
 * Vehicles conditions tabs Elementor widget template
 *
 * @package car-dealer-helper
 */

$arrow              = isset( $settings['arrow'] ) && $settings['arrow'] ? $settings['arrow'] : 'false';
$dots               = isset( $settings['dots'] ) && $settings['dots'] ? $settings['dots'] : 'false';
$autoplay           = isset( $settings['autoplay'] ) && $settings['autoplay'] ? $settings['autoplay'] : 'false';
$data_loop          = isset( $settings['data_loop'] ) && $settings['data_loop'] ? $settings['data_loop'] : 'false';
$list_style         = isset( $settings['list_style'] ) ? $settings['list_style'] : '';
$item_background    = isset( $settings['item_background'] ) ? $settings['item_background'] : '';
$condition_tabs     = isset( $settings['condition_tabs'] ) ? $settings['condition_tabs'] : '';
$makes              = isset( $settings['makes'] ) && is_array( $settings['makes'] ) ? implode( ',', $settings['makes'] ) : '';
$vehicle_category   = isset( $settings['vehicle_category'] ) && is_array( $settings['vehicle_category'] ) ? implode( ',', $settings['vehicle_category'] ) : '';
$number_of_column   = isset( $settings['number_of_column'] ) ? $settings['number_of_column'] : '3';
$hide_sold_vehicles = isset( $settings['hide_sold_vehicles'] ) ? $settings['hide_sold_vehicles'] : '';
$number_of_item     = isset( $settings['number_of_item'] ) ? $settings['number_of_item'] : '';
$section_label      = isset( $settings['section_label'] ) ? $settings['section_label'] : '';
$data_md_items      = isset( $settings['data_md_items'] ) ? $settings['data_md_items'] : '3';
$data_sm_items      = isset( $settings['data_sm_items'] ) ? $settings['data_sm_items'] : '3';
$data_xs_items      = isset( $settings['data_xs_items'] ) ? $settings['data_xs_items'] : '2';
$data_xx_items      = isset( $settings['data_xx_items'] ) ? $settings['data_xx_items'] : '2';
$data_space         = isset( $settings['data_space'] ) ? $settings['data_space'] : 20;
$lazyload           = cardealer_lazyload_enabled();
$image_size_text    = isset( $settings['image_size_text'] ) && $settings['image_size_text'] ? $settings['image_size_text'] : '';

if ( ! $condition_tabs ) {
	return;
}

$car_list_style = cardealer_get_inv_list_style();

// Compare Cars.
if ( isset( $_COOKIE['cars'] ) && ! empty( $_COOKIE['cars'] ) ) {
	$car_in_compare = json_decode( sanitize_text_field( wp_unslash( $_COOKIE['cars'] ) ) );
}

$item_wrapper_classes = array(
	'cars_condition_carousel-items',
);

$item_wrapper_attr = '';
if ( 'slider' === $list_style ) {
	$item_wrapper_classes[] = 'owl-carousel';
	$item_wrapper_classes[] = 'pgs-cars-carousel';

	$item_wrapper_attrs = array(
		'data-nav-arrow' => 'data-nav-arrow="' . esc_attr( $arrow ) . '"',
		'data-nav-dots'  => 'data-nav-dots="' . esc_attr( $dots ) . '"',
		'data-items'     => 'data-items="' . esc_attr( $data_md_items ) . '"',
		'data-md-items'  => 'data-md-items="' . esc_attr( $data_md_items ) . '"',
		'data-sm-items'  => 'data-sm-items="' . esc_attr( $data_sm_items ) . '"',
		'data-xs-items'  => 'data-xs-items="' . esc_attr( $data_xs_items ) . '"',
		'data-xx-items'  => 'data-xx-items="' . esc_attr( $data_xx_items ) . '"',
		'data-space'     => 'data-space="' . esc_attr( $data_space ) . '"',
		'data-lazyload'  => 'data-lazyload="' . esc_attr( $lazyload ) . '"',
		'data-autoplay'  => 'data-autoplay="' . esc_attr( $autoplay ) . '"',
		'data-loop'      => 'data-loop="' . esc_attr( $data_loop ) . '"',
	);
	$item_wrapper_attr  = implode( ' ', $item_wrapper_attrs );
}

$item_wrapper_classes = implode( ' ', $item_wrapper_classes );
$empty_msg            = apply_filters( 'vehicle_conditions_tabs_empty_msg', esc_html__( 'No Vehicles found!', 'cardealer-helper' ) );

$this->add_render_attribute( 'cdhl_vehicles_conditions_tabs', 'class', 'cars_condition_carousel-wrapper' );
$this->add_render_attribute( 'cdhl_vehicles_conditions_tabs_container', 'class', 'cardealer-tabs clearfix' );
$this->add_render_attribute( 'cdhl_vehicles_conditions_tabs_container', 'id', 'tabs-' . $this->get_id() );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_vehicles_conditions_tabs' ); ?>>
		<div <?php $this->print_render_attribute_string( 'cdhl_vehicles_conditions_tabs_container' ); ?>>
			<h6><?php echo esc_html( $section_label ); ?></h6>
			<ul class="tabs pull-right">
				<?php
				foreach ( $condition_tabs as $key => $vehicle_condition ) {

					$active_class = ( 0 === (int) $key ) ? 'active' : '';
					$vehicle_cond = get_term_by( 'slug', $vehicle_condition, 'car_condition' );
					$conditions   = ( ! empty( $vehicle_cond ) && isset( $vehicle_cond->name ) ) ? $vehicle_cond->name : '';
					$vehicles     = cdhl_get_condition_tab_vehicles( $vehicle_condition, $makes, $number_of_item, $vehicle_category, $hide_sold_vehicles );

					if ( is_wp_error( $vehicles ) || ! $vehicles ) {
						continue;
					}
					if ( $conditions && ( ! is_wp_error( $vehicles ) && $vehicles ) ) {
						?>
						<li data-tabs="tab-<?php echo esc_attr( $key ); ?>-<?php echo esc_attr( $this->get_id() ); ?>" class="<?php echo esc_attr( $active_class ); ?>">
							<?php echo esc_html( $conditions ); ?>
						</li>
						<?php
					}
				}
				?>
			</ul>
			<?php
			foreach ( $condition_tabs as $key => $vehicle_condition ) {
				// get vehicles.
				$vehicles = cdhl_get_condition_tab_vehicles( $vehicle_condition, $makes, $number_of_item, $vehicle_category, $hide_sold_vehicles );
				if ( is_wp_error( $vehicles ) || ! $vehicles ) {
					continue;
				}

				$carousel_attrs = empty( $vehicles ) ? '' : $item_wrapper_attr;
				$cnt            = $vehicles->post_count;
				$carousel_attrs = explode( ' ', $carousel_attrs );

				if ( $cnt < $data_md_items ) {
					$carousel_attrs[0] = "data-nav-arrow='false'";
					$carousel_attrs[1] = "data-nav-dots='false'";
				}
				$carousel_attrs = implode( ' ', $carousel_attrs );

				$img_size = 'car_tabs_image';
				if ( ! empty($image_size_text) && in_array( $image_size_text, get_intermediate_image_sizes() )) {
					$img_size = $image_size_text;
				}
				?>
				<div id="tab-<?php echo esc_attr( $key ); ?>-<?php echo esc_attr( $this->get_id() ); ?>" class="<?php echo esc_attr( $item_wrapper_classes ); ?> cardealer-tabcontent" <?php echo $carousel_attrs; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE ?>>
					<?php
					if ( 'slider' !== $list_style ) {
						?>
						<div class="row">
						<?php
					}

					if ( ! empty( $vehicles ) ) {
						while ( $vehicles->have_posts() ) {
							$vehicles->the_post();

							$item_classes = array(
								'item',
							);

							$car_item_classes = array(
								'car-item',
								'text-center',
								'style-' . $car_list_style,
							);

							if ( 'slider' !== $list_style ) {
								$item_classes[] = 'col-sm-' . 12 / (int) $number_of_column;
							}

							$item_classes     = implode( ' ', array_filter( array_unique( $item_classes ) ) );
							$car_item_classes = implode( ' ', array_filter( array_unique( $car_item_classes ) ) );
							?>
							<div class="<?php echo esc_attr( $item_classes ); ?>">
								<div class="<?php echo esc_attr( $car_item_classes ); ?> <?php echo esc_attr( $item_background ); ?>">
								<?php
								$v_id             = get_the_ID();
								$is_hover_overlay = cardealer_is_hover_overlay();
								if ( 'classic' === $car_list_style ) {
									?>
									<div class="car-image">
										<?php
										/**
										 * Action called when anchor tag for vehicle link opens.
										 *
										 * @since 1.0.0
										 * @param int       $v_id Vehicle ID.
										 * @param string    $is_hover_overlay Enable/Disable vehicle hover effect.
										 * @visible         true
										 */

										do_action( 'cardealer_car_loop_link_open', $v_id, $is_hover_overlay );

										/**
										* Action called before vehicle overlay contents.
										*
										* @since 1.0.0
										*
										* @param int       $v_id             Vehicle ID
										* @param boolean   $output_type    Weather to return Or echo the response
										* @hooked cardealer_get_cars_condition - 10
										* @hooked cardealer_get_cars_status - 20
										* @visible true
										*/
										do_action( 'car_before_overlay_banner', $v_id, true );
										if ( ( 'slider' !== $list_style ) || ( $cnt < $data_md_items ) ) {
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
													 * Action called when vehicle overlay is displayed for classic layout with grid style.
													 *
													 * @since 1.0.0
													 * @param int       $v_id Vehicle ID
													 * @visible         true
													 *
													 * @hooked cardealer_compare_cars_overlay_link - 10
													 * @hooked cardealer_images_cars_overlay_link - 20 30
													 */
													do_action( 'vehicle_classic_grid_overlay', $v_id );
													?>
												</ul>
											</div>
											<?php
										}
										/**
										 * Action called when vehicle anchor tag in list closed.
										 *
										 * @since 1.0.0
										 *
										 * @param int       $v_id Vehicle ID
										 * @param string    $is_hover_overlay True/False for show/hide vehicle overlay effect.
										 * @visible true
										 */
										do_action( 'cardealer_car_loop_link_close', $v_id, $is_hover_overlay );
										?>
									</div>
									<div class="car-content">
										<?php
										/**
										 * Action called when vehicle title is displayed for classic layout style.
										 *
										 * @since 1.0.0
										 *
										 * @hooked cardealer_list_car_link_title - 10
										 * @visible true
										 */
										do_action( 'cardealer_classic_list_car_title' );
										cardealer_car_price_html();
										cardealer_get_cars_list_attribute();
										cardealer_get_vehicle_review_stamps( $v_id );
										?>
										<ul class="car-bottom-actions classic-grid">
											<?php
											cardealer_classic_view_cars_overlay_link( $v_id );
											cardealer_classic_vehicle_video_link( $v_id );
											?>
										</ul>
									</div>
									<?php
								} else {
									?>
									<div class="car-image">
									<?php
									/**
									 * Action called when anchor tab for vehicle details is opened.

									 * @since 1.0.0

									 * @param int       $v_id Vehicle ID.
									 * @param string    $is_hover_overlay Enable/Disable vehicle hover effect.
									 * @visible         true
									 */
									do_action( 'cardealer_car_loop_link_open', $v_id, $is_hover_overlay );

									/**
									 * Action called before vehicle overlay contents.
									 *
									 * @since 1.0.0
									 *
									 * @param int       $v_id             Vehicle ID
									 * @param boolean   $output_type    Weather to return Or echo the response
									 * @hooked cardealer_get_cars_condition - 10
									 * @hooked cardealer_get_cars_status - 20
									 * @visible true
									 */
									do_action( 'car_before_overlay_banner', $v_id, true );

									if ( ( 'slider' !== $list_style ) || ( 'true' !== $data_loop ) ) {
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
												 * Action called when vehicle overlay contents are displayed.
												 *
												 * @since 1.0.0
												 *
												 * @param int $v_id Vehicle ID
												 * @hooked cardealer_view_cars_overlay_link - 10
												 * @hooked cardealer_compare_cars_overlay_link - 20
												 * @hooked cardealer_images_cars_overlay_link - 30
												 * @visible true
												 */
												do_action( 'car_overlay_banner', $v_id );
												?>
											</ul>
										</div>
										<?php
									}

									/**
									 * Action called when vehicle anchor tag in list closed.
									 *
									 * @since 1.0.0
									 *
									 * @param int       $v_id Vehicle ID
									 * @param string    $is_hover_overlay True/False for show/hide vehicle overlay effect.
									 * @visible true
									 */
									do_action( 'cardealer_car_loop_link_close', $v_id, $is_hover_overlay );
									cardealer_get_cars_list_attribute();
									?>
									</div>
									<div class="car-content">
									<?php
									/**
									 * Action called when vehicle title is shown in default view layout.
									 *
									 * @since 1.0.0
									 *
									 * @hooked cardealer_list_car_link_title - 5
									 * @hooked cardealer_list_car_title_separator - 10
									 * @visible true
									 */
									do_action( 'cardealer_list_car_title' );
									cardealer_car_price_html();
									cardealer_get_vehicle_review_stamps( $v_id );
									?>
									</div>
									<?php
								}
								?>
								</div>
							</div>
							<?php
						}
						wp_reset_postdata();
					} else {
						?>
						<p><?php echo esc_html( $empty_msg ); ?></p>
						<?php
					}
					if ( 'slider' !== $list_style ) {
						?>
						</div>
						<?php
					}
					?>
				</div>
				<?php
			}
			?>
		</div><!-- .cars_condition_carousel-wrapper -->
	</div>
</div>
