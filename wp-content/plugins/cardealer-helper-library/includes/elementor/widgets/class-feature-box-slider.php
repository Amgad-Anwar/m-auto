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
class Feature_Box_Slider extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'feature-box-slider';

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
	protected $keywords = array( 'feature', 'box', 'slider' );

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
		return esc_html__( 'Potenza Feature Box Slider', 'cardealer-helper' );
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

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'style',
			array(
				'label'       => esc_html__( 'Style', 'cardealer-helper' ),
				'type'        => 'pgs_select_image',
				'description' => esc_html__( 'Select the style.', 'cardealer-helper' ),
				'default'     => 'style-1',
				'options'     => array(
					'style-1'  => array(
						'label' => esc_html__( 'Style 1', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_feature_box/style-1.png',
					),
					'style-2'  => array(
						'label' => esc_html__( 'Style 2', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_feature_box/style-2.png',
					),
					'style-3'  => array(
						'label' => esc_html__( 'Style 3', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_feature_box/style-3.png',
					),
					'style-4'  => array(
						'label' => esc_html__( 'Style 4', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_feature_box/style-4.png',
					),
					'style-5'  => array(
						'label' => esc_html__( 'Style 5', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_feature_box/style-5.png',
					),
					'style-6'  => array(
						'label' => esc_html__( 'Style 6', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_feature_box/style-6.png',
					),
					'style-7'  => array(
						'label' => esc_html__( 'Style 7', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_feature_box/style-7.png',
					),
					'style-8'  => array(
						'label' => esc_html__( 'Style 8', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_feature_box/style-8.png',
					),
					'style-9'  => array(
						'label' => esc_html__( 'Style 9', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_feature_box/style-9.png',
					),
					'style-10' => array(
						'label' => esc_html__( 'Style 10', 'cardealer-helper' ),
						'image' => trailingslashit( CDHL_URL ) . 'includes/vc/vc_images/options/cd_feature_box/style-10.png',
					),
				),
			)
		);

		$repeater->add_control(
			'border',
			[
				'label'        => esc_html__( 'Title Border', 'cardealer-helper' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Set Title Border.', 'cardealer-helper' ),
				'label_on'     => esc_html__( 'Yes', 'cardealer-helper' ),
				'label_off'    => esc_html__( 'No', 'cardealer-helper' ),
				'return_value' => 'true',
				'condition'    => array(
					'style' => array( 'style-1', 'style-2', 'style-3' ),
				),
			]
		);

		$repeater->add_control(
			'title_border_color',
			[
				'label'     => esc_html__( 'Title Border Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'condition' => [
					'border' => [ 'true' ],
					'style'  => [ 'style-1', 'style-2', 'style-3' ],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.feature-box.feature-border.round-icon h6:before' => 'background: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'back_image',
			[
				'label'        => esc_html__( 'Add Background Image?', 'cardealer-helper' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Click checkbox to add backgound image to feature box', 'cardealer-helper' ),
				'label_on'     => esc_html__( 'Yes', 'cardealer-helper' ),
				'label_off'    => esc_html__( 'No', 'cardealer-helper' ),
				'return_value' => 'true',
				'condition'    => array(
					'style' => array( 'style-10' ),
				),
			]
		);

		$repeater->add_control(
			'back_image_url',
			[
				'label'       => esc_html__( 'Background Image', 'cardealer-helper' ),
				'type'        => Controls_Manager::MEDIA,
				'description' => esc_html__( 'Select background image.', 'cardealer-helper' ),
				'condition'   => array(
					'back_image' => 'true',
					'style'      => 'style-10',
				),
			]
		);

		$repeater->add_control(
			'hover_style',
			[
				'label'        => esc_html__( 'Add Hover Style?', 'cardealer-helper' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Click checkbox to add hover style to element', 'cardealer-helper' ),
				'label_on'     => esc_html__( 'Yes', 'cardealer-helper' ),
				'label_off'    => esc_html__( 'No', 'cardealer-helper' ),
				'return_value' => 'true',
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter title here', 'cardealer-helper' ),
			]
		);

		$repeater->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.feature-box h6' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'url',
			[
				'label'         => esc_html__( 'Link', 'cardealer-helper' ),
				'type'          => Controls_Manager::URL,
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => true,
					'nofollow'    => true,
				],
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'Enter description. Please ensure to add short content.', 'cardealer-helper' ),
				'condition'   => array(
					'style!' => 'style-10',
				),
			]
		);

		$repeater->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Description Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'style!' => 'style-10',
				),
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.feature-box p' => 'color: {{VALUE}};',
				],
				'condition' => array(
					'style!' => 'style-10',
				),
			]
		);

		$repeater->add_control(
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

		$repeater->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.feature-box i'                       => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}}.feature-box.style-8 .icon i:before'  => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}}.feature-box.style-10 .icon i:before' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'icon_bg-color',
			[
				'label'     => esc_html__( 'Icon Background Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'style' => [ 'style-1', 'style-2', 'style-3', 'style-7' ],
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.feature-box i'                  => 'background: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}}.feature-box.round-border .icon' => 'border-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'icon_color_hover',
			[
				'label'     => esc_html__( 'Icon Hover Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'condition' => [
					'hover_style' => [ 'true' ],
					'style'       => [ 'style-1', 'style-2', 'style-3', 'style-7' ],
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.feature-box.box-hover:hover i'                      => 'color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}}.feature-box.style-8.box-hover:hover .icon i:before' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'icon_bg-color_hover',
			[
				'label'     => esc_html__( 'Icon Background Hover Color', 'elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'hover_style' => [ 'true' ],
					'style'       => [ 'style-1', 'style-2', 'style-3', 'style-7' ],
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}.feature-box.box-hover:hover i'                  => 'background: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}}.feature-box.round-border.box-hover:hover .icon' => 'border-color: {{VALUE}};',
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
