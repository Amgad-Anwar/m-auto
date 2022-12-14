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
class Testimonials extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'testimonials';

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
	protected $keywords = array( 'testimonials' );

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
		return esc_html__( 'Potenza Testimonials', 'cardealer-helper' );
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
			'style',
			array(
				'label'       => esc_html__( 'Style', 'cardealer-helper' ),
				'type'        => 'pgs_select_image',
				'description' => esc_html__( 'Select Testimonials style.', 'cardealer-helper' ),
				'default'     => 'style-1',
				'options'     => array(
					'style-1' => array(
						'label' => esc_html__( 'Style 1', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_testimonials/style-1.png',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_testimonials/style-2.png',
					),
					'style-3' => array(
						'label' => esc_html__( 'Style 3', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_testimonials/style-3.png',
					),
					'style-4' => array(
						'label' => esc_html__( 'Style 4', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_testimonials/style-4.png',
					),
					'style-5' => array(
						'label' => esc_html__( 'Style 5', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_testimonials/style-5.png',
					),
				),
			)
		);

		$this->add_control(
			'no_of_testimonials',
			[
				'label'       => esc_html__( 'No. of Testimonials', 'cardealer-helper' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 9999,
				'step'        => 1,
				'default'     => 20,
				'description' => esc_html__( 'Select count of testimonials to display.', 'cardealer-helper' ),
			]
		);

		$this->add_control(
			'data_md_items',
			[
				'label'   => esc_html__( 'Number of slide desktops', 'cardealer-helper' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 5,
				'step'    => 1,
				'default' => 4,
			]
		);

		$this->add_control(
			'data_sm_items',
			[
				'label'   => esc_html__( 'Number of slide tablets', 'cardealer-helper' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 5,
				'step'    => 1,
				'default' => 2,
			]
		);

		$this->add_control(
			'data_xs_items',
			[
				'label'   => esc_html__( 'Number of slide mobile landscape', 'cardealer-helper' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 5,
				'step'    => 1,
				'default' => 1,
			]
		);

		$this->add_control(
			'data_xx_items',
			[
				'label'   => esc_html__( 'Number of slide mobile portrait', 'cardealer-helper' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 5,
				'step'    => 1,
				'default' => 1,
			]
		);

		$this->add_control(
			'data_space',
			[
				'label'   => esc_html__( 'Space between two slide', 'cardealer-helper' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 999,
				'step'    => 1,
				'default' => 1,
			]
		);

		$this->add_control(
			'testimonials_slider_opt',
			[
				'label'    => esc_html__( 'Slider style option', 'cardealer-helper' ),
				'type'     => Controls_Manager::SELECT2,
				'multiple' => true,
				'options'  => [
					'navigation-arrow' => esc_html__( 'Navigation Arrow', 'cardealer-helper' ),
					'navigation-dots'  => esc_html__( 'Navigation Dots', 'cardealer-helper' ),
					'autoplay'         => esc_html__( 'Autoplay', 'cardealer-helper' ),
					'loop'             => esc_html__( 'Loop', 'cardealer-helper' ),
				],
			]
		);

		$this->end_controls_section();
	}
}
