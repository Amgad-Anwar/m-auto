<?php
/**
 * Vehicles by type Elementor widget template
 *
 * @package car-dealer-helper
 */

global $car_dealer_options;

$search_section_label   = isset( $settings['search_section_label'] ) ? $settings['search_section_label'] : '';
$selected_body_styles   = isset( $settings['cars_body_styles'] ) ? $settings['cars_body_styles'] : '';
$selected_makes         = isset( $settings['vehicle_makes'] ) ? $settings['vehicle_makes'] : '';
$type_search_tab_lables = isset( $settings['type_search_tab_lables'] ) ? $settings['type_search_tab_lables'] : 'default';
$hide_type_tab          = isset( $settings['hide_type_tab'] ) ? $settings['hide_type_tab'] : 'no';
$custom_lbl_type_1      = isset( $settings['custom_lbl_type_1'] ) ? $settings['custom_lbl_type_1'] : '';
$custom_lbl_type_2      = isset( $settings['custom_lbl_type_2'] ) ? $settings['custom_lbl_type_2'] : '';


if ( isset($type_search_tab_lables) && empty($type_search_tab_lables) ) {
	$type_search_tab_lables = 'default'	;
}

$car_make_label       = cardealer_get_field_label_with_tax_key( 'car_make' );
$car_body_style_label = cardealer_get_field_label_with_tax_key( 'car_body_style' );
$make_label           = '';
$type_label           = '';

if ( "default" == $type_search_tab_lables ) {
	$make_label = sprintf( esc_html__( 'Browse %s', 'cardealer-helper' ), $car_make_label );
	$type_label = sprintf( esc_html__( 'Browse %s', 'cardealer-helper' ), $car_body_style_label );
} else {
	$make_label = ( ! empty($custom_lbl_type_1) ) ? $custom_lbl_type_1 : $make_label;
	$type_label = ( ! empty($custom_lbl_type_2) ) ? $custom_lbl_type_2 : $type_label;
}

$make_label = apply_filters( 'search_type_browse_make_label', $make_label );
$type_label = apply_filters( 'search_type_browse_type_label', $type_label );

// Get vehicle page link.
if ( isset( $car_dealer_options['cars_inventory_page'] ) && ! empty( $car_dealer_options['cars_inventory_page'] ) ) {
	$car_url = get_permalink( $car_dealer_options['cars_inventory_page'] );
} else {
	$car_url = get_post_type_archive_link( 'cars' );
}

$this->add_render_attribute( 'cdhl_vehicle_by_type', 'class', 'search-logo search-block clearfix style_1' );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_vehicle_by_type' ); ?>>
		<div class="sort-filters-box search-tab">
			<div id="tabs-<?php echo esc_attr( $this->get_id() ); ?>" class="cardealer-tabs">
				<h6><?php echo esc_html( $search_section_label ); ?></h6>
				<ul class="tabs text-left">
					<?php
					if ( 'make' !== $hide_type_tab ) {
						?>
						<li data-tabs="search-by-make-<?php echo esc_attr( $this->get_id() ); ?>" class="active">  <?php echo esc_html( $make_label ); ?></li>
						<?php
					}
					if ( 'body_type' !== $hide_type_tab ) {
						?>
						<li data-tabs="search-by-type-<?php echo esc_attr( $this->get_id() ); ?>"> <?php echo esc_html( $type_label ); ?> </li>
						<?php
					}
					?>
				</ul>
				<?php
				if ( 'make' !== $hide_type_tab ) {
					?>
					<div id="search-by-make-<?php echo esc_attr( $this->get_id() ); ?>" class="cardealer-tabcontent">
						<?php
						$all_makes = cdhl_get_term_data_by_taxonomy( 'car_make' );
						$makes     = array_keys( $all_makes ); // makes to display.
						if ( $selected_makes ) {
							// match selected makes with all makes and display only matched make.
							$makes = array_intersect( $selected_makes, array_keys( $all_makes ) );
						}
						if ( $makes ) {
							foreach ( $makes as $make ) {
								$vehicle_make = $all_makes[ $make ];
								if ( ! isset( $all_makes[ $make ] ) ) {
									continue;
								}
								$make_term = get_term_by( 'name', $vehicle_make['name'], 'car_make' );
								if ( is_wp_error( $make_term ) || ! $make_term ) {
									continue;
								}
								?>
								<div class="col-md-3 col-sm-4">
									<a href="<?php echo esc_url( $car_url . '?car_make=' . $make_term->slug ); ?>" title="<?php echo esc_attr( $vehicle_make['name'] ); ?>">
										<div class="search-logo-box">
											<img class="img-responsive center-block" src="<?php echo esc_url( is_array( $vehicle_make['logo_img'] ) ? $vehicle_make['logo_img'][0] : $vehicle_make['logo_img'] ); ?>" alt="" width="150" height="150">
											<strong><?php echo esc_html( $vehicle_make['name'] ); ?></strong>
											<span><?php echo esc_html( $vehicle_make['posts'] ); ?></span>
										</div>
									</a>
								</div>
								<?php
							}
						} else {
							?>
							<div class="col-md-3 col-sm-4">
								<p><?php esc_html_e( 'No makes available!', 'cardealer-helper' ); ?></p>
							</div>
							<?php
						}
						?>
					</div>
					<?php
				}
				if ( 'body_type' !== $hide_type_tab ) {
					?>
					<div id="search-by-type-<?php echo esc_attr( $this->get_id() ); ?>" class="cardealer-tabcontent">
						<?php
						$all_styles = cdhl_get_term_data_by_taxonomy( 'car_body_style' );
						$styles     = array_keys( $all_styles ); // makes to display.
						if ( $selected_body_styles ) {
							// match selected body_styles with all body_styles and display only matched body_styles.
							$styles = array_intersect( $selected_body_styles, array_keys( $all_styles ) );
						}
						if ( $styles ) {
							foreach ( $styles as $style ) {
								if ( ! isset( $all_styles[ $style ] ) ) {
									continue;
								}
								$style               = $all_styles[ $style ];
								$car_body_style_term = get_term_by( 'name', $style['name'], 'car_body_style' );
								?>
								<div class="col-md-3 col-sm-4">
									<a href="<?php echo esc_url( $car_url . '?car_body_style=' . $car_body_style_term->slug ); ?>" title="<?php echo esc_attr( $style['name'] ); ?>">
										<div class="search-logo-box">
											<img class="img-responsive center-block" src="<?php echo esc_url( is_array( $style['logo_img'] ) ? $style['logo_img'][0] : $style['logo_img'] ); ?>" alt="" width="150" height="150">
											<strong><?php echo esc_html( $style['name'] ); ?></strong>
											<span><?php echo esc_html( $style['posts'] ); ?></span>
										</div>
									</a>
								</div>
								<?php
							}
						} else {
							?>
							<div class="col-md-3 col-sm-4">
								<p><?php esc_html_e( 'No Body Style available!', 'cardealer-helper' ); ?></p>
							</div>
							<?php
						}
						?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="filter-loader"></div>
	</div>
</div>
