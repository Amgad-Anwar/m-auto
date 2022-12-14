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
class Multi_Tab extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'multi-tab';

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
	protected $keywords = array( 'multi', 'tab' );

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
		return esc_html__( 'Potenza Multi Tab', 'cardealer-helper' );
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

		$car_make_label = cardealer_get_field_label_with_tax_key( 'car_make' );

		$this->add_control(
			'style',
			array(
				'label'       => esc_html__( 'Tabs type', 'cardealer-helper' ),
				'type'        => 'pgs_select_image',
				'description' => esc_html__( 'Select multi tab style.', 'cardealer-helper' ),
				'default'     => 'style-1',
				'options'     => array(
					'style-1' => array(
						'label' => esc_html__( 'Style 1', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_multi_tabs/multi_tab_1.png',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_multi_tabs/multi_tab_2.png',
					),
				),
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
				'default'     => 1,
			]
		);

		$this->add_control(
			'padding',
			[
				'label'       => esc_html__( 'Padding', 'cardealer-helper' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'description' => esc_html__( 'Select Number of items to display.', 'cardealer-helper' ),
				'min'         => 1,
				'max'         => 200,
				'step'        => 1,
				'selectors'   => [
					'{{WRAPPER}} .grid-item' => 'padding: {{VALUE}}px',
				],
			]
		);

		$this->add_control(
			'number_of_column',
			[
				'label'   => esc_html__( 'Number of column', 'cardealer-helper' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'box',
				'options' => [
					3 => 3,
					4 => 4,
					5 => 5,
				],
				'default' => 3,
			]
		);

		$this->add_control(
			'car_make_slugs',
			[
				'label'       => esc_html__( 'Select ', 'cardealer-helper' ) . $car_make_label,
				'type'        => Controls_Manager::SELECT2,
				'multiple'    => true,
				'description' => sprintf( esc_html__( 'If no "%1$s" selected then no vehicle will be shown.', 'cardealer-helper' ), $car_make_label ),
				'options'     => array_flip( $car_make ),
			]
		);

		$this->add_control(
			'tab_type',
			[
				'label'       => esc_html__( 'Display vehicles type', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'pgs_new_arrivals',
				'description' => esc_html__( 'Select vehicles type for tabs. which will be displayed on frontend', 'cardealer-helper' ),
				'options'     => [
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

		if ( $vehicle_cat ) {

			$vehicle_cat     = array_flip( $vehicle_cat );
			$vehicle_cat[''] = esc_html__( 'Select', 'cardealer-helper' );

			$this->add_control(
				'vehicle_category',
				[
					'label'   => esc_html__( 'Vehicle Category', 'cardealer-helper' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '',
					'options' => $vehicle_cat,
				]
			);
		}

		$this->end_controls_section();
	}
}
