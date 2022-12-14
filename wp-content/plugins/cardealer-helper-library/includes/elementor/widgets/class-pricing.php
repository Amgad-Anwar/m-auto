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
class Pricing extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'pricing';

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
	protected $keywords = array( 'pricing' );

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
		return esc_html__( 'Potenza Pricing', 'cardealer-helper' );
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
			'title',
			[
				'label'       => esc_html__( 'Title', 'cdfs-addon' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter pricing title.', 'cdfs-addon' ),
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'Sub Title', 'cdfs-addon' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter pricing sub title.', 'cdfs-addon' ),
			]
		);

		$this->add_control(
			'price',
			[
				'label'       => esc_html__( 'Price', 'cdfs-addon' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter price. e.g.10.00 $', 'cdfs-addon' ),
			]
		);

		$this->add_control(
			'frequency',
			[
				'label'       => esc_html__( 'Frequency', 'cdfs-addon' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter price. e.g.Per Month', 'cdfs-addon' ),
			]
		);

		$this->add_control(
			'features',
			[
				'label'       => esc_html__( 'Features', 'cdfs-addon' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'Add features. Add each feature on a new line.', 'cdfs-addon' ),
			]
		);

		$this->add_control(
			'btntext',
			[
				'label'       => esc_html__( 'Button Title', 'cdfs-addon' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter button title.', 'cdfs-addon' ),
			]
		);

		$this->add_control(
			'bestseller',
			[
				'label'        => esc_html__( 'Best Seller', 'cdfs-addon' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Enable to display the table as best-seller/featured.', 'cdfs-addon' ),
				'label_on'     => esc_html__( 'Yes', 'cardealer-helper' ),
				'label_off'    => esc_html__( 'No', 'cardealer-helper' ),
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'product_plan',
			[
				'label'       => esc_html__( 'Plan add to cart (Plan ID)', 'cdfs-addon' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( "Note: Work with only 'Subscriptio' plugin", 'cdfs-addon' ),
				'options'     => cdhl_get_pricing_plans(),
			]
		);

		$this->end_controls_section();
	}
}
