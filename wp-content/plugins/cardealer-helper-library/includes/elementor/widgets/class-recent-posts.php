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
class Recent_Posts extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'recent-posts';

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
	protected $keywords = array( 'recent', 'posts' );

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
		return esc_html__( 'Potenza Recent Posts', 'cardealer-helper' );
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

		$thumbnail_sizes = cdhl_get_image_sizes();

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
				'default'     => 'grid',
				'description' => esc_html__( 'Select style.', 'cardealer-helper' ),
				'options'     => [
					'grid' => esc_html__( 'Grid View', 'cardealer-helper' ),
					'list' => esc_html__( 'List View', 'cardealer-helper' ),
				],
			]
		);

		$this->add_control(
			'thumbnail_size',
			[
				'label'       => esc_html__( 'Thumbnail Size', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'medium_large',
				'description' => esc_html__( 'Choose thumbnail size.', 'cardealer-helper' ),
				'options'     => array_flip( $thumbnail_sizes ),
			]
		);

		$this->add_control(
			'no_of_posts',
			[
				'label'       => esc_html__( 'Post Counts', 'cardealer-helper' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => esc_html__( 'Enter number of posts to display.', 'cardealer-helper' ),
			]
		);

		$this->add_control(
			'no_of_columns',
			[
				'label'       => esc_html__( 'Columns', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 2,
				'description' => esc_html__( 'If sidebar is active then number of column can be set to 1 or 2.', 'cardealer-helper' ),
				'options'     => [
					2 => 2,
					3 => 3,
					4 => 4,
				],
				'condition'   => array(
					'style' => 'grid',
				),
			]
		);

		$this->add_control(
			'detail_link_title',
			[
				'label'       => esc_html__( 'Detail Link Title', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter detail link title.', 'cardealer-helper' ),
				'condition'   => array(
					'style' => 'list',
				),
			]
		);

		$this->end_controls_section();
	}
}
