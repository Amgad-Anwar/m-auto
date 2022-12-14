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
class Vehicles_List extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'vehicles-list';

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
	protected $keywords = array( 'vehicles', 'list' );

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
		return esc_html__( 'Potenza Vehicles List', 'cardealer-helper' );
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

		$car_make = cdhl_get_terms(
			array(
				'taxonomy' => 'car_make',
			)
		);

		$vehicle_cat = cdhl_get_terms(
			array(
				'taxonomy' => 'vehicle_cat',
			)
		);

		$this->start_controls_section(
			'section_content_general',
			array(
				'label' => esc_html__( 'General', 'cardealer-helper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$car_make_label   = cardealer_get_field_label_with_tax_key( 'car_make' );
		$p_car_make_label = cardealer_get_field_label_with_tax_key( 'car_make', 'plural' );

		$this->add_control(
			'style',
			array(
				'label'       => esc_html__( 'Tabs type', 'cardealer-helper' ),
				'type'        => 'pgs_select_image',
				'description' => esc_html__( 'Select tab style.', 'cardealer-helper' ),
				'default'     => 'style-1',
				'options'     => array(
					'style-1' => array(
						'label' => esc_html__( 'Style 1', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_carousel/carousel_1.png',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_carousel/carousel_2.png',
					),
				),
			)
		);

		$this->add_control(
			'list_type',
			[
				'label'       => esc_html__( 'List Style', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'with_slider',
				'options'     => [
					'with_slider'    => esc_html__( 'Carousel', 'cardealer-helper' ),
					'without_silder' => esc_html__( 'Grid', 'cardealer-helper' ),
				],
				'description' => esc_html__( 'It will display carousel slider or grid listing based on selection.', 'cardealer-helper' ),
			]
		);

		$this->add_control(
			'items_type',
			[
				'label'   => esc_html__( 'Items Type', 'cardealer-helper' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'pgs_new_arrivals',
				'options' => [
					'pgs_new_arrivals' => esc_html__( 'Newest', 'cardealer-helper' ),
					'pgs_featured'     => esc_html__( 'Featured', 'cardealer-helper' ),
					'pgs_on_sale'      => esc_html__( 'On sale', 'cardealer-helper' ),
					'pgs_cheapest'     => esc_html__( 'Cheapest', 'cardealer-helper' ),
				],
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
				'label'        => esc_html__( 'Hide sold vehicles', 'cardealer-helper' ),
				'description'  => esc_html__( 'Check this checkbox to hide sold vehicles.', 'cardealer-helper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'cardealer-helper' ),
				'label_off'    => esc_html__( 'No', 'cardealer-helper' ),
				'return_value' => 'true',
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

		$this->start_controls_section(
			'section_content_post_settings',
			array(
				'label' => esc_html__( 'Vehicle Settings', 'cardealer-helper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		if ( $vehicle_cat ) {

			$vehicle_cat     = array_flip( $vehicle_cat );
			$vehicle_cat[''] = esc_html__( 'Select', 'cardealer-helper' );

			$this->add_control(
				'vehicle_category',
				[
					'label'   => esc_html__( 'Vehicle Category', 'cardealer-helper' ),
					'type'    => Controls_Manager::SELECT,
					'options' => $vehicle_cat,
				]
			);
		}

		$this->add_control(
			'car_make',
			[
				'label'       => esc_html__( 'Select ', 'cardealer-helper' ) . $car_make_label,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'description' => sprintf( esc_html__( 'Select vehicle "%1$s" to limit result from. To display result from all "%2$s" leave all "%3$s" unselected.', 'cardealer-helper' ), $car_make_label, $p_car_make_label, $p_car_make_label ),
				'options'     => array_flip( $car_make ),
			]
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

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_grid',
			array(
				'label'     => esc_html__( 'Grid', 'cardealer-helper' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'list_type' => 'without_silder',
				],
			)
		);

		$this->add_control(
			'number_of_column',
			[
				'label'     => esc_html__( 'Number of column', 'cardealer-helper' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
				],
				'default'   => 3,
				'condition' => [
					'list_type' => 'without_silder',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_carousel',
			array(
				'label'     => esc_html__( 'Carousel', 'cardealer-helper' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'list_type' => 'with_slider',
				],
			)
		);

		$this->add_control(
			'data_md_items',
			[
				'label'     => esc_html__( 'Number of slide desktops per rows', 'cardealer-helper' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					3 => 3,
					4 => 4,
				],
				'default'   => 3,
				'condition' => [
					'list_type' => 'with_slider',
				],
			]
		);

		$this->add_control(
			'data_sm_items',
			[
				'label'     => esc_html__( 'Number of slide tablets', 'cardealer-helper' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					2 => 2,
					3 => 3,
					4 => 4,
				],
				'default'   => 3,
				'condition' => [
					'list_type' => 'with_slider',
				],
			]
		);

		$this->add_control(
			'data_xs_items',
			[
				'label'     => esc_html__( 'Number of slide mobile landscape', 'cardealer-helper' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					1 => 1,
					2 => 2,
					3 => 3,
				],
				'default'   => 3,
				'condition' => [
					'list_type' => 'with_slider',
				],
			]
		);

		$this->add_control(
			'data_xx_items',
			[
				'label'     => esc_html__( 'Number of slide mobile portrait', 'cardealer-helper' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					1 => 1,
					2 => 2,
				],
				'default'   => 1,
				'condition' => [
					'list_type' => 'with_slider',
				],
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
					'list_type' => 'with_slider',
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
					'list_type' => 'with_slider',
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
					'list_type' => 'with_slider',
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
					'list_type' => 'with_slider',
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
					'list_type' => 'with_slider',
				),
			]
		);

		$this->end_controls_section();
	}
}
