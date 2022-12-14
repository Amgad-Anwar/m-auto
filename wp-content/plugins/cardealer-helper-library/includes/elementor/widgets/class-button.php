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
class Button extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'button';

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
	protected $keywords = array( 'button' );

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
		return esc_html__( 'Potenza Button', 'cardealer-helper' );
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
			[
				'label'       => esc_html__( 'Style', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'default',
				'description' => esc_html__( 'Select the style.', 'cardealer-helper' ),
				'options'     => [
					'default' => esc_html__( 'Default', 'cardealer-helper' ),
					'border'  => esc_html__( 'Border', 'cardealer-helper' ),
				],
			]
		);

		$this->add_control(
			'button_title',
			[
				'label'       => esc_html__( 'Button Title', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter button title.', 'cardealer-helper' ),
			]
		);

		$this->add_control(
			'button_link',
			[
				'label'         => esc_html__( 'Button Link', 'cardealer-helper' ),
				'type'          => Controls_Manager::URL,
				'description'   => esc_html__( 'Enter button link.', 'cardealer-helper' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);

		$this->add_control(
			'button_size',
			[
				'label'       => esc_html__( 'Button Size', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'medium',
				'description' => esc_html__( 'Select button Size.', 'cardealer-helper' ),
				'options'     => [
					'small'       => esc_html__( 'Small', 'cardealer-helper' ),
					'medium'      => esc_html__( 'Medium', 'cardealer-helper' ),
					'large'       => esc_html__( 'Large', 'cardealer-helper' ),
					'extra-small' => esc_html__( 'Extra Small', 'cardealer-helper' ),
				],
			]
		);

		$this->add_control(
			'button_btn_full',
			[
				'label'        => esc_html__( 'Full Width?', 'cardealer-helper' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Check the checkbox to add full width button.', 'cardealer-helper' ),
				'label_on'     => esc_html__( 'Yes', 'cardealer-helper' ),
				'label_off'    => esc_html__( 'No', 'cardealer-helper' ),
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'icon',
			[
				'label'     => esc_html__( 'Icon', 'cardealer-helper' ),
				'type'      => Controls_Manager::ICONS,
				'separator' => 'before',
				'default'   => [
					'value'   => 'fas fa-star',
					'library' => 'solid',
				],
			]
		);

		$this->add_control(
			'icon_position',
			[
				'label'   => esc_html__( 'Icon Position', 'cardealer-helper' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left'  => esc_html__( 'Before', 'cardealer-helper' ),
					'right' => esc_html__( 'After', 'cardealer-helper' ),
				],
			]
		);

		$this->add_control(
			'icon_indent',
			[
				'label'     => esc_html__( 'Icon Spacing', 'elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .button .icon-position-right' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .button .icon-position-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'alighnment',
			[
				'label'   => esc_html__( 'Alignment', 'elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [
						'title' => esc_html__( 'Left', 'elementor' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'elementor' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'elementor' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_style',
			array(
				'label' => esc_html__( 'Style', 'cardealer-helper' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'global'   => [
					'default' => '',
				],
				'selector' => '{{WRAPPER}} .button',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'elementor' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_color',
			[
				'label'     => esc_html__( 'Background Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .button' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'style' => 'default',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .button.border' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'style' => 'border',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'elementor' ),
			]
		);

		$this->add_control(
			'button_text_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .button:hover, {{WRAPPER}} .button:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label'     => esc_html__( 'Background Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .button:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_border_hover_color',
			[
				'label'     => esc_html__( 'Border Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .button.border:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'style' => 'border',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}
}
