<?php
/**
 * Car tab
 *
 * @author  TeamWP @Potenza Global Solutions
 * @package car-dealer-helper
 */

function cdhl_generate_core_acf_attr_fields() {

	global $car_dealer_options;

	$review_stamp_limit = isset( $car_dealer_options['review_stamp_limit'] ) ? $car_dealer_options['review_stamp_limit'] : 1;

	$core_acf_attr_field_tab = apply_filters(
		'cardealer_acf_core_attr_field_tab',
		array (
			array (
				'key'              => 'field_588f325719c26',
				'label'            => esc_html__( 'Attributes', 'cardealer-helper' ),
				'name'             => '',
				'type'             => 'tab',
				'instructions'     => '',
				'required'         => 0,
				'conditional_logic'=> 0,
				'wrapper'          => array (
					'width' => '',
					'class' => 'acf_field_name-attributes',
					'id'    => '',
				),
				'placement' => 'left',
				'endpoint'  => 0,
			)
		)
	);

	$core_acf_attr_field_array = apply_filters(
		'cardealer_acf_core_attr_field_array',
		array(
			array(
				"key"          => "field_60e41b21f6804",
				"label"        => esc_html__('Core Attributes','cardealer-helper'),
				"name"         => "",
				"type"         => "message",
				"instructions" => "",
				"required"     => 0,
				"conditional_logic" => 0,
				"wrapper"      => array(
					"width"    => "",
					"class"    => "",
					"id"       => ""
				),
				"message"      => "",
				"new_lines"    => "wpautop",
				"esc_html"     => 0
			),
			array(
				'key'               => 'field_588f336aabaa6',
				'label'             => esc_html( ( $label = cardealer_get_field_label_with_tax_key('car_year') ) ? $label : esc_html__( 'Year', 'cardealer-helper' ) ),
				'name'              => 'year',
				'type'              => 'taxonomy',
				'instructions'      => sprintf(
					/* Translators: %1$s Link to attributes panel. */
					wp_kses( __( 'Click <a href="%1$s" target="_blank">here</a> to manage attribute items.', 'cardealer-helper' ), cardealer_allowed_html( 'a' ) ),
					esc_url( add_query_arg( array( 'post_type' => 'cars', 'taxonomy'  => 'car_year' ), admin_url( 'edit-tags.php' ) ) )
				),
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-year',
					'id'    => '',
				),
				'taxonomy'          => 'car_year',
				'field_type'        => 'select',
				'multiple'          => 0,
				'allow_null'        => 1,
				'return_format'     => 'id',
				'add_term'          => 1,
				'load_terms'        => 1,
				'save_terms'        => 1,
			),
			array(
				'key'               => 'field_588f3b69b836f',
				'label'             => esc_html( ( $label = cardealer_get_field_label_with_tax_key('car_make') ) ? $label : esc_html__( 'Make', 'cardealer-helper' ) ),
				'name'              => 'make',
				'type'              => 'taxonomy',
				'instructions'      => sprintf(
					/* Translators: %1$s Link to attributes panel. */
					wp_kses( __( 'Click <a href="%1$s" target="_blank">here</a> to manage attribute items.', 'cardealer-helper' ), cardealer_allowed_html( 'a' ) ),
					esc_url( add_query_arg( array( 'post_type' => 'cars', 'taxonomy'  => 'car_make' ), admin_url( 'edit-tags.php' ) ) )
				),
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-make',
					'id'    => '',
				),
				'taxonomy'          => 'car_make',
				'field_type'        => 'select',
				'multiple'          => 0,
				'allow_null'        => 1,
				'return_format'     => 'id',
				'add_term'          => 1,
				'load_terms'        => 1,
				'save_terms'        => 1,
			),
			array(
				'key'               => 'field_588f3478c01ca',
				'label'             => esc_html( ( $label = cardealer_get_field_label_with_tax_key('car_model') ) ? $label : esc_html__( 'Model', 'cardealer-helper' ) ),
				'name'              => 'model',
				'type'              => 'taxonomy',
				'instructions'      => sprintf(
					/* Translators: %1$s Link to attributes panel. */
					wp_kses( __( 'Click <a href="%1$s" target="_blank">here</a> to manage attribute items.', 'cardealer-helper' ), cardealer_allowed_html( 'a' ) ),
					esc_url( add_query_arg( array( 'post_type' => 'cars', 'taxonomy'  => 'car_model' ), admin_url( 'edit-tags.php' ) ) )
				),
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-model',
					'id'    => '',
				),
				'taxonomy'          => 'car_model',
				'field_type'        => 'select',
				'multiple'          => 0,
				'allow_null'        => 1,
				'return_format'     => 'id',
				'add_term'          => 1,
				'load_terms'        => 1,
				'save_terms'        => 1,
			),
			array(
				'key'               => 'field_588f3d44b8378',
				'label'             => esc_html( ( $label = cardealer_get_field_label_with_tax_key('car_stock_number') ) ? $label : esc_html__( 'Stock Number', 'cardealer-helper' ) ),
				'name'              => 'stock_number',
				'type'              => 'taxonomy',
				'instructions'      => sprintf(
					/* Translators: %1$s Link to attributes panel. */
					wp_kses( __( 'Click <a href="%1$s" target="_blank">here</a> to manage attribute items.', 'cardealer-helper' ), cardealer_allowed_html( 'a' ) ),
					esc_url( add_query_arg( array( 'post_type' => 'cars', 'taxonomy'  => 'car_stock_number' ), admin_url( 'edit-tags.php' ) ) )
				),
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-stock_number',
					'id'    => '',
				),
				'taxonomy'          => 'car_stock_number',
				'field_type'        => 'select',
				'multiple'          => 0,
				'allow_null'        => 1,
				'return_format'     => 'id',
				'add_term'          => 1,
				'load_terms'        => 1,
				'save_terms'        => 1,
			),
			array(
				'key'               => 'field_588f3dbfb8379',
				'label'             => esc_html( ( $label = cardealer_get_field_label_with_tax_key('car_vin_number') ) ? $label : esc_html__( 'VIN Number', 'cardealer-helper' ) ),
				'name'              => 'vin_number',
				'type'              => 'taxonomy',
				'instructions'      => sprintf(
					/* Translators: %1$s Link to attributes panel. */
					wp_kses( __( 'Click <a href="%1$s" target="_blank">here</a> to manage attribute items.', 'cardealer-helper' ), cardealer_allowed_html( 'a' ) ),
					esc_url( add_query_arg( array( 'post_type' => 'cars', 'taxonomy'  => 'car_vin_number' ), admin_url( 'edit-tags.php' ) ) )
				)
				. '<br>' . wp_kses( __( '<strong>IMPORTANT: </strong>We recommend that you should provide VIN Number. We considered VIN Number as uniq entity in import process. So if you donot enter VIN Number, then duplicate entry may occur during import process.', 'cardealer-helper' ), array( 'strong' => array() ) ),
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-vin_number',
					'id'    => '',
				),
				'taxonomy'          => 'car_vin_number',
				'field_type'        => 'select',
				'multiple'          => 0,
				'allow_null'        => 1,
				'return_format'     => 'id',
				'add_term'          => 1,
				'load_terms'        => 1,
				'save_terms'        => 1,
			),
			array(
				'key'               => 'field_59071ef8356ec',
				'label'             => esc_html( ( $label = cardealer_get_field_label_with_tax_key('car_trim') ) ? $label : esc_html__( 'Trim', 'cardealer-helper' ) ),
				'name'              => 'trim',
				'type'              => 'taxonomy',
				'instructions'      => sprintf(
					/* Translators: %1$s Link to attributes panel. */
					wp_kses( __( 'Click <a href="%1$s" target="_blank">here</a> to manage attribute items.', 'cardealer-helper' ), cardealer_allowed_html( 'a' ) ),
					esc_url( add_query_arg( array( 'post_type' => 'cars', 'taxonomy'  => 'car_trim' ), admin_url( 'edit-tags.php' ) ) )
				),
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-trim',
					'id'    => '',
				),
				'taxonomy'          => 'car_trim',
				'field_type'        => 'select',
				'allow_null'        => 1,
				'add_term'          => 1,
				'save_terms'        => 1,
				'load_terms'        => 1,
				'return_format'     => 'id',
				'multiple'          => 0,
			),
			array(
				'key'               => 'field_588f3c34b8372',
				'label'             => esc_html( ( $label = cardealer_get_field_label_with_tax_key('car_condition') ) ? $label : esc_html__( 'Condition', 'cardealer-helper' ) ),
				'name'              => 'condition',
				'type'              => 'taxonomy',
				'instructions'      => sprintf(
					/* Translators: %1$s Link to attributes panel. */
					wp_kses( __( 'Click <a href="%1$s" target="_blank">here</a> to manage attribute items.', 'cardealer-helper' ), cardealer_allowed_html( 'a' ) ),
					esc_url( add_query_arg( array( 'post_type' => 'cars', 'taxonomy'  => 'car_condition' ), admin_url( 'edit-tags.php' ) ) )
				),
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-condition',
					'id'    => '',
				),
				'taxonomy'          => 'car_condition',
				'field_type'        => 'select',
				'multiple'          => 0,
				'allow_null'        => 1,
				'return_format'     => 'id',
				'add_term'          => 1,
				'load_terms'        => 1,
				'save_terms'        => 1,
			),
			array(
				'key'               => 'field_58903183b5d5f',
				'label'             => esc_html( ( $label = cardealer_get_field_label_with_tax_key('car_body_style') ) ? $label : esc_html__( 'Body Style', 'cardealer-helper' ) ),
				'name'              => 'body_style',
				'type'              => 'taxonomy',
				'instructions'      => sprintf(
					/* Translators: %1$s Link to attributes panel. */
					wp_kses( __( 'Click <a href="%1$s" target="_blank">here</a> to manage attribute items.', 'cardealer-helper' ), cardealer_allowed_html( 'a' ) ),
					esc_url( add_query_arg( array( 'post_type' => 'cars', 'taxonomy'  => 'car_body_style' ), admin_url( 'edit-tags.php' ) ) )
				),
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-body_style',
					'id'    => '',
				),
				'taxonomy'          => 'car_body_style',
				'field_type'        => 'select',
				'multiple'          => 0,
				'allow_null'        => 1,
				'return_format'     => 'id',
				'add_term'          => 1,
				'load_terms'        => 1,
				'save_terms'        => 1,
			),
			array(
				'key'               => 'field_588f3bf4b8371',
				'label'             => esc_html( ( $label = cardealer_get_field_label_with_tax_key('car_transmission') ) ? $label : esc_html__( 'Transmission', 'cardealer-helper' ) ),
				'name'              => 'transmission',
				'type'              => 'taxonomy',
				'instructions'      => sprintf(
					/* Translators: %1$s Link to attributes panel. */
					wp_kses( __( 'Click <a href="%1$s" target="_blank">here</a> to manage attribute items.', 'cardealer-helper' ), cardealer_allowed_html( 'a' ) ),
					esc_url( add_query_arg( array( 'post_type' => 'cars', 'taxonomy'  => 'car_transmission' ), admin_url( 'edit-tags.php' ) ) )
				),
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-transmission',
					'id'    => '',
				),
				'taxonomy'          => 'car_transmission',
				'field_type'        => 'select',
				'multiple'          => 0,
				'allow_null'        => 1,
				'return_format'     => 'id',
				'add_term'          => 1,
				'load_terms'        => 1,
				'save_terms'        => 1,
			),
			array(
				'key'               => 'field_588f3c72b8374',
				'label'             => esc_html( ( $label = cardealer_get_field_label_with_tax_key('car_engine') ) ? $label : esc_html__( 'Engine', 'cardealer-helper' ) ),
				'name'              => 'engine',
				'type'              => 'taxonomy',
				'instructions'      => sprintf(
					/* Translators: %1$s Link to attributes panel. */
					wp_kses( __( 'Click <a href="%1$s" target="_blank">here</a> to manage attribute items.', 'cardealer-helper' ), cardealer_allowed_html( 'a' ) ),
					esc_url( add_query_arg( array( 'post_type' => 'cars', 'taxonomy'  => 'car_engine' ), admin_url( 'edit-tags.php' ) ) )
				),
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-engine',
					'id'    => '',
				),
				'taxonomy'          => 'car_engine',
				'field_type'        => 'select',
				'multiple'          => 0,
				'allow_null'        => 1,
				'return_format'     => 'id',
				'add_term'          => 1,
				'load_terms'        => 1,
				'save_terms'        => 1,
			),
			array(
				'key'               => 'field_588f3c52b8373',
				'label'             => esc_html( ( $label = cardealer_get_field_label_with_tax_key('car_drivetrain') ) ? $label : esc_html__( 'Drivetrain', 'cardealer-helper' ) ),
				'name'              => 'drivetrain',
				'type'              => 'taxonomy',
				'instructions'      => sprintf(
					/* Translators: %1$s Link to attributes panel. */
					wp_kses( __( 'Click <a href="%1$s" target="_blank">here</a> to manage attribute items.', 'cardealer-helper' ), cardealer_allowed_html( 'a' ) ),
					esc_url( add_query_arg( array( 'post_type' => 'cars', 'taxonomy'  => 'car_drivetrain' ), admin_url( 'edit-tags.php' ) ) )
				),
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-drivetrain',
					'id'    => '',
				),
				'taxonomy'          => 'car_drivetrain',
				'field_type'        => 'select',
				'multiple'          => 0,
				'allow_null'        => 1,
				'return_format'     => 'id',
				'add_term'          => 1,
				'load_terms'        => 1,
				'save_terms'        => 1,
			),
			array(
				'key'               => 'field_59071e45356eb',
				'label'             => esc_html( ( $label = cardealer_get_field_label_with_tax_key('car_fuel_type') ) ? $label : esc_html__( 'Fuel Type', 'cardealer-helper' ) ),
				'name'              => 'fuel_type',
				'type'              => 'taxonomy',
				'instructions'      => sprintf(
					/* Translators: %1$s Link to attributes panel. */
					wp_kses( __( 'Click <a href="%1$s" target="_blank">here</a> to manage attribute items.', 'cardealer-helper' ), cardealer_allowed_html( 'a' ) ),
					esc_url( add_query_arg( array( 'post_type' => 'cars', 'taxonomy'  => 'car_fuel_type' ), admin_url( 'edit-tags.php' ) ) )
				),
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-fuel_type acf_field_name-fuel_type',
					'id'    => '',
				),
				'taxonomy'          => 'car_fuel_type',
				'field_type'        => 'select',
				'allow_null'        => 1,
				'add_term'          => 1,
				'save_terms'        => 1,
				'load_terms'        => 1,
				'return_format'     => 'id',
				'multiple'          => 0,
			),
			array(
				'key'               => 'field_588f3c8cb8375',
				'label'             => esc_html( ( $label = cardealer_get_field_label_with_tax_key('car_fuel_economy') ) ? $label : esc_html__( 'Fuel Economy', 'cardealer-helper' ) ),
				'name'              => 'fuel_economy',
				'type'              => 'taxonomy',
				'instructions'      => sprintf(
					/* Translators: %1$s Link to attributes panel. */
					wp_kses( __( 'Click <a href="%1$s" target="_blank">here</a> to manage attribute items.', 'cardealer-helper' ), cardealer_allowed_html( 'a' ) ),
					esc_url( add_query_arg( array( 'post_type' => 'cars', 'taxonomy'  => 'car_fuel_economy' ), admin_url( 'edit-tags.php' ) ) )
				),
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-fuel_economy',
					'id'    => '',
				),
				'taxonomy'          => 'car_fuel_economy',
				'field_type'        => 'select',
				'allow_null'        => 1,
				'add_term'          => 1,
				'save_terms'        => 1,
				'load_terms'        => 1,
				'return_format'     => 'id',
				'multiple'          => 0,
			),
			array(
				'key'               => 'field_588f3bc5b8370',
				'label'             => esc_html( ( $label = cardealer_get_field_label_with_tax_key('car_mileage') ) ? $label : esc_html__( 'Mileage', 'cardealer-helper' ) ),
				'name'              => 'mileage',
				'type'              => 'taxonomy',
				'instructions'      => sprintf(
					/* Translators: %1$s Link to attributes panel. */
					wp_kses( __( 'Click <a href="%1$s" target="_blank">here</a> to manage attribute items.', 'cardealer-helper' ), cardealer_allowed_html( 'a' ) ),
					esc_url( add_query_arg( array( 'post_type' => 'cars', 'taxonomy'  => 'car_mileage' ), admin_url( 'edit-tags.php' ) ) )
				),
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-mileage',
					'id'    => '',
				),
				'taxonomy'          => 'car_mileage',
				'field_type'        => 'select',
				'multiple'          => 0,
				'allow_null'        => 1,
				'return_format'     => 'id',
				'add_term'          => 1,
				'load_terms'        => 1,
				'save_terms'        => 1,
			),
			array(
				'key'               => 'field_588f3cb6b8376',
				'label'             => esc_html( ( $label = cardealer_get_field_label_with_tax_key('car_exterior_color') ) ? $label : esc_html__( 'Exterior Color', 'cardealer-helper' ) ),
				'name'              => 'exterior_color',
				'type'              => 'taxonomy',
				'instructions'      => sprintf(
					/* Translators: %1$s Link to attributes panel. */
					wp_kses( __( 'Click <a href="%1$s" target="_blank">here</a> to manage attribute items.', 'cardealer-helper' ), cardealer_allowed_html( 'a' ) ),
					esc_url( add_query_arg( array( 'post_type' => 'cars', 'taxonomy'  => 'car_exterior_color' ), admin_url( 'edit-tags.php' ) ) )
				),
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-exterior_color',
					'id'    => '',
				),
				'taxonomy'          => 'car_exterior_color',
				'field_type'        => 'select',
				'multiple'          => 0,
				'allow_null'        => 1,
				'return_format'     => 'id',
				'add_term'          => 1,
				'load_terms'        => 1,
				'save_terms'        => 1,
			),
			array(
				'key'               => 'field_588f3d25b8377',
				'label'             => esc_html( ( $label = cardealer_get_field_label_with_tax_key('car_interior_color') ) ? $label : esc_html__( 'Interior Color', 'cardealer-helper' ) ),
				'name'              => 'interior_color',
				'type'              => 'taxonomy',
				'instructions'      => sprintf(
					/* Translators: %1$s Link to attributes panel. */
					wp_kses( __( 'Click <a href="%1$s" target="_blank">here</a> to manage attribute items.', 'cardealer-helper' ), cardealer_allowed_html( 'a' ) ),
					esc_url( add_query_arg( array( 'post_type' => 'cars', 'taxonomy'  => 'car_interior_color' ), admin_url( 'edit-tags.php' ) ) )
				),
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-interior_color',
					'id'    => '',
				),
				'taxonomy'          => 'car_interior_color',
				'field_type'        => 'select',
				'multiple'          => 0,
				'allow_null'        => 1,
				'return_format'     => 'id',
				'add_term'          => 1,
				'load_terms'        => 1,
				'save_terms'        => 1,
			)
		)
	);


	/**
	 * Additional Fields
	 */
	$additional_taxes = get_taxonomies( array( 'is_additional_attribute' => true ), 'objects' );

	$additional_acf_attr_fields = array();

	if ( is_array($additional_taxes) && count($additional_taxes) > 0 ) {

		$additional_acf_attr_fields[] = array(
			"key"          => "field_0b60164e48f21",
			"label"        => esc_html__('Additional Attributes','cardealer-helper'),
			"name"         => "",
			"type"         => "message",
			"instructions" => "",
			"required"     => 0,
			"conditional_logic" => 0,
			"wrapper"      => array(
				"width"    => "",
				"class"    => "",
				"id"       => ""
			),
			"message"      => "",
			"new_lines"    => "wpautop",
			"esc_html"     => 0
		);

		foreach ( $additional_taxes as $tax_name => $tax_obj ) {
			$instructions = '';
			$tax_url = add_query_arg( array(
				'post_type' => 'cars',
				'taxonomy'  => $tax_name,
			), admin_url( 'edit-tags.php' ) );

			$instructions = sprintf(
				wp_kses(
					/* Translators: %1$s Link to attributes panel. */
					__( 'Click <a href="%1$s" target="_blank">here</a> to manage attribute items.', 'cardealer-helper' ),
					array(
						'a'      => array(
							'href'   => true,
							'target' => true,
						),
					)
				),
				esc_url( $tax_url )
			);

			$additional_acf_attr_fields[] = array (
				'key'               => 'field_' . $tax_name . '5dfb4bdad05644b3b67f9f4d3f1dac50',
				'label'             => $tax_obj->labels->singular_name,
				'name'              => 'field_additional_tax_' . $tax_name,
				'type'              => 'taxonomy',
				'instructions'      => $instructions,
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array (
					'width' => '',
					'class' => '',
					'id'    => '',
				),
				'taxonomy'      => $tax_name,
				'field_type'    => 'select',
				'multiple'      => 0,
				'allow_null'    => 1,
				'return_format' => 'id',
				'add_term'      => 1,
				'load_terms'    => 1,
				'save_terms'    => 1,
			);
		}
	}

	$additional_acf_attr_field_array = apply_filters(
		'cardealer_acf_core_attr_field_array',
		$additional_acf_attr_fields
	);

	if ( ! empty($additional_acf_attr_fields) ) {
		$args['fields'] = array_merge( $core_acf_attr_field_tab, $additional_acf_attr_field_array, $core_acf_attr_field_array );
	} else {
		$args['fields'] = array_merge( $core_acf_attr_field_tab, $core_acf_attr_field_array );
	}

	$core_acf_attr_fields = apply_filters(
		'cardealer_acf_core_attr_fields',
		$args['fields']
	);

	$vehicle_acf_images_fields = apply_filters(
		'cardealer_acf_vehicle_images_fields',
		array(
			array(
				'key'               => 'field_588f1d6463719',
				'label'             => esc_html__( 'Vehicle Images', 'cardealer-helper' ),
				'name'              => '',
				'type'              => 'tab',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-vehicle-images',
					'id'    => '',
				),
				'placement'         => 'left',
				'endpoint'          => 0,
			),
			array(
				'key'               => 'field_588f1cfb63718',
				'label'             => esc_html__( 'Vehicle Images', 'cardealer-helper' ),
				'name'              => 'car_images',
				'type'              => 'gallery',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-car_images',
					'id'    => '',
				),
				'library'           => 'all',
				'min'               => '',
				'max'               => '',
				'min_width'         => '',
				'min_height'        => '',
				'min_size'          => '',
				'max_width'         => '',
				'max_height'        => '',
				'max_size'          => '',
				'mime_types'        => '',
				'insert'            => 'append',
			)
		)
	);


	$vehicle_acf_price_fields = apply_filters(
		'cardealer_acf_vehicle_price_fields',
		array(
			array(
				'key'               => 'field_588f1fd05c12e',
				'label'             => esc_html__( 'Regular price', 'cardealer-helper' ),
				'name'              => '',
				'type'              => 'tab',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-regular-price',
					'id'    => '',
				),
				'placement'         => 'left',
				'endpoint'          => 0,
			),
			array(
				'key'               => 'field_588f20535c12f',
				'label'             => esc_html__( 'Regular price', 'cardealer-helper' ),
				'name'              => 'regular_price',
				'type'              => 'number',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-regular_price',
					'id'    => '',
				),
				'default_value'     => '',
				'min'               => '',
				'max'               => '',
				'step'              => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
			),
			array(
				'key'               => 'field_588f205d5c130',
				'label'             => esc_html__( 'Sale price', 'cardealer-helper' ),
				'name'              => 'sale_price',
				'type'              => 'number',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-sale_price',
					'id'    => '',
				),
				'default_value'     => '',
				'min'               => '',
				'max'               => '',
				'step'              => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
			)
		)
	);

	$vehicle_acf_tax_label_fields = apply_filters(
		'cardealer_acf_vehicle_tax_label_fields',
		array(
			array(
				'key'               => 'field_5894116f47f97',
				'label'             => esc_html__( 'Tax Label', 'cardealer-helper' ),
				'name'              => '',
				'type'              => 'tab',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-tax-label-tab',
					'id'    => '',
				),
				'placement'         => 'left',
				'endpoint'          => 0,
			),
			array(
				'key'               => 'field_589410fd47f96',
				'label'             => esc_html__( 'Tax Label', 'cardealer-helper' ),
				'name'              => 'tax_label',
				'type'              => 'text',
				'instructions'      => esc_html__( 'Tax Label (below the price) on Listing Page.', 'cardealer-helper' ),
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-tax_label',
					'id'    => '',
				),
				'default_value'     => '',
				'maxlength'         => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
			)
		)
	);


	$vehicle_acf_fuel_efficiency_fields = apply_filters(
		'cardealer_acf_vehicle_fuel_efficiency_fields',
		array(
			array(
				'key'               => 'field_588f21725c132',
				'label'             => esc_html__( 'Fuel Efficiency', 'cardealer-helper' ),
				'name'              => '',
				'type'              => 'tab',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-fuel-efficiency',
					'id'    => '',
				),
				'placement'         => 'left',
				'endpoint'          => 0,
			),
			array(
				'key'               => 'field_588f217f5c133',
				'label'             => esc_html__( 'City MPG', 'cardealer-helper' ),
				'name'              => 'city_mpg',
				'type'              => 'number',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-city_mpg',
					'id'    => '',
				),
				'default_value'     => '',
				'min'               => '',
				'max'               => '',
				'step'              => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
			),
			array(
				'key'               => 'field_588f21a75c134',
				'label'             => esc_html__( 'Highway MPG', 'cardealer-helper' ),
				'name'              => 'highway_mpg',
				'type'              => 'number',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-highway_mpg',
					'id'    => '',
				),
				'default_value'     => '',
				'min'               => '',
				'max'               => '',
				'step'              => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
			),
		)
	);

	$vehicle_acf_brochure_upload_fields = apply_filters(
		'cardealer_acf_vehicle_brochure_upload_fields',
		array(
			array(
				'key'               => 'field_588f23848a25d',
				'label'             => esc_html__( 'Brochure Upload', 'cardealer-helper' ),
				'name'              => '',
				'type'              => 'tab',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-brochure-upload',
					'id'    => '',
				),
				'placement'         => 'left',
				'endpoint'          => 0,
			),
			array(
				'key'               => 'field_588f23918a25e',
				'label'             => esc_html__( 'Brochure', 'cardealer-helper' ),
				'name'              => 'pdf_file',
				'type'              => 'file',
				'instructions'      => esc_html__( 'Upload brochure here in PDF format only.', 'cardealer-helper' ),
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-pdf_file',
					'id'    => '',
				),
				'return_format'     => 'array',
				'library'           => 'all',
				'min_size'          => '',
				'max_size'          => '',
				'mime_types'        => 'pdf',
			),
		)
	);

	$vehicle_acf_video_link_fields = apply_filters(
		'cardealer_acf_vehicle_video_link_fiels',
		array(
			array(
				'key'               => 'field_588f245127b5f',
				'label'             => esc_html__( 'Video', 'cardealer-helper' ),
				'name'              => '',
				'type'              => 'tab',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-video',
					'id'    => '',
				),
				'placement'         => 'left',
				'endpoint'          => 0,
			),
			array(
				'key'               => 'field_588f246427b60',
				'label'             => esc_html__( 'Video Link', 'cardealer-helper' ),
				'name'              => 'video_link',
				'type'              => 'url',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-video_link',
					'id'    => '',
				),
				'default_value'     => '',
				'placeholder'       => '',
			)
		)
	);

	$vehicle_acf_status_fields = apply_filters(
		'cardealer_acf_vehicle_status_fields',
		array(
			array(
				'key'               => 'field_590720a5e74bc',
				'label'             => esc_html__( 'Vehicle Status', 'cardealer-helper' ),
				'name'              => '',
				'type'              => 'tab',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-vehicle-status',
					'id'    => '',
				),
				'placement'         => 'left',
				'endpoint'          => 0,
			),
			array(
				'key'               => 'field_59071f59356ed',
				'label'             => esc_html__( 'Vehicle Status', 'cardealer-helper' ),
				'name'              => 'car_status',
				'type'              => 'radio',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => array(
					'width' => '',
					'class' => 'acf_field_name-car_status',
					'id'    => '',
				),
				'choices'           => array(
					'sold'   => esc_html__( 'Sold', 'cardealer-helper' ),
					'unsold' => esc_html__( 'UnSold', 'cardealer-helper' ),
				),
				'allow_null'        => 0,
				'other_choice'      => 0,
				'save_other_choice' => 0,
				'default_value'     => 'unsold',
				'layout'            => 'horizontal',
				'return_format'     => 'value',
			),
		)
	);

	$review_stamp_acf_fields_array = array(
		array(
			array(
				'key' => 'field_60dab8d20cfa7',
				'label' => 'Review Stamp Logo 1',
				'name' => 'review_stamp_logo_1',
				'type' => 'image',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'array',
				'preview_size' => 'medium',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
			),
			array(
				'key' => 'field_60dab9600cfa8',
				'label' => 'Review Stamp Link 1',
				'name' => 'review_stamp_link_1',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
		),
		array(
			array(
				'key' => 'field_60dab96b0cfa9',
				'label' => 'Review Stamp Logo 2',
				'name' => 'review_stamp_logo_2',
				'type' => 'image',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'array',
				'preview_size' => 'medium',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
			),
			array(
				'key' => 'field_60dab9840cfaa',
				'label' => 'Review Stamp Link 2',
				'name' => 'review_stamp_link_2',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
		)
	);

	$cardealer_review_stamp_acf_fields_array = apply_filters(
		'cardealer_review_stamp_acf_fields_array', $review_stamp_acf_fields_array
	);


	$generate_review_stamp_acf_fields[] = array(
		'key'               => 'field_5950c15c3bb72',
		'label'             => esc_html__( 'Vehicle Review Stamps', 'cardealer-helper' ),
		'name'              => '',
		'type'              => 'tab',
		'instructions'      => '',
		'required'          => 0,
		'conditional_logic' => 0,
		'wrapper'           => array(
			'width' => '',
			'class' => 'acf_field_name-vehicle_review_stamps',
			'id'    => '',
		),
		'placement'         => 'top',
		'endpoint'          => 0,
	);

	for( $i=0; $i<$review_stamp_limit; $i++ ) {
		$generate_review_stamp_acf_fields[] = $cardealer_review_stamp_acf_fields_array[$i][0];
		$generate_review_stamp_acf_fields[] = $cardealer_review_stamp_acf_fields_array[$i][1];
	}

	$vehicle_acf_review_stamps_fields = apply_filters(
		'cardealer_acf_vehicle_review_stamps_fields',
		$generate_review_stamp_acf_fields
	);

	$cardealer_acf_sell_vehicle_fields = array();
	$sell_vehicle_option               = isset( $car_dealer_options['sell_vehicle_option'] ) ? $car_dealer_options['sell_vehicle_option'] : '';
	if ( $sell_vehicle_option && ( function_exists( 'cdhl_plugin_active_status' ) && cdhl_plugin_active_status( 'woocommerce/woocommerce.php' ) ) ) {
		$cardealer_acf_sell_vehicle_fields = apply_filters(
			'cardealer_acf_sell_vehicle_fields',
			array(
				array(
					'key'               => 'field_569f56d0975246',
					'label'             => esc_html__( 'Sell Vehicle', 'cardealer-helper' ),
					'name'              => '',
					'type'              => 'tab',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => 'acf_field_name-vehicle-sell',
						'id'    => '',
					),
					'placement'         => 'left',
					'endpoint'          => 0,
				),
				array(
					'key'               => 'field_564f5cfb2460850',
					'label'             => esc_html__( 'Sell Vehicle Online', 'cardealer-helper' ),
					'name'              => 'sell_vehicle_status',
					'type'              => 'radio',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => 'acf_field_name-sell_vehicle_status',
						'id'    => '',
					),
					'choices'           => array(
						'enable'  => esc_html__( 'Enable', 'cardealer-helper' ),
						'disable' => esc_html__( 'Disable', 'cardealer-helper' ),
					),
					'allow_null'        => 1,
					'other_choice'      => 0,
					'save_other_choice' => 0,
					'default_value'     => '',
					'layout'            => 'horizontal',
					'return_format'     => 'value',
				),
				array(
					'key'               => 'field_562f1578cf17u',
					'label'             => esc_html__( 'Stock Quantity', 'cardealer-helper' ),
					'name'              => 'total_vehicle_in_stock',
					'type'              => 'number',
					'instructions'      => esc_html__( 'The total number of vehicles in stock. Note: If the stock quantity is zero, then the buy button will not be visible.', 'cardealer-helper' ),
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => 'acf_field_name-total_vehicle_in_stock',
						'id'    => '',
					),
					'default_value'     => '1',
					'min'               => '',
					'max'               => '',
					'step'              => '',
					'placeholder'       => '',
					'prepend'           => '',
					'append'            => '',
				),
			)
		);
	}

	$core_acf_attr_fields_tab = apply_filters(
		'cardealer_acf_core_acf_attr_fields',
		$core_acf_attr_fields
	);

	return array_merge(
		$core_acf_attr_fields_tab,
		$vehicle_acf_images_fields,
		$vehicle_acf_price_fields,
		$vehicle_acf_tax_label_fields,
		$vehicle_acf_fuel_efficiency_fields,
		$vehicle_acf_brochure_upload_fields,
		$vehicle_acf_video_link_fields,
		$vehicle_acf_status_fields,
		$vehicle_acf_review_stamps_fields,
		$cardealer_acf_sell_vehicle_fields
	);

}

if ( function_exists( 'acf_add_local_field_group' ) ) :

	acf_add_local_field_group(
		/**
		 * Filters the arguments of the vehicle data field group.
		 *
		 * @since 1.0
		 * @param array    $args Arguments of the vehicle data field group.
		 * @visible        true
		 */
		apply_filters(
			'cardealer_acf_car_data',
			array(
				'key'                   => 'group_588f1cea78c99',
				'title'                 => esc_html__( 'Vehicle Data', 'cardealer-helper' ),
				'fields'                => cdhl_generate_core_acf_attr_fields(),
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'cars',
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'field',
				'hide_on_screen'        => '',
				'active'                => 1,
				'description'           => '',
				'menu_item_level'       => 'all',
				'modified'              => 1498466136,
			)
		)
	);

endif;
