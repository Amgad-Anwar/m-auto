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
class Social_Icons extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'social-icons';

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
	protected $keywords = array( 'social', 'icons' );

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
		return esc_html__( 'Potenza Social Icons', 'cardealer-helper' );
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
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_social_icons/style-1.png',
					),
					'style-2' => array(
						'label' => esc_html__( 'Style 2', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_social_icons/style-2.png',
					),
					'style-3' => array(
						'label' => esc_html__( 'Style 3', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_social_icons/style-3.png',
					),
				),
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'title',
			array(
				'label'       => esc_html__( 'Title', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Add item Title.', 'cardealer-helper' ),
			)
		);

		$repeater->add_control(
			'icon_class',
			array(
				'label'       => esc_html__( 'Icon Class', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf(
					wp_kses(
						/* translators: $s: You can get icons classes from */
						__( 'You can get icons classes from <strong><a target="blank" href="%1$s">here</a></strong>.', 'cardealer-helper' ),
						array(
							'a'      => array(
								'href'   => array(),
								'target' => array(),
							),
							'strong' => array(),
						)
					),
					esc_url( 'http://fontawesome.io/icons/' )
				),
			)
		);

		$repeater->add_control(
			'link_url',
			[
				'label'         => esc_html__( 'Link URL', 'cardealer-helper' ),
				'type'          => Controls_Manager::URL,
				'description'   => esc_html__( 'Social Link.', 'cardealer-helper' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);

		$this->add_control(
			'list_items',
			array(
				'label'       => esc_html__( 'List Items', 'cardealer-helper' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ title }}}',
			)
		);

		$this->end_controls_section();
	}
}
