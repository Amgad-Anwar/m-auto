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
class Opening_Hours extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'opening-hours';

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
	protected $keywords = array( 'opening', 'hours' );

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
		return esc_html__( 'Potenza Opening Hours', 'cardealer-helper' );
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
			'opening_hours_title',
			[
				'label'       => esc_html__( 'Title', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter the title', 'cardealer-helper' ),
				'value'       => esc_html__( 'Opening Hours', 'cardealer-helper' ),
			]
		);

		$this->add_control(
			'day_monday',
			[
				'label'       => esc_html__( 'Monday', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter Monday Time. Leave blank if close', 'cardealer-helper' ),
			]
		);

		$this->add_control(
			'day_tuesday',
			[
				'label'       => esc_html__( 'Tuesday', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter Tuesday Time. Leave blank if close', 'cardealer-helper' ),
			]
		);

		$this->add_control(
			'day_wednesday',
			[
				'label'       => esc_html__( 'Wednesday', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter Wednesday Time. Leave blank if close', 'cardealer-helper' ),
			]
		);

		$this->add_control(
			'day_thursday',
			[
				'label'       => esc_html__( 'Thursday', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter Thursday Time. Leave blank if close', 'cardealer-helper' ),
			]
		);

		$this->add_control(
			'day_friday',
			[
				'label'       => esc_html__( 'Friday', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter Friday Time. Leave blank if close', 'cardealer-helper' ),
			]
		);

		$this->add_control(
			'day_saturday',
			[
				'label'       => esc_html__( 'Saturday', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter Saturday Time. Leave blank if close', 'cardealer-helper' ),
			]
		);

		$this->add_control(
			'day_sunday',
			[
				'label'       => esc_html__( 'Sunday', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter Sunday Time. Leave blank if close', 'cardealer-helper' ),
			]
		);

		$this->end_controls_section();
	}
}
