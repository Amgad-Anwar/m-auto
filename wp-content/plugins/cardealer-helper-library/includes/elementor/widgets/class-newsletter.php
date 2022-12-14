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
class Newsletter extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'newsletter';

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
	protected $keywords = array( 'newsletter' );

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
		return esc_html__( 'Potenza Newsletter', 'cardealer-helper' );
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
			'newsletter_title',
			[
				'label'       => esc_html__( 'Title', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter title here', 'cardealer-helper' ),
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .news-letter-main h4' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => sprintf(
					wp_kses(
						/* translators: $s: Enter description */
						__( 'Enter description. Please ensure to add short content.<br> Please set both your MailChimp API key and list id in the API Keys panel. <a href="%1$s" target="_blank">Add API key here</a>', 'cardealer-helper' ),
						array(
							'br' => array(),
							'a'  => array(
								'href'   => array(),
								'target' => array(),
							),
						)
					),
					esc_url( esc_url( site_url( 'wp-admin/admin.php?page=cardealer' ) ) )
				),
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Description Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .news-letter-main p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'color_style',
			[
				'label'       => esc_html__( 'Newsletter Layout Color', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'newsletter-color-dark',
				'description' => esc_html__( 'Select video position.', 'cardealer-helper' ),
				'options'     => [
					'newsletter-color-light' => esc_html__( 'Light', 'cardealer-helper' ),
					'newsletter-color-dark'  => esc_html__( 'Dark', 'cardealer-helper' ),
				],
			]
		);

		$this->end_controls_section();
	}
}
