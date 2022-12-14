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
class Call_To_Action extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'call-to-action';

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
	protected $keywords = array( 'call', 'to', 'action' );

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
		return esc_html__( 'Potenza Call To Action', 'cardealer-helper' );
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
				'label'       => esc_html__( 'Title', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter action title.', 'cardealer-helper' ),
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'Enter description. Please ensure to add short content.', 'cardealer-helper' ),
			]
		);

		$this->add_control(
			'readmore_link',
			[
				'label'         => esc_html__( 'Read More Url', 'cardealer-helper' ),
				'type'          => Controls_Manager::URL,
				'description'   => esc_html__( 'Enter read more url.', 'cardealer-helper' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);

		$this->add_control(
			'box_bg_image',
			[
				'label'       => esc_html__( 'Background Image', 'cardealer-helper' ),
				'type'        => Controls_Manager::MEDIA,
				'description' => esc_html__( 'Select image.', 'cardealer-helper' ),
				'dynamic'     => [
					'active' => false,
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
