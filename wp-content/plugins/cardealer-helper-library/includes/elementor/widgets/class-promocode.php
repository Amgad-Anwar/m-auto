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
class Promocode extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'promocode';

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
	protected $keywords = array( 'promocode' );

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
		return esc_html__( 'Potenza Promocode', 'cardealer-helper' );
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
			'promo_title',
			[
				'label'       => esc_html__( 'Title', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter title.', 'cardealer-helper' ),
			]
		);

		$this->add_control(
			'title_align',
			[
				'label'       => esc_html__( 'Input Box Align', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'text-left',
				'description' => esc_html__( 'Select input box alignment.', 'cardealer-helper' ),
				'options'     => [
					'text-left'   => esc_html__( 'Left', 'cardealer-helper' ),
					'text-center' => esc_html__( 'Center', 'cardealer-helper' ),
					'text-right'  => esc_html__( 'Right', 'cardealer-helper' ),
				],
			]
		);

		$this->add_control(
			'color_style',
			[
				'label'       => esc_html__( 'Promocode Layout Color', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'promocode-color-light',
				'description' => esc_html__( 'Select color layout.', 'cardealer-helper' ),
				'options'     => [
					'promocode-color-light' => esc_html__( 'Light', 'cardealer-helper' ),
					'promocode-color-dark'  => esc_html__( 'Dark', 'cardealer-helper' ),
				],
			]
		);

		$this->end_controls_section();
	}
}
