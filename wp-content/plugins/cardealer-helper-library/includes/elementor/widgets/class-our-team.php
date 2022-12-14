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
class Our_Team extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'our-team';

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
	protected $keywords = array( 'our', 'team' );

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
		return esc_html__( 'Potenza Our Team', 'cardealer-helper' );
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
				'description' => esc_html__( 'Select team style.', 'cardealer-helper' ),
				'default'     => 'style-1',
				'options'     => array(
					'style-1' => array(
						'label' => esc_html__( 'Style 1', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_our_team/style-1.png',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_our_team/style-2.png',
					),
					'style-3' => array(
						'label' => esc_html__( 'Style 3', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_our_team/style-3.png',
					),
				),
			)
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'       => esc_html__( 'No. of Members', 'cardealer-helper' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Enter number of posts to display.', 'cardealer-helper' ),
				'default'     => 10,
				'min'         => '1',
				'max'         => '999999',
				'description' => esc_html__( 'Select count of team members to display.', 'cardealer-helper' ),
			]
		);

		$this->add_control(
			'list_type',
			[
				'label'       => esc_html__( 'List Style', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'grid',
				'description' => esc_html__( 'Select style.', 'cardealer-helper' ),
				'options'     => [
					'grid'   => esc_html__( 'Grid View', 'cardealer-helper' ),
					'slider' => esc_html__( 'Slider View', 'cardealer-helper' ),
				],
				'description' => esc_html__( 'Select list style for team members', 'cardealer-helper' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_grid',
			array(
				'label'     => esc_html__( 'Grid', 'cardealer-helper' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'list_type' => 'grid',
				],
			)
		);

		$this->add_control(
			'number_of_column',
			[
				'label'     => esc_html__( 'Number of column', 'cardealer-helper' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 2,
				'options'   => [
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
				],
				'condition' => array(
					'list_type' => 'grid',
				),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_slider',
			array(
				'label'     => esc_html__( 'Slider', 'cardealer-helper' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'list_type' => 'slider',
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
					'list_type' => 'slider',
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
					'list_type' => 'slider',
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
					'list_type' => 'slider',
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
					'list_type' => 'slider',
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
					'list_type' => 'slider',
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
					'list_type' => 'slider',
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
					'list_type' => 'slider',
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
					'list_type' => 'slider',
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
					'list_type' => 'slider',
				),
			]
		);

		$this->end_controls_section();
	}
}
