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
use Elementor\Group_Control_Typography;

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
class Section_Title extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'section-title';

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
	protected $keywords = array( 'section', 'title' );

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
		return esc_html__( 'Potenza Section Title', 'cardealer-helper' );
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
				'label'   => esc_html__( 'Style', 'cardealer-helper' ),
				'type'    => 'pgs_select_image',
				'default' => 'style-1',
				'options' => array(
					'style-1' => array(
						'label' => esc_html__( 'Style 1', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_VC_URL ) . 'vc_images/options/cd_section_title/style_1.png',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_VC_URL ) . 'vc_images/options/cd_section_title/style_2.png',
					),
				),
			)
		);

		$this->add_control(
			'hide_seperator',
			[
				'label'        => esc_html__( 'Hide separator(border)?', 'cardealer-helper' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'This will hide separator(border) displayed after section title.', 'cardealer-helper' ),
				'label_on'     => esc_html__( 'Yes', 'cardealer-helper' ),
				'label_off'    => esc_html__( 'No', 'cardealer-helper' ),
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'seperator_color',
			[
				'label'     => esc_html__( 'Seperator Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'hide_seperator' => 'true',
				],
				'selectors' => [
					'{{WRAPPER}} .section-title .separator:before' => 'background: {{VALUE}};',
					'{{WRAPPER}} .section-title .separator:after' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_align',
			[
				'label'   => esc_html__( 'Title Align', 'elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'text-left'   => [
						'title' => esc_html__( 'Left', 'elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'text-center' => [
						'title' => esc_html__( 'Center', 'elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'text-right'  => [
						'title' => esc_html__( 'Right', 'elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default' => 'text-center',
			]
		);

		$this->add_control(
			'section_title',
			[
				'label'       => esc_html__( 'Section Title', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'heading_tag',
			[
				'label'       => esc_html__( 'Heading Tag', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'h2',
				'options'     => [
					'h1' => esc_html__( 'H1', 'cardealer-helper' ),
					'h2' => esc_html__( 'H2', 'cardealer-helper' ),
					'h3' => esc_html__( 'H3', 'cardealer-helper' ),
					'h4' => esc_html__( 'H4', 'cardealer-helper' ),
					'h5' => esc_html__( 'H5', 'cardealer-helper' ),
					'h6' => esc_html__( 'H6', 'cardealer-helper' ),
				],
				'condition'   => [
					'style' => 'style-1',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'global'   => [
					'default' => '',
				],
				'selector' => '{{WRAPPER}} .section-title .main-title',
			]
		);

		$this->add_control(
			'section_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .section-title.style_1 h1' => 'color: {{VALUE}};',
					'{{WRAPPER}} .section-title.style_1 h2' => 'color: {{VALUE}};',
					'{{WRAPPER}} .section-title.style_1 h3' => 'color: {{VALUE}};',
					'{{WRAPPER}} .section-title.style_1 h4' => 'color: {{VALUE}};',
					'{{WRAPPER}} .section-title.style_1 h5' => 'color: {{VALUE}};',
					'{{WRAPPER}} .section-title.style_1 h6' => 'color: {{VALUE}};',
					'{{WRAPPER}} .section-title.style_2 span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'section_number_tag',
			[
				'label'       => esc_html__( 'Section Number Tag', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'separator'   => 'before',
				'default'     => 'h2',
				'description' => esc_html__( 'Tag to be used for section number display.', 'cardealer-helper' ),
				'options'     => [
					'h1' => esc_html__( 'H1', 'cardealer-helper' ),
					'h2' => esc_html__( 'H2', 'cardealer-helper' ),
					'h3' => esc_html__( 'H3', 'cardealer-helper' ),
					'h4' => esc_html__( 'H4', 'cardealer-helper' ),
					'h5' => esc_html__( 'H5', 'cardealer-helper' ),
					'h6' => esc_html__( 'H6', 'cardealer-helper' ),
				],
				'condition'   => [
					'style' => 'style-2',
				],
			]
		);

		$this->add_control(
			'section_number',
			[
				'label'       => esc_html__( 'Section Number', 'cardealer-helper' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 1,
				'max'         => 9999,
				'step'        => 1,
				'default'     => 20,
				'description' => esc_html__( 'Enter section title number.', 'cardealer-helper' ),
				'condition'   => [
					'style' => 'style-2',
				],
			]
		);

		$this->add_control(
			'number_color',
			[
				'label'     => esc_html__( 'Number Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'style' => 'style-2',
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .section-title.style_2 h1' => 'color: {{VALUE}};',
					'{{WRAPPER}} .section-title.style_2 h2' => 'color: {{VALUE}};',
					'{{WRAPPER}} .section-title.style_2 h3' => 'color: {{VALUE}};',
					'{{WRAPPER}} .section-title.style_2 h4' => 'color: {{VALUE}};',
					'{{WRAPPER}} .section-title.style_2 h5' => 'color: {{VALUE}};',
					'{{WRAPPER}} .section-title.style_2 h6' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'section_sub_title',
			[
				'label'       => esc_html__( 'Section Subtitle', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'separator'   => 'before',
				'description' => esc_html__( 'Enter section subtitle.', 'cardealer-helper' ),
				'condition'   => [
					'style' => 'style-1',
				],
			]
		);

		$this->add_control(
			'section_sub_title_color',
			[
				'label'     => esc_html__( 'Sub Title Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'style' => 'style-1',
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .section-title span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'show_content',
			[
				'label'        => esc_html__( 'Show content?', 'cardealer-helper' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'cardealer-helper' ),
				'label_off'    => esc_html__( 'No', 'cardealer-helper' ),
				'return_value' => 'true',
				'separator'   => 'before',
				'condition'    => [
					'style' => 'style-1',
				],
			]
		);

		$this->add_control(
			'content',
			[
				'label'       => esc_html__( 'Section Content', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'Enter content here.', 'cardealer-helper' ),
				'condition'   => [
					'show_content' => 'true',
				],
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => esc_html__( 'Content Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'show_content' => 'true',
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .section-title p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}
}
