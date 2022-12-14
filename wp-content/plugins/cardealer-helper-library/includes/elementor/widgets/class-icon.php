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
class Icon extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'icon';

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
	protected $keywords = array( 'icon' );

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
		return esc_html__( 'Potenza Icon', 'cardealer-helper' );
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
			'icon_color',
			[
				'label'     => __( 'Icon Color', 'plugin-domain' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => \Elementor\Core\Schemes\Color::get_type(),
					'value' => \Elementor\Core\Schemes\Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .potenza-icon > i' => 'color: {{VALUE}}',
				],
				'value'     => '#ffffff',
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label'     => __( 'Icon Size', 'plugin-domain' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 9999,
				'step'      => 1,
				'default'   => 12,
				'selectors' => [
					'{{WRAPPER}} .potenza-icon > i' => 'font-size: {{VALUE}}px',
				],
			]
		);

		$this->add_control(
			'icon_line_height',
			[
				'label'     => __( 'Icon Line Height', 'plugin-domain' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 9999,
				'step'      => 1,
				'default'   => 12,
				'selectors' => [
					'{{WRAPPER}} .potenza-icon > i' => 'line-height: {{VALUE}}px',
				],
			]
		);

		$this->add_control(
			'icon_alignment',
			[
				'label'       => esc_html__( 'Icon Alignment', 'elementor' ),
				'type'        => Controls_Manager::CHOOSE,
				'description' => esc_html__( 'Select Icon Alignment.', 'cardealer-helper' ),
				'options'     => [
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
				'default'     => 'center',
				'selectors'   => [
					'{{WRAPPER}} .potenza-icon' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'icon',
			[
				'label'   => esc_html__( 'Icon', 'cardealer-helper' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-star',
					'library' => 'solid',
				],
			]
		);

		$this->end_controls_section();
	}
}
