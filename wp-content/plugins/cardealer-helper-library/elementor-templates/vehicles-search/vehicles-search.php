<?php
/**
 * Vehicles Search Elementor widget template
 *
 * @package car-dealer-helper
 */

$matching_vehicles           = 0;
$section_title               = isset( $settings['section_title'] ) ? $settings['section_title'] : '';
$src_button_label            = isset( $settings['src_button_label'] ) ? $settings['src_button_label'] : '';
$filter_background           = isset( $settings['filter_background'] ) ? $settings['filter_background'] : '';
$search_condition_tabs       = isset( $settings['search_condition_tabs'] ) ? $settings['search_condition_tabs'] : '';
$custom_lbl_all_vehicles     = isset( $settings['custom_lbl_all_vehicles'] ) ? $settings['custom_lbl_all_vehicles'] : '';
$condition_custom_tab_lables = isset( $settings['condition_custom_tab_lables'] ) ? $settings['condition_custom_tab_lables'] : '';
$vehicle_filters             = isset( $settings['vehicle_filters'] ) ? $settings['vehicle_filters'] : '';
$hide_location_input         = isset( $settings['hide_location_input'] ) ? $settings['hide_location_input'] : '';

if ( $condition_custom_tab_lables ) {
	$condition_tab_lables = 'custom';
} else {
	$condition_tab_lables = 'default';
}

// Vehicle Serach Criterias.
$carsfilters = array(
	'car_year',
	'car_make',
	'car_model',
);

if ( ! empty( $vehicle_filters ) ) {
	$carsfilters = $vehicle_filters;
}

// Vehicle Serach Criterias.
foreach ( $carsfilters as $filter ) {
	$vehicle_conditions[$filter] = cardealer_get_field_label_with_tax_key($filter);
}
$vehicle_conditions = apply_filters( 'car_search_attrs', $vehicle_conditions );


$tab_label = apply_filters( 'search_cars_tab_label', $section_title );

$this->add_render_attribute(
	[
		'cdhl_vehicles_search' => [
			'class' => [
				'slider-content',
				'vehicle-search-section',
				'text-center',
				'clearfix',
				'box',
				$filter_background,
			],
		],
	]
);

$this->add_render_attribute( 'cdhl_vehicles_search_row', 'class', 'row sort-filters-box search-tab' );
$this->add_render_attribute( 'cdhl_vehicles_search_tabs', 'class', 'cardealer-tabs' );
$this->add_render_attribute( 'cdhl_vehicles_search_tabs', 'id', 'tabs-' . $this->get_id() );

$data_tabs         = 'all_vehicles-' . $this->get_id();
if ( "default" == $condition_tab_lables ) {
	$all_vehicle_label = esc_html__( 'All vehicles', 'cardealer-helper' );
} else {
	$all_vehicle_label = $custom_lbl_all_vehicles;
}

$tab_lables = array();
if ( empty( $search_condition_tabs ) ) {

	$tab_lables[] = array(
		'data_tabs' => $data_tabs,
		'label'     => $all_vehicle_label,
		'tax_key'   => 'all_vehicles'
	);

	$tax_conditions = cdhl_get_terms( array( 'taxonomy' => 'car_condition' ) );

	if ( ! empty($tax_conditions) ) {
		foreach ( $tax_conditions as $tax_label => $tax_slug ) {
			$tax_cond_label = ( "custom" == $condition_tab_lables ) ? $settings['custom_lbl_' . $tax_slug]  : $tax_label;

			$tab_lables[] = array(
				'data_tabs' => $tax_slug . '-'. $this->get_id(),
				'label'     => $tax_cond_label,
				'tax_key'   => $tax_slug
			);
		}
	}

} else {

	foreach ( $search_condition_tabs as $search_condition_slug ) {

		if ( 'all_vehicles' === $search_condition_slug ) {
			$tab_lables[] = array(
				'data_tabs' => $data_tabs,
				'label'     => $all_vehicle_label,
				'tax_key'   => 'all_vehicles'
			);
		} else {

			$term = get_term_by( 'slug', $search_condition_slug, 'car_condition' );
			if ( $term ) {
				$term_label = ( "custom" == $condition_tab_lables ) ? $settings['custom_lbl_' . $term->slug]  : $term->name;

				$tab_lables[] = array(
					'data_tabs' => $search_condition_slug . '-'. $this->get_id(),
					'label'     => $term_label,
					'tax_key'   => $term->slug
				);
			}
		}
	}
}

?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_vehicles_search' ); ?>>
		<div <?php $this->print_render_attribute_string( 'cdhl_vehicles_search_row' ); ?>>
			<div <?php $this->print_render_attribute_string( 'cdhl_vehicles_search_tabs' ); ?>>
				<h6> <?php echo esc_html( $tab_label ); ?></h6>
				<ul class="tabs text-left">
					<?php
					foreach ( $tab_lables as $tab_lable ) {
						?>
						<li data-tabs="<?php echo esc_attr( $tab_lable['data_tabs'] ); ?>" class="<?php echo ( $tab_lable['tax_key'] == 'all_vehicles' ) ? 'active' : ''; ?>">
							<?php echo esc_html($tab_lable['label']); ?>
						</li>
						<?php
					}
					?>
				</ul>
				<?php
				foreach ( $tab_lables as $tab_lable ) {
					?>
					<div id="<?php echo esc_attr( $tab_lable['data_tabs'] ); ?>" class="cardealer-tabcontent" data-condition="<?php echo esc_attr( $tab_lable['tax_key'] ); ?>">
						<form>
							<div class="col-lg-10 col-md-9 col-sm-12">
								<div class="row">
									<?php
									if ( $tab_lable['tax_key'] == 'all_vehicles' ) {

										global $wpdb;
										if ( cardealer_is_wpml_active() ) {
											$all_cars = "SELECT count(p.id) FROM $wpdb->posts p LEFT JOIN " . $wpdb->prefix . "icl_translations t
											ON p.ID = t.element_id
											WHERE p.post_type = 'cars'
											AND p.post_status = 'publish'
											AND t.language_code = '" . ICL_LANGUAGE_CODE . "'";
										} else {
											$all_cars = "SELECT count(p.id) FROM $wpdb->posts p WHERE p.post_type = 'cars' and p.post_status = 'publish'";
										}

										$matching_vehicles = $wpdb->get_var( $all_cars );

										$total             = count( $vehicle_conditions );
										foreach ( $vehicle_conditions as $filters => $label ) :
											$tax_terms     = cdhl_get_terms(
												array(
													'taxonomy' => $filters,
													'orderby'  => 'name',
												)
											);

											$label = cardealer_get_field_label_with_tax_key( $filters );
											if ( $hide_location_input === 'true' ) {
												if ( 4 > $total ) {
													?>
													<div class="col-lg-4 col-md-3 col-sm-4">
													<?php
												} else {
													?>
													<div class="col-lg-3 col-md-3 col-sm-4">
													<?php
												}
											} else {
												?>
												<div class="col-lg-2 col-md-3 col-sm-4">
												<?php
											}
											?>
												<div class="selected-box">
													<select
													data-uid="<?php echo esc_attr( $this->get_id() ); ?>"
													id="all-cars_sort_<?php echo esc_attr( $filters . '_' . $this->get_id() ); ?>"
													data-id="<?php echo esc_attr( $filters ); ?>"
													data-tid="<?php echo esc_attr( $tab_lable['tax_key'] ); ?>"
													class="selectpicker search-filters-box col-4 cd-select-box <?php echo esc_attr( $tab_lable['tax_key'] ); ?>"
													name="<?php echo esc_attr( $filters ); ?>">
														<option value=""><?php echo esc_html( $label ); ?></option>
														<?php
														foreach ( $tax_terms as $key => $term ) :
															?>
															<option value="<?php echo esc_attr( $term ); ?>"><?php echo esc_html( $key ); ?></option>
															<?php
														endforeach;
														?>
													</select>
												</div>
											</div>
											<?php
										endforeach;

									} else {
										?>
										<input type="hidden" name="car_condition" value="<?php echo esc_attr( $tab_lable['tax_key'] ); ?>" />
										<?php
										$term      = get_term_by( 'slug', $tab_lable['tax_key'], 'car_condition' );
										$car_terms = cdhl_get_car_attrs_by_condition( array( $term->name, $tab_lable['tax_key'] ), $vehicle_conditions );
										$total     = count( $car_terms );
										foreach ( $car_terms as $terms ) {
											$label             = $terms['tax_label'];
											$matching_vehicles = $terms['vehicles_matched'];
											if ( $hide_location_input === 'true' ) {
												if ( 4 > $total ) {
													?>
													<div class="col-lg-4 col-md-3 col-sm-4">
													<?php
												} else {
													?>
													<div class="col-lg-3 col-md-3 col-sm-4">
													<?php
												}
											} else {
												?>
												<div class="col-lg-2 col-md-3 col-sm-4">
												<?php
											}
											?>
												<div class="selected-box">
													<select data-uid="<?php echo esc_attr( $this->get_id() ); ?>"
													id="<?php echo esc_attr( $tab_lable['tax_key'] ); ?>_<?php echo esc_attr( $terms['taxonomy'] . '_' . $this->get_id() ); ?>"
													data-id="<?php echo esc_attr( $terms['taxonomy'] ); ?>"
													data-tid="<?php echo esc_attr( $tab_lable['tax_key'] ); ?>"
													class="selectpicker search-filters-box col-4 cd-select-box <?php echo esc_attr( $tab_lable['tax_key'] ); ?>"
													name="<?php echo esc_attr( $terms['taxonomy'] ); ?>">
														<option value=""><?php echo esc_html( $label ); ?></option>
														<?php
														foreach ( $terms['tax_terms'] as $key => $term ) {
															?>
															<option value="<?php echo esc_attr( $term['slug'] ); ?>"><?php echo esc_html( $term['name'] ); ?></option>
															<?php
														}
														?>
													</select>
												</div>
											</div>
											<?php
										}
									}
									if ( ! $hide_location_input ) {
										if ( 4 > $total ) {
											?>
											<div class="col-lg-6 col-md-3 col-sm-4">
											<?php
										} else {
											?>
											<div class="col-lg-4 col-md-3 col-sm-12">
											<?php
										}
										?>
											<div class="form-group">
												<input id="vehicle_location_<?php echo esc_attr( $this->get_id() ); ?>" type="text" placeholder="<?php esc_html_e( 'Location', 'cardealer-helper' ); ?>" class="form-control placeholder search-filters-input-box" name="vehicle_location">
											</div>
										</div>
										<?php
									}
									?>
								</div>
							</div>

							<div class="col-lg-2 col-md-3 col-sm-12">
								<div class="text-center">
									<button class="button btn-block red csb-submit-btn" type="button">
									<?php
										echo ( ! empty( $src_button_label ) ) ? esc_html( $src_button_label ) : esc_html__( 'Search', 'cardealer-helper' )// phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE
									?>
									</button>
								</div>
							</div>

							<div class="car-total pull-right">
								<h5 class="text-white"><i class="fas fa-caret-right"></i>(<p class="matching-vehicles"><?php echo esc_html( $matching_vehicles ); ?></p>) <span class="text-red"><?php echo esc_html__( 'Vehicles', 'cardealer-helper' ); ?></span></h5>
							</div>
						</form>
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
