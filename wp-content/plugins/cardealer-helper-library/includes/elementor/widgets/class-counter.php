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
class Counter extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'counter';

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
	protected $keywords = array( 'counter' );

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
		return esc_html__( 'Potenza Counter', 'cardealer-helper' );
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
				'default'     => 'style-1',
				'description' => esc_html__( 'Select the style.', 'cardealer-helper' ),
				'options'     => [
					'style-1' => esc_html__( 'Style 1', 'cardealer-helper' ),
					'style-2' => esc_html__( 'Style 2', 'cardealer-helper' ),
					'style-3' => esc_html__( 'Style 3', 'cardealer-helper' ),
					'style-4' => esc_html__( 'Style 4', 'cardealer-helper' ),
				],
			]
		);

		$this->add_control(
			'label',
			[
				'label'       => esc_html__( 'Label', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter counter label.', 'cardealer-helper' ),
			]
		);

		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Label Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .counter h6' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'separator_color',
			[
				'label'     => esc_html__( 'Separator Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
				    'style' => [ 'style-1', 'style-4' ]
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .counter-style-1 h6:before' => 'background: {{VALUE}};',
					'{{WRAPPER}} .counter.left-separator .separator:before, {{WRAPPER}} .counter.left-separator .separator:after' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'counter',
			[
				'label'       => esc_html__( 'Counter', 'cardealer-helper' ),
				'type'        => Controls_Manager::NUMBER,
				'separator'   => 'before',
				'description' => esc_html__( 'Enter counter count.', 'cardealer-helper' ),
				'min'         => '1',
				'max'         => '9999999',
			]
		);

		$this->add_control(
			'counter_speed',
			[
				'label'       => esc_html__( 'Counter Speed', 'cardealer-helper' ),
				'type'        => Controls_Manager::NUMBER,
				'separator'   => 'before',
				'description' => esc_html__( 'Enter counter speed in milliseconds.', 'cardealer-helper' ),
				'min'         => '500',
				'max'         => '20000',
				'default'     => '10000',
			]
		);

		$this->add_control(
			'counter_color',
			[
				'label'     => esc_html__( 'Counter Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .counter b' => 'color: {{VALUE}};',
				],
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
			'icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .counter i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}
}
