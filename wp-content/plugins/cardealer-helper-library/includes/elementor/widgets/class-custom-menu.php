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
class Custom_Menu extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'custom-menu';

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
	protected $keywords = array( 'custom', 'menu' );

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
		return esc_html__( 'Potenza Custom Menu', 'cardealer-helper' );
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

		$custom_menus = array();
		$menus        = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
		if ( is_array( $menus ) && ! empty( $menus ) ) {
			foreach ( $menus as $single_menu ) {
				if ( is_object( $single_menu ) && isset( $single_menu->name, $single_menu->term_id ) ) {
					$custom_menus[ $single_menu->slug ] = $single_menu->name;
				}
			}
		}

		$this->start_controls_section(
			'section_content_general',
			array(
				'label' => esc_html__( 'General', 'cardealer-helper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'nav_menu',
			array(
				'label'       => esc_html__( 'Menu', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'image',
				'options'     => $custom_menus,
				'description' => empty( $custom_menus ) ? esc_html__( 'Custom menus not found. Please visit <b>Appearance > Menus</b> page to create new menu.', 'cardealer-helper' ) : esc_html__( 'Select menu to display.', 'cardealer-helper' ),
			)
		);

		$this->add_control(
			'extra_classes',
			array(
				'label'       => esc_html__( 'Extra class name', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'cardealer-helper' ),
			)
		);

		$this->add_control(
			'custom_menu_style',
			array(
				'label'   => esc_html__( 'Select Menu Style', 'cardealer-helper' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'vertical',
				'options' => array(
					'horizontal' => esc_html__( 'Horizontal', 'cardealer-helper' ),
					'vertical'   => esc_html__( 'Vertical', 'cardealer-helper' ),
				),
			)
		);

		$this->end_controls_section();
	}
}
