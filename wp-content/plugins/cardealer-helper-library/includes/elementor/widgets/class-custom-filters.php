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
class Custom_Filters extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'custom-filters';

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
	protected $keywords = array( 'custom', 'filters' );

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
		return esc_html__( 'Potenza Custom Filters', 'cardealer-helper' );
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

		$this->start_controls_section(
			'section_content_general',
			array(
				'label' => esc_html__( 'General', 'cardealer-helper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'custom_filters_style',
			array(
				'label'       => esc_html__( 'Style', 'cardealer-helper' ),
				'type'        => 'pgs_select_image',
				'description' => esc_html__( 'Select Testimonials style.', 'cardealer-helper' ),
				'default'     => 'style-1',
				'options'     => array(
					'style-1' => array(
						'label' => esc_html__( 'Style 1', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_car_filters/car_filter_style_1.png',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_car_filters/car_filter_style_2.png',
					),
				),
			)
		);

		$this->add_control(
			'cars_filters',
			[
				'label'       => esc_html__( 'Select Filters', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'description' => esc_html__( 'If no attributes selected, then no filters will be shown on front.', 'cardealer-helper' ),
				'options'     => array_flip( cdhl_get_cars_taxonomy() ),
			]
		);

		$this->add_control(
			'cars_year_range_slider_cfb',
			[
				'label'        => esc_html__( 'Year Range Slider', 'cardealer-helper' ),
				'description'  => esc_html__( 'Filter with year range slider.', 'cardealer-helper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'cardealer-helper' ),
				'label_off'    => esc_html__( 'No', 'cardealer-helper' ),
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'cars_price_range_slider',
			[
				'label'        => esc_html__( 'Price Range Slider', 'cardealer-helper' ),
				'description'  => esc_html__( 'Filter with price range slider.', 'cardealer-helper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'cardealer-helper' ),
				'label_off'    => esc_html__( 'No', 'cardealer-helper' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'filter_style',
			[
				'label'   => esc_html__( 'Filters Style', 'cardealer-helper' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'box',
				'options' => [
					'box'  => esc_html__( 'Box', 'cardealer-helper' ),
					'wide' => esc_html__( 'Wide', 'cardealer-helper' ),
				],
			]
		);

		$this->add_control(
			'filter_background',
			[
				'label'   => esc_html__( 'Filters Background', 'cardealer-helper' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'white-bg',
				'options' => [
					'white-bg'    => esc_html__( 'White', 'cardealer-helper' ),
					'red-bg'      => esc_html__( 'Primary Color', 'cardealer-helper' ),
					'transparent' => esc_html__( 'Transparent', 'cardealer-helper' ),
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

		$this->end_controls_section();
	}
}
