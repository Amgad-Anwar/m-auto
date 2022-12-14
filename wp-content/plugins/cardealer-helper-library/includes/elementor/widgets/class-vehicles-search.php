<?php
/**
 * Banner class.
 *
 * @package cardealer-helper/elementor
 * @since   5.0.0
 */

namespace Cdhl_Elementor\Widgets;

use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

use Cdhl_Elementor\Widget_Controller\Widget_Controller;
use Cdhl_Elementor\Group_Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor banner widget.
 *
 * Elementor widget that displays an banner.
 *
 * @since 5.0.0
 */
class Vehicles_Search extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'vehicles-search';

	/**
	 * Widget icon
	 *
	 * @var string
	 */
	protected $widget_icon = 'cdhl-widget-icon';

	/**
	 * Widget keywords
	 *
	 * @var array
	 */
	protected $keywords = array( 'vehicles', 'Search' );

	/**
	 * Retrieve the widget title.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Potenza Vehicles Search', 'cardealer-helper' );
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 5.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {

		$default_condition = array(
			'all_vehicles' => esc_html__( 'All vehicles', 'cardealer-helper' ),
		);

		$taxonomy_condition = array_flip( cdhl_get_terms( array( 'taxonomy' => 'car_condition' ) ) );
		$car_conditions     = array_merge( $default_condition, $taxonomy_condition );

		$car_condition_label = cardealer_get_field_label_with_tax_key( 'car_condition' );

		$this->start_controls_section(
			'section_content_general',
			array(
				'label' => esc_html__( 'General', 'cardealer-helper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'section_title',
			[
				'label'       => esc_html__( 'Section Title', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter search section title.', 'cardealer-helper' ),
			]
		);

		$this->add_control(
			'search_condition_tabs',
			[
				'label'       => esc_html__( 'Search Vehicle ', 'cardealer-helper' ) . $car_condition_label . esc_html__( ' Tab ', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'description' => sprintf( esc_html__( 'Select search vehicle "%1$s" in tabs. If no selected, then deafult "%2$s" will be displayed.', 'cardealer-helper' ), $car_condition_label, $car_condition_label ),
				'options'     => $car_conditions,
			]
		);

		$this->add_control(
			'filter_background',
			[
				'label'       => esc_html__( 'Filters Background', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'dark',
				'description' => esc_html__( 'Select filters position.', 'cardealer-helper' ),
				'options'     => [
					'dark'  => esc_html__( 'Dark', 'cardealer-helper' ),
					'light' => esc_html__( 'Light', 'cardealer-helper' ),
				],
			]
		);

		$this->add_control(
			'src_button_label',
			[
				'label'       => esc_html__( 'Button label', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter search button label', 'cardealer-helper' ),
				'default'     => esc_html__( 'Search Inventory', 'cardealer-helper' ),
			]
		);

		$this->add_control(
			'condition_custom_tab_lables',
			[
				'label'        => esc_html__( 'Conditions Tab Labels', 'cardealer-helper' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Check the checkbox to add full width button.', 'cardealer-helper' ),
				'label_on'     => esc_html__( 'Custom', 'cardealer-helper' ),
				'label_off'    => esc_html__( 'Default', 'cardealer-helper' ),
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'hide_location_input',
			[
				'label'        => esc_html__( 'Hide Location Field', 'cardealer-helper' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Check this box to hide location input field.', 'cardealer-helper' ),
				'label_on'     => esc_html__( 'Yes', 'cardealer-helper' ),
				'label_off'    => esc_html__( 'No', 'cardealer-helper' ),
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'vehicle_filters',
			[
				'label'       => esc_html__( 'Select Filters', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'options'     => array_flip( cdhl_get_cars_taxonomy() ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_custom_labels',
			array(
				'label'     => esc_html__( 'Custom Labels', 'cardealer-helper' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'condition_custom_tab_lables' => 'true',
				),
			)
		);

		foreach ( $car_conditions as $cond_lbl => $cond_val ) {

			$this->add_control(
				'custom_lbl_' . $cond_lbl,
				[
					'label'       => esc_html__( 'Custom Label For ', 'cardealer-helper' ) . $cond_val,
					'type'        => Controls_Manager::TEXT,
					'description' => esc_html__( 'Enter custom label for ', 'cardealer-helper' ) . $cond_val,
					'default'     => $cond_val,
					'condition'   => array(
						'condition_custom_tab_lables' => 'true',
					),
				]
			);
		}

		$this->end_controls_section();
	}
}
