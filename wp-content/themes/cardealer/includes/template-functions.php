<?php
/**
 * Vehicle detail page sidebar functions.
 */
if ( ! function_exists( 'cardealer_single_vehicle_sidebar_trade_in_appraisal' ) ) {
	function cardealer_single_vehicle_sidebar_trade_in_appraisal( $post_id ) {
		global $car_dealer_options;

		$tia_form_status        = ( isset( $car_dealer_options['trade_in_appraisal_form_status'] ) && '' !== $car_dealer_options['trade_in_appraisal_form_status'] ) ? filter_var( $car_dealer_options['trade_in_appraisal_form_status'], FILTER_VALIDATE_BOOLEAN ) : true;
		$tia_form_cf7_shortcode = false;

		if ( isset( $car_dealer_options['trade_in_appraisal_form_cf7_shortcode'] ) && ! empty( $car_dealer_options['trade_in_appraisal_form_cf7_shortcode'] ) ) {
			$tia_form_cf7_shortcode = $car_dealer_options['trade_in_appraisal_form_cf7_shortcode'];
		}

		if ( $tia_form_status && $tia_form_cf7_shortcode ) {
			get_template_part( 'template-parts/cars/single-car/forms/trade-in-appraisal' );
		}
	}
}

if ( ! function_exists( 'cardealer_single_vehicle_sidebar_buy_online_btn' ) ) {
	function cardealer_single_vehicle_sidebar_buy_online_btn( $post_id ) {
		cardealer_add_vehicale_to_cart( $post_id );
	}
}

if ( ! function_exists( 'cardealer_single_vehicle_sidebar_review_stamps' ) ) {
	function cardealer_single_vehicle_sidebar_review_stamps( $post_id ) {
		cardealer_get_vehicle_review_stamps( $post_id );
	}
}

if ( ! function_exists( 'cardealer_get_cars_details_title_location_mobile' ) ) {
	/**
	 * Cars details page title position in mobile
	 */
	function cardealer_get_cars_details_title_location_mobile() {
		global $car_dealer_options;
		$title_location_mobile = 'below-image-gallery';
		if ( isset( $car_dealer_options['cars-details-title-location-mobile'] ) && ! empty( $car_dealer_options['cars-details-title-location-mobile'] ) ) {
			$title_location_mobile = $car_dealer_options['cars-details-title-location-mobile'];
		}
		return $title_location_mobile;
	}
}

if ( ! function_exists( 'cardealer_get_cars_details_breadcrumb' ) ) {
	/**
	 * Cars details page breadcrumbs
	 */
	function cardealer_get_cars_details_breadcrumb() {
		global $car_dealer_options;
		$mobile_breadcrumb_class = ( isset( $car_dealer_options['breadcrumbs_on_mobile'] ) && 1 === (int) $car_dealer_options['breadcrumbs_on_mobile'] ) ? '' : 'breadcrumbs-hide-mobile';
        if ( function_exists( 'bcn_display_list' )
            && isset( $car_dealer_options['display_breadcrumb'] )
            && ! empty( $car_dealer_options['display_breadcrumb'] )
        ) {
            ob_start();
			?>
			<ul class="page-breadcrumb <?php echo esc_attr( $mobile_breadcrumb_class ); ?>" typeof="BreadcrumbList" vocab="http://schema.org/">
                <?php bcn_display_list(); ?>
            </ul>
            <?php
			echo ob_get_clean();
        }
	}
}

if ( ! function_exists( 'cardealer_single_vehicle_sidebar_attributes' ) ) {
	function cardealer_single_vehicle_sidebar_attributes( $post_id ) {
		?>
		<div class="details-block details-weight">
			<h6><?php esc_html_e( 'Description', 'cardealer' ); ?></h6>
			<?php cardealer_get_cars_attributes( $post_id ); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'cardealer_vehicle_sold_label' ) ) {
	function cardealer_vehicle_sold_label() {
		$car_status = get_post_meta( get_the_ID() , 'car_status', true );
		if ( isset( $car_status ) && ! empty( $car_status ) && 'sold' === $car_status ) {
			global $car_dealer_options;
			$vehicle_sold_label = ( isset( $car_dealer_options['vehicle_sold_label'] ) && '' !== $car_dealer_options['vehicle_sold_label'] ) ? $car_dealer_options['vehicle_sold_label'] : esc_html__( 'Sold', 'cardealer' );
			?>
			<div class="layout-4-vehicle-status"><span class="label layout-4 car-status"><?php echo esc_html( $vehicle_sold_label ); ?></span></div>
			<?php
		}
	}
}

if ( ! function_exists( 'cardealer_vehicle_image_gallery_video_button' ) ) {
	function cardealer_vehicle_image_gallery_video_button() {
		$element_id      = uniqid( 'cd_video_' );
        $video_link      = get_post_meta( get_the_ID(), 'video_link', $single = true );
        $element_classes = array(
            'play-video',
            'popup-gallery',
        );
        $element_classes = implode( ' ', array_filter( array_unique( $element_classes ) ) );

		if ( isset( $video_link ) && ! empty( $video_link ) ) {
            ob_start();
			?>
			<div class="watch-video-btn">
                <div id="<?php echo esc_attr( $element_id ); ?>"  class="<?php echo esc_attr( $element_classes ); ?> default">
                    <a class="popup-youtube" href="<?php echo esc_url( $video_link ); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"> <i class="fas fa-play"></i> <?php esc_html_e( 'Vehicle video', 'cardealer' ); ?></a>
                </div>
            </div>
            <?php
			echo ob_get_clean();
        }
	}
}


/**
 * Vehicle subtitle attributes.
 */
if ( ! function_exists( 'cardealer_subtitle_attributes' ) ) {
	function cardealer_subtitle_attributes( $post_id = null ) {
		global $car_dealer_options;
		$taxonomys = ( isset( $car_dealer_options['vehicle-subtitle-attributes'] ) ) ? $car_dealer_options['vehicle-subtitle-attributes'] : array();
		if ( empty($taxonomys) || ! $post_id ) {
			return;
		} else if ( empty(array_values($taxonomys) ) ) {
			return;
		}
		$taxonomies_obj = get_object_taxonomies( 'cars', 'object' );
		$attributes     = array();
		foreach ( $taxonomys as $tax ) {
			$term = wp_get_post_terms( $post_id, $tax );
			if ( ! is_wp_error( $term ) && ! empty( $term ) ) {
				$label              = $taxonomies_obj[ $tax ]->labels->singular_name;
				$attributes[ $tax ] = array(
					'attr'  => $label,
					'value' => $term[0]->name,
				);
			}
		}

		$attributs_html = '';
		if ( is_array( $attributes ) && ! empty( $attributes ) ) {

			$attributs_html = '<ul class="vehicle-subtitle-attributes">';
			foreach ( $attributes as $attribute_k => $attribute ) {

				// skip if attribute or value is not set.
				if ( ! isset( $attribute['value'] ) || '' === $attribute['value'] ) {
					continue;
				}

				$attributs_html .= '<li class="' . esc_attr( $attribute_k ) . '"><span title="' . esc_attr( $attribute['attr'] ) . '">' . $attribute['value'] . '<span></li>';
			}
			$attributs_html .= '</ul>';

		}

		echo $attributs_html;
	}
}

/**
 * Vehicle detail page tabs functions.
 */
if ( ! function_exists( 'cardealer_default_vehicle_tabs' ) ) {

	/**
	 * Add default vehicle tabs to vehicle pages.
	 *
	 * @param array $tabs Array of tabs.
	 * @return array
	 */
	function cardealer_default_vehicle_tabs( $tabs = array() ) {
		global $post, $car_dealer_options;

		$car_id = get_the_ID();

		// Overview tab.
		$vehicle_overview_display = ( isset( $car_dealer_options['cars-vehicle-overview-option'] ) ) ? $car_dealer_options['cars-vehicle-overview-option'] : 1;
		$vehicle_overview         = get_post_meta( $car_id, 'vehicle_overview', true );
		$vehicle_overview_label   = ( isset( $car_dealer_options['cars-vehicle-overview-label'] ) ) ? $car_dealer_options['cars-vehicle-overview-label'] : __( 'Overview', 'cardealer' );
		if ( $vehicle_overview_display && $vehicle_overview ) {
			$tabs['overview'] = array(
				'title'    => $vehicle_overview_label,
				'priority' => 10,
				'callback' => 'cardealer_vehicle_overview_tab',
				'icon'     => 'fas fa-sliders-h',
			);
		}

		// Features & Options tab.
		$car_features_options_display = ( isset( $car_dealer_options['cars-features-options-option'] ) ) ? $car_dealer_options['cars-features-options-option'] : 1;
		$car_features_options         = wp_get_post_terms( $car_id, 'car_features_options' );
		$features_options_label       = ( isset( $car_dealer_options['cars-features-options-label'] ) ) ? $car_dealer_options['cars-features-options-label'] : __( 'Features & Options', 'cardealer' );
		if ( $car_features_options_display && ! empty( $car_features_options ) ) {
			$tabs['features'] = array(
				'title'    => $features_options_label,
				'priority' => 20,
				'callback' => 'cardealer_vehicle_features_tab',
				'icon'     => 'fas fa-list',
			);
		}

		// Technical Specification tab.
		$technical_specifications_display = ( isset( $car_dealer_options['cars-technical-specifications-option'] ) ) ? $car_dealer_options['cars-technical-specifications-option'] : 1;
		$technical_specifications         = get_post_meta( $car_id, 'technical_specifications', true );
		$technical_specifications_label   = ( isset( $car_dealer_options['cars-technical-specifications-label'] ) ) ? $car_dealer_options['cars-technical-specifications-label'] : __( 'Technical', 'cardealer' );
		if ( $technical_specifications_display && $technical_specifications ) {
			$tabs['technical'] = array(
				'title'    => $technical_specifications_label,
				'priority' => 30,
				'callback' => 'cardealer_vehicle_technical_tab',
				'icon'     => 'fas fa-cogs',
			);
		}

		// General Information tab.
		$general_information_display = ( isset( $car_dealer_options['cars-general-information-option'] ) ) ? $car_dealer_options['cars-general-information-option'] : 1;
		$general_information         = get_post_meta( $car_id, 'general_information', true );
		$general_information_label   = ( isset( $car_dealer_options['cars-general-information-label'] ) ) ? $car_dealer_options['cars-general-information-label'] : __( 'General Information', 'cardealer' );
		if ( $general_information_display && ! empty( $general_information ) ) {
			$tabs['general_info'] = array(
				'title'    => $general_information_label,
				'priority' => 40,
				'callback' => 'cardealer_vehicle_general_info_tab',
				'icon'     => 'fas fa-info-circle',
			);
		}

		// Location tab.
		$location_display = ( isset( $car_dealer_options['cars-vehicle-location-option'] ) ) ? $car_dealer_options['cars-vehicle-location-option'] : 1;
		$location_exist = false;
		$lat            = '';
		$lan            = '';

		if ( isset( $car_dealer_options['default_value_lat'] ) && isset( $car_dealer_options['default_value_long'] ) && ! empty( $car_dealer_options['default_value_lat'] ) && ! empty( $car_dealer_options['default_value_long'] ) ) {
			$location_exist = true;
		}

		$location = get_post_meta( $car_id, 'vehicle_location', true );

		if ( ! empty( $location ) ) {
			$location_exist = true;
		}

		$vehicle_location_label   = ( isset( $car_dealer_options['cars-vehicle-location-label'] ) ) ? $car_dealer_options['cars-vehicle-location-label'] : __( 'Location', 'cardealer' );
		if ( $location_display && $location_exist ) {
			$tabs['location'] = array(
				'title'    => $vehicle_location_label,
				'priority' => 50,
				'callback' => 'cardealer_vehicle_location_tab',
				'icon'     => 'fas fa-map-marker-alt',
			);
		}

		return $tabs;
	}
}

if ( ! function_exists( 'cardealer_sort_vehicle_tabs' ) ) {

	/**
	 * Sort tabs by priority.
	 *
	 * @param array $tabs Array of tabs.
	 * @return array
	 */
	function cardealer_sort_vehicle_tabs( $tabs = array() ) {

		// Make sure the $tabs parameter is an array.
		if ( ! is_array( $tabs ) ) {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error
			trigger_error( 'Function cardealer_sort_vehicle_tabs() expects an array as the first parameter. Defaulting to empty array.' );
			$tabs = array();
		}

		// Re-order tabs by priority.
		if ( ! function_exists( '_sort_priority_callback' ) ) {
			/**
			 * Sort Priority Callback Function
			 *
			 * @param array $a Comparison A.
			 * @param array $b Comparison B.
			 * @return bool
			 */
			function _sort_priority_callback( $a, $b ) {
				if ( ! isset( $a['priority'], $b['priority'] ) || $a['priority'] === $b['priority'] ) {
					return 0;
				}
				return ( $a['priority'] < $b['priority'] ) ? -1 : 1;
			}
		}

		uasort( $tabs, '_sort_priority_callback' );

		return $tabs;
	}
}

if ( ! function_exists( 'cardealer_vehicle_overview_tab' ) ) {

	/**
	 * Output the description tab content.
	 */
	function cardealer_vehicle_overview_tab() {
		get_template_part( 'template-parts/cars/single-car/tabs/tab-overview' );
	}
}

if ( ! function_exists( 'cardealer_vehicle_features_tab' ) ) {

	/**
	 * Output the description tab content.
	 */
	function cardealer_vehicle_features_tab() {
		get_template_part( 'template-parts/cars/single-car/tabs/tab-features' );
	}
}
if ( ! function_exists( 'cardealer_vehicle_technical_tab' ) ) {

	/**
	 * Output the description tab content.
	 */
	function cardealer_vehicle_technical_tab() {
		get_template_part( 'template-parts/cars/single-car/tabs/tab-technical' );
	}
}
if ( ! function_exists( 'cardealer_vehicle_general_info_tab' ) ) {

	/**
	 * Output the description tab content.
	 */
	function cardealer_vehicle_general_info_tab() {
		get_template_part( 'template-parts/cars/single-car/tabs/tab-general-info' );
	}
}
if ( ! function_exists( 'cardealer_vehicle_location_tab' ) ) {

	/**
	 * Output the description tab content.
	 */
	function cardealer_vehicle_location_tab() {
		get_template_part( 'template-parts/cars/single-car/tabs/tab-location' );
	}
}

function cardear_get_vehicle_detail_page_layout() {
	global $car_dealer_options, $post;
	$layout = isset( $car_dealer_options['cars-details-layout'] ) && ! empty( $car_dealer_options['cars-details-layout'] ) ? $car_dealer_options['cars-details-layout'] : '1';

	$layout = apply_filters( 'cardear_get_vehicle_detail_page_layout', $layout, $post );

	return $layout;
}

function cardear_get_vehicle_detail_page_layout_class() {
	$layout = cardear_get_vehicle_detail_page_layout();
	$class = "car-detail-layout-$layout";
	return $class;
}

function cardealer_vehicle_detail_section_class() {
	global $car_dealer_options;

	$car_section_class = 'car-details page-section-ptb';
	$car_section_class .= ' ' . cardear_get_vehicle_detail_page_layout_class();

	echo esc_attr( $car_section_class );
}

function cardealer_vehicle_detail_section_container_class() {
	global $car_dealer_options;

	$class = 'container';
	if ( '3' === cardear_get_vehicle_detail_page_layout() ) {
		$class = 'container-fluid';
	}
	echo esc_attr( $class );
}

function cardealer_get_vehicle_detail_page_sections( $return = 'all' ) {

	$sections = array(
		'gallery'                => array(
			'label'   => __( 'Gallery - <span>This section will display image gallery.</span>', 'cardealer' ),
			'display' => true,
		),
		'title'                  => array(
			'label'   => __( 'Title/Subtitle - <span>This section will display vehicle title and vehicle attribute as sub-title.</span>', 'cardealer' ),
			'display' => true,
		),
		'short_desc'             => array(
			'label'   => __( 'Short Description/Price - <span>This section will display the short description and vehicle price.</span>', 'cardealer' ),
			'display' => true,
		),
		'btn_request_more_info'  => array(
			'label'   => __( 'Request More Info Button - <span>This section will display the "Request More Info" button.</span>', 'cardealer' ),
			'display' => true,
		),
		'btn_buy_online'         => array(
			'label'   => __( 'Buy Online Button - <span>This section will display the "Buy Online" button.</span>', 'cardealer' ),
			'display' => true,
		),
		'review_stamp'           => array(
			'label'   => __( 'Review Stamp - <span>This section will display review stamp.</span>', 'cardealer' ),
			'display' => true,
		),
		'description'            => array(
			'label'   => __( 'Description - <span>This section will display vehicle attributes.</span>', 'cardealer' ),
			'display' => true,
		),
		'fuel_economy'           => array(
			'label'   => __( 'Fuel Economy - <span>This section will display fuel economy.', 'cardealer' ),
			'display' => true,
		),
		'btn_make_an_offer'      => array(
			'label'   => __( 'Make an Offer Button - <span>This section will display the "Make an Offer" button.</span>', 'cardealer' ),
			'display' => true,
		),
		'btn_schedule_test_drive'=> array(
			'label'   => __( 'Schedule Test Drive Button - <span>This section will display the "Schedule Test Drive" button.</span>', 'cardealer' ),
			'display' => true,
		),
		'btn_email_to_friend'    => array(
			'label'   => __( 'Email to a Friend Button - <span>This section will display the "Email to a Friend" button.</span>', 'cardealer' ),
			'display' => true,
		),
		'btn_financial_form'     => array(
			'label'   => __( 'Financial Form Button - <span>This section will display the "Financial Form" button.</span>', 'cardealer' ),
			'display' => true,
		),
		'btn_trade_in_appraisal' => array(
			'label'   => __( 'Trade-In Appraisal Button - <span>This section will display the "Trade-In Appraisal" button.</span>', 'cardealer' ),
			'display' => true,
		),
		'post_actions'           => array(
			'label'   => __( 'Post Actions Button - <span>This section will display Add to Compare, PDF Brochure, Print, and Share buttons.</span>', 'cardealer' ),
			'display' => true,
		),
		'tabs'                   => array(
			'label'   => __( 'Tabs - <span>This section will display all tabs as accordion.</span>', 'cardealer' ),
			'display' => true,
		),
		'related_vehicles'       => array(
			'label'   => __( 'Related Vehicles - <span>This section will display  related vehicles.</span>', 'cardealer' ),
			'display' => true,
		),
		'sidebar_widgets'        => array(
			'label'   => __( 'Sidebar Widgets - <span>This section will display sidebar widgets.</span>', 'cardealer' ),
			'display' => true,
		),
	);

	$sections = apply_filters( 'cardealer_vehicle_detail_page_sections', $sections );

	if ( 'options' === $return ) {
		$sections = array_map( function( $section_data ) {
			return $section_data['label'];
		}, $sections );
	} elseif ( 'defaults' === $return ) {
		$sections = array_map( function( $section_data ) {
			return ( isset( $section_data['display'] ) ? filter_var( $section_data['display'], FILTER_VALIDATE_BOOLEAN ) : false );
		}, $sections );
	}

	return $sections;
}

function cardealer_vehicle_detail_page_render_mobile_sections() {
	global $car_dealer_options, $post;

	$sections   = cardealer_get_vehicle_detail_page_sections();
	$selected   = cardealer_get_vehicle_detail_page_sections( 'defaults' );
	$option_key = 'vehicle_detail_mobile_sections';

	if ( isset( $car_dealer_options[ $option_key ] ) && is_array( $car_dealer_options[ $option_key ] ) && ! empty( $car_dealer_options[ $option_key ] ) ) {
		$selected = filter_var_array( $car_dealer_options[ $option_key ], FILTER_VALIDATE_BOOLEAN );
	}

	if ( is_array( $selected ) && ! empty( $selected ) ) {
		?>
		<div class="detail-sections">
			<?php
			foreach ( $selected as $section => $section_status ) {
				if ( true === $section_status ) {
					if ( isset( $sections[ $section ] ) && ! empty( $sections[ $section ] ) && apply_filters( 'cardealer_vehicle_detail_page_section_enabled', true, $section, $post ) ) {
						$section_slug  = sanitize_file_name( sanitize_title( str_replace( '_', '-', $section ) ) );
						$section_class = "detail-section detail-section-$section_slug";

						do_action( 'cardealer_vehicle_detail_page_render_mobile_sections_before_section', $section, $post );
						?>
						<div class="<?php echo esc_attr( $section_class ); ?>">
							<?php
							do_action( 'cardealer_vehicle_detail_page_render_mobile_sections_inside_section_before', $section, $post );
							$section_data = $sections[ $section ];
							if ( isset( $section_data['callback'] ) && is_callable( $section_data['callback'] ) ) {
								call_user_func( $section_data['callback'], $section, $section_data );
							} else {

								get_template_part( 'template-parts/cars/single-car/sections/' . $section_slug );
							}
							do_action( 'cardealer_vehicle_detail_page_render_mobile_sections_inside_section_after', $section, $post );
							?>
						</div>
						<?php
						do_action( 'cardealer_vehicle_detail_page_render_mobile_sections_after_section', $section, $post );
					}
				}
			}
			?>
		</div>
		<?php
	}
}

function cardealer_vehicle_detail_page_section_enabled( $status, $section, $post ) {
	global $car_dealer_options;

	if ( 'btn_buy_online' === $section ) {
		$status = cardealer_is_vehicle_sellable( $post->ID );
	}
	if ( 'btn_request_more_info' === $section ) {
		if (
			! isset( $car_dealer_options['req_info_form_status'] ) // Option NOT set
			|| ( false === filter_var( $car_dealer_options['req_info_form_status'], FILTER_VALIDATE_BOOLEAN ) ) // Form Disabled
			|| ( // Form Enable, CF7 Enabled, AND CF7 shortcode NOT set OR empty
				true === filter_var( $car_dealer_options['req_info_form_status'], FILTER_VALIDATE_BOOLEAN )
				&& ( isset( $car_dealer_options['req_info_contact_7'] ) && true === filter_var( $car_dealer_options['req_info_contact_7'], FILTER_VALIDATE_BOOLEAN ) )
				&& ( ! isset( $car_dealer_options['req_info_form'] ) || empty( $car_dealer_options['req_info_form'] ) )
			)
		) {
			$status = false;
		}
	}
	if ( 'btn_make_an_offer' === $section ) {
		if (
			! isset( $car_dealer_options['make_offer_form_status'] ) // Option NOT set
			|| ( false === filter_var( $car_dealer_options['make_offer_form_status'], FILTER_VALIDATE_BOOLEAN ) ) // Form Disabled
			|| ( // Form Enable, CF7 Enabled, AND CF7 shortcode NOT set OR empty
				true === filter_var( $car_dealer_options['make_offer_form_status'], FILTER_VALIDATE_BOOLEAN )
				&& ( isset( $car_dealer_options['make_offer_contact_7'] ) && true === filter_var( $car_dealer_options['make_offer_contact_7'], FILTER_VALIDATE_BOOLEAN ) )
				&& ( ! isset( $car_dealer_options['make_offer_form'] ) || empty( $car_dealer_options['make_offer_form'] ) )
			)
		) {
			$status = false;
		}
	}
	if ( 'btn_schedule_test_drive' === $section ) {
		if (
			! isset( $car_dealer_options['schedule_drive_form_status'] ) // Option NOT set
			|| ( false === filter_var( $car_dealer_options['schedule_drive_form_status'], FILTER_VALIDATE_BOOLEAN ) ) // Form Disabled
			|| ( // Form Enable, CF7 Enabled, AND CF7 shortcode NOT set OR empty
				true === filter_var( $car_dealer_options['schedule_drive_form_status'], FILTER_VALIDATE_BOOLEAN )
				&& ( isset( $car_dealer_options['schedule_drive_contact_7'] ) && true === filter_var( $car_dealer_options['schedule_drive_contact_7'], FILTER_VALIDATE_BOOLEAN ) )
				&& ( ! isset( $car_dealer_options['schedule_drive_form'] ) || empty( $car_dealer_options['schedule_drive_form'] ) )
			)
		) {
			$status = false;
		}
	}
	if ( 'btn_email_to_friend' === $section ) {
		if (
			! isset( $car_dealer_options['email_friend_form_status'] ) // Option NOT set
			|| ( false === filter_var( $car_dealer_options['email_friend_form_status'], FILTER_VALIDATE_BOOLEAN ) ) // Form Disabled
			|| ( // Form Enable, CF7 Enabled, AND CF7 shortcode NOT set OR empty
				true === filter_var( $car_dealer_options['email_friend_form_status'], FILTER_VALIDATE_BOOLEAN )
				&& ( isset( $car_dealer_options['email_friend_contact_7'] ) && true === filter_var( $car_dealer_options['email_friend_contact_7'], FILTER_VALIDATE_BOOLEAN ) )
				&& ( ! isset( $car_dealer_options['email_friend_form'] ) || empty( $car_dealer_options['email_friend_form'] ) )
			)
		) {
			$status = false;
		}
	}
	if ( 'btn_financial_form' === $section ) {
		if (
			! isset( $car_dealer_options['financial_form_status'] ) // Option NOT set
			|| ( false === filter_var( $car_dealer_options['financial_form_status'], FILTER_VALIDATE_BOOLEAN ) ) // Form Disabled
			|| ( // Form Enable, CF7 Enabled, AND CF7 shortcode NOT set OR empty
				true === filter_var( $car_dealer_options['financial_form_status'], FILTER_VALIDATE_BOOLEAN )
				&& ( isset( $car_dealer_options['financial_form_contact_7'] ) && true === filter_var( $car_dealer_options['financial_form_contact_7'], FILTER_VALIDATE_BOOLEAN ) )
				&& ( ! isset( $car_dealer_options['financial_form'] ) || empty( $car_dealer_options['financial_form'] ) )
			)
		) {
			$status = false;
		}
	}
	if ( 'btn_trade_in_appraisal' === $section ) {
		if (
			! isset( $car_dealer_options['trade_in_appraisal_form_status'] ) // Option NOT set
			|| ( false === filter_var( $car_dealer_options['trade_in_appraisal_form_status'], FILTER_VALIDATE_BOOLEAN ) ) // Form Disabled
			|| ( ! isset( $car_dealer_options['trade_in_appraisal_form_cf7_shortcode'] ) || empty( $car_dealer_options['trade_in_appraisal_form_cf7_shortcode'] ) ) // CF7 shortcode NOT set OR empty
		) {
			$status = false;
		}
	}
	return $status;
}

function cardealer_vehicle_listing_page_mobile_filters() {
	$filter_location = cardealer_vehicle_listing_mobile_filter_location();

	if ( 'off-canvas' === $filter_location ) {
		cardealer_get_offcanvas();
	} else {
		?>
		<div class="col-sm-12">
			<div class="mobile-vehicle-filters-wrap">
				<?php cardealer_widget_area__listing_cars(); ?>
			</div>
		</div>
		<?php
	}
}

function cardealer_widget_area__listing_cars() {
	if ( is_active_sidebar( 'listing-cars' ) ) {
		?>
		<div class="listing-sidebar sidebar">
			<?php dynamic_sidebar( 'listing-cars' ); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'cardealer_get_offcanvas' ) ) {
	/**
	 * Get off-canvas content.
	 *
	 * @since 3.4.0
	 *
	 * @return string.
	 */
	function cardealer_get_offcanvas() {
		?>
		<aside class="cardealer-offcanvas cardealer-offcanvas-left is-closed">
			<a href="#" class="cardealer-offcanvas-close-btn"><?php esc_html_e( 'Close', 'cardealer' ); ?></a>
			<div class="cardealer-offcanvas-content">
				<?php
				/**
				 * Fires before the off-canvas content.
				 *
				 * @since 3.4.0
				 */
				do_action( 'cardealer_before_offcanvas' );

				do_action( 'cardealer_offcanvas' );

				/**
				 * Fires after the off-canvas content.
				 *
				 * @since 3.4.0
				 */
				do_action( 'cardealer_after_offcanvas' );
				?>
			</div>
		</aside>
		<div class="cardealer-offcanvas-overlay is-closed"></div>
		<?php
	}
}

function cardealer_vehicle_list_mobile_view_type( $cars_grid ) {
	if ( wp_is_mobile() ) {
		$cars_grid = 'yes';
	}
	return $cars_grid;
}

/**
 * Vehicle detail page tabs functions.
 */
if ( ! function_exists( 'cardealer_get_lead_form' ) ) {

	/**
	 * List of lead forms.
	 *
	 * @param string $lead_form   Name of lead form.
	 * @return array
	 */
	function cardealer_get_lead_form( $lead_form = '' ) {
		$return = false;

		$lead_forms_defaults = array(
			'req_more_info' => array(
				'btn_label'   => cardealer_get_theme_option( 'lead_form_req_more_info_btn_label', esc_html__( 'Request More Info', 'cardealer' ) ),
				'modal_title' => cardealer_get_theme_option( 'lead_form_req_more_info_modal_title', esc_html__( 'Request More Info', 'cardealer' ) ),
				'icon'        => 'fas fa-question-circle',
			),
			'make_an_offer' => array(
				'btn_label'   => cardealer_get_theme_option( 'lead_form_make_an_offer_btn_label', esc_html__( 'Make an Offer', 'cardealer' ) ),
				'modal_title' => cardealer_get_theme_option( 'lead_form_make_an_offer_modal_title', esc_html__( 'Make an Offer', 'cardealer' ) ),
				'icon'        => 'fas fa-tag',
			),
			'schedule_test_drive' => array(
				'btn_label'   => cardealer_get_theme_option( 'lead_form_schedule_test_drive_btn_label', esc_html__( 'Schedule Test Drive', 'cardealer' ) ),
				'modal_title' => cardealer_get_theme_option( 'lead_form_schedule_test_drive_modal_title', esc_html__( 'Schedule Test Drive', 'cardealer' ) ),
				'icon'        => 'fas fa-tachometer-alt',
			),
			'email_to_friend' => array(
				'btn_label'   => cardealer_get_theme_option( 'lead_form_email_to_friend_btn_label', esc_html__( 'Email to a Friend', 'cardealer' ) ),
				'modal_title' => cardealer_get_theme_option( 'lead_form_email_to_friend_modal_title', esc_html__( 'Email to a Friend', 'cardealer' ) ),
				'icon'        => 'fas fa-envelope',
			),
			'financial_form' => array(
				'btn_label'   => cardealer_get_theme_option( 'lead_form_financial_form_btn_label', esc_html__( 'Financial Form', 'cardealer' ) ),
				'modal_title' => cardealer_get_theme_option( 'lead_form_financial_form_modal_title', esc_html__( 'Financial Form', 'cardealer' ) ),
				'icon'        => 'far fa-file-alt',
			),
			'trade_in_appraisal' => array(
				'btn_label'   => cardealer_get_theme_option( 'lead_form_trade_in_appraisal_btn_label', esc_html__( 'Trade-In Appraisal', 'cardealer' ) ),
				'modal_title' => cardealer_get_theme_option( 'lead_form_trade_in_appraisal_modal_title', esc_html__( 'Trade-In Appraisal', 'cardealer' ) ),
				'icon'        => 'fas fa-exchange-alt',
			),
		);

		$lead_forms = apply_filters( 'cardealer_get_lead_form', $lead_forms_defaults );

		if ( isset( $lead_forms[ $lead_form ] ) ) {
			$return = $lead_forms[ $lead_form ];
		} elseif ( isset( $lead_forms_defaults[ $lead_form ] ) ) {
			$return = $lead_forms_defaults[ $lead_form ];
		}

		return $return;
	}
}
