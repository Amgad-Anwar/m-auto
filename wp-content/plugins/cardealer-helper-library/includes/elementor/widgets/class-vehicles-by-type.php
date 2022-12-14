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
class Vehicles_By_Type extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'vehicles-by-type';

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
	protected $keywords = array( 'vehicles', 'type' );

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
		return esc_html__( 'Potenza Vehicle By Type', 'cardealer-helper' );
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

		$car_make_label   = cardealer_get_field_label_with_tax_key( 'car_make' );
		$p_car_make_label = cardealer_get_field_label_with_tax_key( 'car_make', 'plural' );
		$car_body_label   = cardealer_get_field_label_with_tax_key( 'car_body_style' );
		$p_car_body_label = cardealer_get_field_label_with_tax_key( 'car_body_style', 'plural' );

		$this->start_controls_section(
			'section_content_general',
			array(
				'label' => esc_html__( 'General', 'cardealer-helper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'search_section_label',
			[
				'label'       => esc_html__( 'Section Title', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter search section label', 'cardealer-helper' ),
				'deafult'     => esc_html__( 'I want search', 'cardealer-helper' ),
			]
		);

		$this->add_control(
			'vehicle_makes',
			[
				'label'       => sprintf( esc_html__( 'Select %s', 'cardealer-helper' ), $car_make_label ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'description' => sprintf( esc_html__( 'Select car "%1$s" to display on front. If no one selected, then it will show all "%2$s". Also, please select a list of four items so it looks proper.', 'cardealer-helper' ), $car_make_label, $p_car_make_label ),
				'options'     => array_flip( cdhl_get_term_data_by_taxonomy( 'car_make', 'term_array' ) ),
			]
		);

		$this->add_control(
			'cars_body_styles',
			[
				'label'       => sprintf( esc_html__( 'Select %s', 'cardealer-helper' ), $car_body_label ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'description' => sprintf( esc_html__( 'Select car "%1$s" to display on front. If no one selected, then it will show all "%2$s". Also, please select a list of four items so it looks proper.', 'cardealer-helper' ), $car_body_label, $p_car_body_label ),
				'options'     => array_flip( cdhl_get_term_data_by_taxonomy( 'car_body_style', 'term_array' ) ),
			]
		);

		$this->add_control(
			'hide_type_tab',
			[
				'label'       => esc_html__( 'Hide Tab', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'no',
				'options'     => [
					'no'        => esc_html__( 'Select', 'cardealer-helper' ),
					'make'      => sprintf( esc_html__( 'Hide Tab %s ', 'cardealer-helper' ), $car_make_label ),
					'body_type' => sprintf( esc_html__( 'Hide Tab %s ', 'cardealer-helper' ), $car_body_label ),
				],
			]
		);

		$this->add_control(
			'type_search_tab_lables',
			[
				'label'        => esc_html__( 'Conditions Tab Labels', 'cardealer-helper' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Check the checkbox to add full width button.', 'cardealer-helper' ),
				'label_on'     => esc_html__( 'Custom', 'cardealer-helper' ),
				'label_off'    => esc_html__( 'Default', 'cardealer-helper' ),
				'return_value' => 'true',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_custom_labels',
			array(
				'label'     => esc_html__( 'Custom Labels', 'cardealer-helper' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => array(
					'type_search_tab_lables' => 'true',
				),
			)
		);

		$this->add_control(
			'custom_lbl_type_1',
			[
				'label'       => esc_html__( 'Custom Label For ', 'cardealer-helper' ) . $car_make_label,
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter custom label for ', 'cardealer-helper' ) . $car_make_label,
				'deafult'     => sprintf( esc_html__( 'Browse %s', 'cardealer-helper' ), $car_make_label ),
				'condition'   => array(
					'type_search_tab_lables' => 'true',
				),
			]
		);

		$this->add_control(
			'custom_lbl_type_2',
			[
				'label'       => esc_html__( 'Custom Label For ', 'cardealer-helper' ) . $car_body_label,
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter custom label for ', 'cardealer-helper' ) . $car_body_label,
				'deafult'     => sprintf( esc_html__( 'Browse %s', 'cardealer-helper' ), $car_body_label ),
				'condition'   => array(
					'type_search_tab_lables' => 'true',
				),
			]
		);
	}
}
