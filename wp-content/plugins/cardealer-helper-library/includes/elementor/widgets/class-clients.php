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
class Clients extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'clients';

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
	protected $keywords = array( 'clients' );

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
		return esc_html__( 'Potenza Clients', 'cardealer-helper' );
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
			'clients_images',
			[
				'label'       => esc_html__( 'Clients Logo', 'cardealer-helper' ),
				'type'        => \Elementor\Controls_Manager::GALLERY,
				'default'     => [],
				'description' => esc_html__( 'Select Clients logo.', 'cardealer-helper' ),
			]
		);

		$this->add_control(
			'list_style',
			[
				'label'       => esc_html__( 'List Style', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'without_slider',
				'description' => esc_html__( 'Layout style of displaying clients logo.', 'cardealer-helper' ),
				'options'     => [
					'with_slider'    => esc_html__( 'Carousel', 'cardealer-helper' ),
					'without_slider' => esc_html__( 'Grid', 'cardealer-helper' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_grid',
			array(
				'label'     => esc_html__( 'Grid Settings', 'cardealer-helper' ),
				'tab'       => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'list_style' => 'without_slider',
				],
			)
		);

		$this->add_control(
			'number_of_column',
			[
				'label'       => esc_html__( 'Number of column', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '2',
				'description' => esc_html__( 'Select number of columns in Grid view.', 'cardealer-helper' ),
				'options'     => [
					'1'  => '1',
					'2'  => '2',
					'3'  => '3',
					'4'  => '4',
					'5'  => '5',
					'5'  => '5',
					'6'  => '6',
					'7'  => '7',
					'8'  => '8',
					'9'  => '9',
					'10' => '10',
					'11' => '11',
					'12' => '12',
				],
				'condition'   => [
					'list_style' => 'without_slider',
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
					'list_style' => 'with_slider',
				],
			)
		);

		$this->add_control(
			'data_md_items',
			[
				'label'       => esc_html__( 'Number of slide for desktops per rows', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '3',
				'description' => esc_html__( 'Select number of items to display at a time in small devices.', 'cardealer-helper' ),
				'options'     => [
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'5' => '5',
					'6' => '6',
				],
				'condition'   => array(
					'list_style' => 'with_slider',
				),
			]
		);

		$this->add_control(
			'data_sm_items',
			[
				'label'       => esc_html__( 'Number of slide for tablets', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '2',
				'description' => esc_html__( 'Select number of items to display at a time in small devices.', 'cardealer-helper' ),
				'options'     => [
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'5' => '5',
				],
				'condition'   => array(
					'list_style' => 'with_slider',
				),
			]
		);

		$this->add_control(
			'data_xs_items',
			[
				'label'       => esc_html__( 'Number of slide for mobile landscape', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '1',
				'description' => esc_html__( 'Select number of items to display at a time in small devices.', 'cardealer-helper' ),
				'options'     => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'condition'   => array(
					'list_style' => 'with_slider',
				),
			]
		);

		$this->add_control(
			'data_xx_items',
			[
				'label'       => esc_html__( 'Number of slide for mobile portrait', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '1',
				'description' => esc_html__( 'Select number of items to display at a time in small devices.', 'cardealer-helper' ),
				'options'     => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
				],
				'condition'   => array(
					'list_style' => 'with_slider',
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
					'list_style' => 'with_slider',
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
					'list_style' => 'with_slider',
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
					'list_style' => 'with_slider',
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
					'list_style' => 'with_slider',
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
					'list_style' => 'with_slider',
				),
			]
		);

		$this->end_controls_section();
	}
}
