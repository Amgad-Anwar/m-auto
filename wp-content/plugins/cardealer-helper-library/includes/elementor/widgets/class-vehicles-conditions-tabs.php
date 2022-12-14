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
class Vehicles_Conditions_Tabs extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'vehicles-conditions-tabs';

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
	protected $keywords = array( 'vehicles', 'conditions', 'tabs' );

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
		return esc_html__( 'Potenza Vehicles Conditions Tabs', 'cardealer-helper' );
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

		// Build vehicles conditions array.
		$conditions_terms = get_terms(
			array(
				'taxonomy'   => 'car_condition',
				'hide_empty' => true,
			)
		);
		$condition_array  = array();
		foreach ( $conditions_terms as $terms ) {
			$condition_array[ $terms->slug ] = $terms->name;
		}

		$car_categories = cdhl_get_terms( array( 'taxonomy' => 'car_make' ) );
		$vehicle_cat    = cdhl_get_terms( array( 'taxonomy' => 'vehicle_cat' ) );

		$this->start_controls_section(
			'section_content_general',
			array(
				'label' => esc_html__( 'General', 'cardealer-helper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$car_condition_label   = cardealer_get_field_label_with_tax_key( 'car_condition' );
		$p_car_condition_label = cardealer_get_field_label_with_tax_key( 'car_condition', 'plural' );
		$car_make_label        = cardealer_get_field_label_with_tax_key( 'car_make' );
		$p_car_make_label      = cardealer_get_field_label_with_tax_key( 'car_make', 'plural' );

		$this->add_control(
			'list_style',
			[
				'label'       => esc_html__( 'List Style', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'slider',
				'description' => esc_html__( 'It will display carousel slider or grid listing based on selection.', 'cardealer-helper' ),
				'options'     => [
					'slider' => esc_html__( 'Slider', 'cardealer-helper' ),
					'grid'   => esc_html__( 'Grid', 'cardealer-helper' ),
				],
			]
		);

		$this->add_control(
			'section_label',
			[
				'label'       => esc_html__( 'Section Title', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter tab section label', 'cardealer-helper' ),
				'default'     => esc_html__( 'which vehicle You need?', 'cardealer-helper' ),
			]
		);

		$this->add_control(
			'condition_tabs',
			[
				'label'       => $car_condition_label . esc_html__( ' Tab', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'description' => sprintf( esc_html__( 'Select at least two vehicle "%1$s" to include in tabs. If no selected, then no vehicle will display.', 'cardealer-helper' ), $p_car_condition_label ),
				'options'     => $condition_array,
			]
		);

		$this->add_control(
			'image_size_text',
			[
				'label'       => esc_html__( 'Image Size', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'car_tabs_image',
				'options'     => cardealer_get_all_registered_image_size_array(),
				'description' => wp_kses(
					sprintf(
						__( 'To know more about image size and add your custom image size, please refer to <a href="%s" target="_blank" rel="noopener">this document</a>.', 'cardealer-helper' ),
						'https://docs.potenzaglobalsolutions.com/docs/cardealer/image-size/'
					),
					array(
						'a' => array(
							'href'   => true,
							'target' => true,
							'rel'    => true,
						),
					)
				),
			]
		);

		$this->add_control(
			'hide_sold_vehicles',
			[
				'label'        => esc_html__( 'Hide Sold Vehicles', 'cardealer-helper' ),
				'description'  => esc_html__( 'Check this checkbox to hide sold vehicles.', 'cardealer-helper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'cardealer-helper' ),
				'label_off'    => esc_html__( 'No', 'cardealer-helper' ),
				'return_value' => 'true',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_grid',
			array(
				'label'     => esc_html__( 'Grid Settings', 'cardealer-helper' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'list_style' => 'grid',
				],
			)
		);

		$this->add_control(
			'number_of_column',
			[
				'label'     => esc_html__( 'Number of column', 'cardealer-helper' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '3',
				'options'   => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				),
				'condition' => [
					'list_style' => 'grid',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_slider',
			array(
				'label'     => esc_html__( 'Slider Settings', 'cardealer-helper' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'list_style' => 'slider',
				],
			)
		);

		$this->add_control(
			'data_md_items',
			[
				'label'     => esc_html__( 'Number of slide desktops per rows', 'cardealer-helper' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '3',
				'options'   => [
					'3' => '3',
					'4' => '4',
				],
				'condition' => array(
					'list_style' => 'slider',
				),
			]
		);

		$this->add_control(
			'data_sm_items',
			[
				'label'     => esc_html__( 'Number of slide tablets', 'cardealer-helper' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '3',
				'options'   => [
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'condition' => array(
					'list_style' => 'slider',
				),
			]
		);

		$this->add_control(
			'data_xs_items',
			[
				'label'     => esc_html__( 'Number of slide mobile landscape', 'cardealer-helper' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '2',
				'options'   => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
				],
				'condition' => array(
					'list_style' => 'slider',
				),
			]
		);

		$this->add_control(
			'data_xx_items',
			[
				'label'     => esc_html__( 'Number of slide mobile portrait', 'cardealer-helper' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '2',
				'options'   => [
					'1' => '1',
					'2' => '2',
				],
				'condition' => array(
					'list_style' => 'slider',
				),
			]
		);

		$this->add_control(
			'arrow',
			[
				'label'        => esc_html__( 'Navigation Arrow', 'cardealer-helper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'cardealer-helper' ),
				'label_off'    => esc_html__( 'No', 'cardealer-helper' ),
				'return_value' => 'true',
				'condition'    => array(
					'list_style' => 'slider',
				),
			]
		);

		$this->add_control(
			'dots',
			[
				'label'        => esc_html__( 'Navigation Dots', 'cardealer-helper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'cardealer-helper' ),
				'label_off'    => esc_html__( 'No', 'cardealer-helper' ),
				'return_value' => 'true',
				'condition'    => array(
					'list_style' => 'slider',
				),
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'        => esc_html__( 'Autoplay', 'cardealer-helper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'cardealer-helper' ),
				'label_off'    => esc_html__( 'No', 'cardealer-helper' ),
				'return_value' => 'true',
				'condition'    => array(
					'list_style' => 'slider',
				),
			]
		);

		$this->add_control(
			'data_loop',
			[
				'label'        => esc_html__( 'Loop', 'cardealer-helper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'cardealer-helper' ),
				'label_off'    => esc_html__( 'No', 'cardealer-helper' ),
				'return_value' => 'true',
				'condition'    => array(
					'list_style' => 'slider',
				),
			]
		);

		$this->add_control(
			'data_space',
			[
				'label'     => esc_html__( 'Space between two slide', 'cardealer-helper' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 9999,
				'step'      => 1,
				'default'   => 20,
				'condition' => array(
					'list_style' => 'slider',
				),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_post',
			array(
				'label' => esc_html__( 'Post Settings', 'cardealer-helper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'number_of_item',
			[
				'label'       => esc_html__( 'Number of item', 'cardealer-helper' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select Number of items to display.', 'cardealer-helper' ),
				'min'         => 1,
				'max'         => 9999,
				'step'        => 1,
				'default'     => 5,
			]
		);

		$this->add_control(
			'vehicle_category',
			[
				'label'       => esc_html__( 'Vehicle Category', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'description' => esc_html__( 'Select vehicle category to limit result from. To display result from all categories, leave all categories unselected.' ),
				'options'     => array_flip( $vehicle_cat ),
			]
		);

		$this->add_control(
			'makes',
			[
				'label'       => esc_html__( 'Vehicle ', 'cardealer-helper' ) . $car_make_label,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'description' => sprintf( esc_html__( 'Select "%1$s" to limit result from. To display result from all "%2$s", leave all "%3$s" unselected.', 'cardealer-helper' ), $car_make_label, $p_car_make_label, $p_car_make_label ),
				'options'     => array_flip( $car_categories ),
			]
		);

		$this->add_control(
			'item_background',
			[
				'label'   => esc_html__( 'Item Background', 'cardealer-helper' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'white-bg',
				'options' => [
					'white-bg' => esc_html__( 'White', 'cardealer-helper' ),
					'grey-bg'  => esc_html__( 'Grey', 'cardealer-helper' ),
				],
			]
		);

		$this->end_controls_section();
	}
}
