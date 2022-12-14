<?php
/**
 * CarDealer Visual Composer vehicles search type Shortcode
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package car-dealer-helper/functions
 */

add_shortcode( 'cd_vehicles_search_type', 'cdhl_cd_vehicles_search_type_shortcode' );

/**
 * Shortcode HTML.
 *
 * @param array $atts .
 * @param array $content .
 */
function cdhl_cd_vehicles_search_type_shortcode( $atts, $content ) {
	extract(
		shortcode_atts(
			array(
				'cars_body_styles'       => '',
				'vehicle_makes'          => '',
				'search_style'           => 'style_1',
				'search_section_label'   => esc_html__( 'I want Search', 'cardealer-helper' ),
				'type_search_tab_lables' => 'default',
				'hide_type_tab'          => 'no',
			),
			$atts
		)
	);
	extract( $atts );
	if ( empty( $search_style ) ) {
		return;
	}

	if ( isset($type_search_tab_lables) && empty($type_search_tab_lables) ) {
		$type_search_tab_lables = 'default'	;
	}

	$selected_body_styles = ! empty( $cars_body_styles ) ? explode( ',', $cars_body_styles ) : '';
	$selected_makes       = ! empty( $vehicle_makes ) ? explode( ',', $vehicle_makes ) : '';
	$car_make_label       = cardealer_get_field_label_with_tax_key( 'car_make' );
	$car_body_style_label = cardealer_get_field_label_with_tax_key( 'car_body_style' );

	// Vehicle Serach Criterias.
	ob_start();
	$uid        = uniqid();
	$make_label = '';
	$type_label = '';
	if ( "default" == $type_search_tab_lables ) {
		$make_label = sprintf( esc_html__( 'Browse %s', 'cardealer-helper' ), $car_make_label );
		$type_label = sprintf( esc_html__( 'Browse %s', 'cardealer-helper' ), $car_body_style_label );
	} else {
		$make_label = ( ! empty($custom_lbl_type_1) ) ? $custom_lbl_type_1 : $make_label;
		$type_label = ( ! empty($custom_lbl_type_2) ) ? $custom_lbl_type_2 : $type_label;
	}

	$make_label = apply_filters( 'search_type_browse_make_label', $make_label );
	$type_label = apply_filters( 'search_type_browse_type_label', $type_label );

	if ( 'style_1' === $search_style ) {
		// Get vehicle page link.
		if ( isset( $car_dealer_options['cars_inventory_page'] ) && ! empty( $car_dealer_options['cars_inventory_page'] ) ) {
			$car_url = get_permalink( $car_dealer_options['cars_inventory_page'] );
		} else {
			$car_url = get_post_type_archive_link( 'cars' );
		}
		?>
		<div class="search-logo search-block clearfix <?php echo esc_attr( $search_style ); ?>">
			<?php echo $content; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE ?>
				<div class="sort-filters-box search-tab">
					<div id="tabs-<?php echo esc_attr( $uid ); ?>" class="cardealer-tabs">
						<h6> <?php echo esc_html( $search_section_label ); ?></h6>
						<ul class="tabs text-left">
							<?php
							if ( 'make' !== $hide_type_tab ) {
								?>
								<li data-tabs="search-by-make-<?php echo esc_attr( $uid ); ?>" class="active">  <?php echo esc_html( $make_label ); ?></li>
								<?php
							}
							if ( 'body_type' !== $hide_type_tab ) {
								?>
								<li data-tabs="search-by-type-<?php echo esc_attr( $uid ); ?>"> <?php echo esc_html( $type_label ); ?> </li>
								<?php
							}
							?>
						</ul>
						<?php
						if ( 'make' !== $hide_type_tab ) {
							?>
							<div id="search-by-make-<?php echo esc_attr( $uid ); ?>" class="cardealer-tabcontent">
								<?php
								$all_makes = cdhl_get_term_data_by_taxonomy( 'car_make' );
								$makes     = array_keys( $all_makes ); // makes to display.
								if ( ! empty( $selected_makes ) ) {
									// match selected makes with all makes and display only matched make.
									$makes = array_intersect( $selected_makes, array_keys( $all_makes ) );
								}
								if ( ! empty( $makes ) ) {
									foreach ( $makes as $make ) {
										$vehicle_make = $all_makes[ $make ];
										if ( ! isset( $all_makes[ $make ] ) ) {
											continue;
										}
										$make_term = get_term_by( 'name', $vehicle_make['name'], 'car_make' );
										if ( is_wp_error( $make_term ) || empty( $make_term ) ) {
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
							<div id="search-by-type-<?php echo esc_attr( $uid ); ?>" class="cardealer-tabcontent">
								<?php
								$all_styles = cdhl_get_term_data_by_taxonomy( 'car_body_style' );
								$styles     = array_keys( $all_styles ); // makes to display.
								if ( ! empty( $selected_body_styles ) ) {
									// match selected body_styles with all body_styles and display only matched body_styles.
									$styles = array_intersect( $selected_body_styles, array_keys( $all_styles ) );
								}
								if ( ! empty( $styles ) ) {
									foreach ( $styles as $style ) {
										if ( ! isset( $all_styles[ $style ] ) ) {
											continue;
										}
										$style = $all_styles[ $style ];

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
		<?php
	}
	return ob_get_clean();
}

/**
 * Shortcode mapping.
 *
 * @return void
 */
function cdhl_vehicles_seach_type_shortcode_integrateWithVC() {

	if ( function_exists( 'vc_map' ) ) {
		$car_make_label   = cardealer_get_field_label_with_tax_key( 'car_make' );
		$p_car_make_label = cardealer_get_field_label_with_tax_key( 'car_make', 'plural' );
		$car_body_label   = cardealer_get_field_label_with_tax_key( 'car_body_style' );
		$p_car_body_label = cardealer_get_field_label_with_tax_key( 'car_body_style', 'plural' );

		vc_map(
			array(
				'name'     => esc_html__( 'Potenza Vehicles By Type', 'cardealer-helper' ),
				'base'     => 'cd_vehicles_search_type',
				'class'    => '',
				'category' => esc_html__( 'Potenza', 'cardealer-helper' ),
				'icon'     => cardealer_vc_shortcode_icon( 'cd_vehicles_search_type' ),
				'params'   => array(
					array(
						'type'       => 'cd_radio_image_2',
						'heading'    => esc_html__( 'Search Style', 'cardealer-helper' ),
						'param_name' => 'search_style',
						'options'    => array(
							array(
								'value' => 'style_1',
								'title' => 'Style 1',
								'image' => trailingslashit( CDHL_VC_URL ) . 'vc_images/options/cd_vehicles_search_type/style_1.png',
							),
						),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Section Title', 'cardealer-helper' ),
						'description' => esc_html__( 'Enter search section label', 'cardealer-helper' ),
						'param_name'  => 'search_section_label',
						'value'       => esc_html__( 'I want search', 'cardealer-helper' ),
					),
					array(
						'type'        => 'checkbox',
						'heading'     => sprintf( esc_html__( 'Select %s', 'cardealer-helper' ), $car_make_label ),
						'description' => sprintf( esc_html__( 'Select car "%1$s" to display on front. If no one selected, then it will show all "%2$s". Also, please select a list of four items so it looks proper.', 'cardealer-helper' ), $car_make_label, $p_car_make_label ),
						'param_name'  => 'vehicle_makes',
						'value'       => cdhl_get_term_data_by_taxonomy( 'car_make', 'term_array' ),
						'save_always' => true,
					),
					array(
						'type'        => 'checkbox',
						'heading'     => sprintf( esc_html__( 'Select %s', 'cardealer-helper' ), $car_body_label ),
						'description' => sprintf( esc_html__( 'Select car "%1$s" to display on front. If no one selected, then it will show all "%2$s". Also, please select a list of four items so it looks proper.', 'cardealer-helper' ), $car_body_label, $p_car_body_label ),
						'param_name'  => 'cars_body_styles',
						'value'       => cdhl_get_term_data_by_taxonomy( 'car_body_style', 'term_array' ),
						'save_always' => true,
					),
					array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( ' Tab Labels', 'cardealer-helper' ),
						'param_name'  => 'type_search_tab_lables',
						'value'       => array(
							esc_html__( 'Custom labels', 'cardealer-helper' ) => 'custom',
						),
						'admin_label' => true,
						'save_always' => true,
						'description' => esc_html__( 'Check this box to add custom Tab labels.', 'cardealer-helper' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Custom Label For ', 'cardealer-helper' ) . $car_make_label,
						'description' => esc_html__( 'Enter custom label for ', 'cardealer-helper' ) . $car_make_label,
						'param_name'  => 'custom_lbl_type_1',
						'value'       => sprintf( esc_html__( 'Browse %s', 'cardealer-helper' ), $car_make_label ),
						'dependency'  => array(
							'element' => 'type_search_tab_lables',
							'value'   => array( 'custom' ),
						),
						'group'       => esc_html__( 'Custom Labels', 'cardealer-helper' ),
						'save_always' => true,
						//'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Custom Label For ', 'cardealer-helper' ) . $car_body_label,
						'description' => esc_html__( 'Enter custom label for ', 'cardealer-helper' ) . $car_body_label,
						'param_name'  => 'custom_lbl_type_2',
						'value'       => sprintf( esc_html__( 'Browse %s', 'cardealer-helper' ), $car_body_label ),
						'dependency'  => array(
							'element' => 'type_search_tab_lables',
							'value'   => array( 'custom' ),
						),
						'group'       => esc_html__( 'Custom Labels', 'cardealer-helper' ),
						'save_always' => true,
						//'edit_field_class' => 'vc_col-sm-6 vc_column',
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Hide Tab', 'cardealer-helper' ),
						'param_name'  => 'hide_type_tab',
						'value'       => array(
							esc_html__( 'Select', 'cardealer-helper' )                                   => 'no',
							sprintf( esc_html__( 'Hide Tab %s ', 'cardealer-helper' ), $car_make_label ) => 'make',
							sprintf( esc_html__( 'Hide Tab %s ', 'cardealer-helper' ), $car_body_label ) => 'body_type',
						),
						'std'         => 'no',
						'save_always' => true,
						'description' => esc_html__( 'Selected tab will hide on front .', 'cardealer-helper' ),
					),
				),
			)
		);
	}
}
add_action( 'vc_before_init', 'cdhl_vehicles_seach_type_shortcode_integrateWithVC' );
