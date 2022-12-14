<?php
/**
 * Popup class.
 *
 * @package cardealer-helper/elementor
 * @since   5.0.0
 */

namespace Cdhl_Elementor\Widgets;

use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

use Cdhl_Elementor\Widget_Controller\Widget_Controller;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor popup widget.
 *
 * Elementor widget that displays an popup.
 *
 * @since 5.0.0
 */
class Popup extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'popup';

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
	protected $keywords = array( 'popup' );

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
		return esc_html__( 'Potenza Popup', 'cardealer-helper' );
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
			'section_button_content',
			array(
				'label' => esc_html__( 'Button', 'cardealer-helper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'button_title',
			array(
				'label'       => esc_html__( 'Button Title', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter button title.', 'cardealer-helper' ),
				'default'     => esc_html__( 'Popup', 'cardealer-helper' ),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_popup_content',
			array(
				'label' => esc_html__( 'Popup', 'cardealer-helper' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'important_note_popup_content',
			[
				'label'           => esc_html__( 'Important Note', 'cardealer-helper' ),
				'type'            => \Elementor\Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Adding nested content (like a popup inside a popup) either will not work or break the structure.', 'cardealer-helper' ),
				'content_classes' => 'cardealer-elementor-note',
			]
		);

		$this->add_control(
			'content_source',
			array(
				'label'   => esc_html__( 'Popup Content Source', 'cardealer-helper' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'page',
				'options' => array(
					'page'    => esc_html__( 'Page', 'cardealer-helper' ),
					'content' => esc_html__( 'Content', 'cardealer-helper' ),
				),
			)
		);

		$this->add_control(
			'page_id',
			array(
				'label'       => esc_html__( 'Popup Page', 'cardealer-helper' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'description' => esc_html__( 'Select page to show in popup.', 'cardealer-helper' ),
				'multiple'    => false,
				'options'     => function_exists( 'cdhl_get_list_of_pages' ) ? cdhl_get_list_of_pages() : array(),
				'condition'   => array(
					'content_source' => 'page',
				),
			)
		);

		$this->add_control(
			'popup_content',
			array(
				'label'       => esc_html__( 'Popup Content', 'cardealer-helper' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'placeholder' => esc_html__( 'Enter popup content here.', 'cardealer-helper' ),
				'description' => esc_html__( 'Enter popup content here. You can add shortcode too.', 'cardealer-helper' ),
				'condition'   => array(
					'content_source' => 'content',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_style',
			array(
				'label' => esc_html__( 'Button', 'cardealer-helper' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'button_size',
			array(
				'label'       => esc_html__( 'Button Size', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'medium',
				'description' => esc_html__( 'Select button Size.', 'cardealer-helper' ),
				'options'     => array(
					'extra-small' => esc_html__( 'Extra Small', 'cardealer-helper' ),
					'small'       => esc_html__( 'Small', 'cardealer-helper' ),
					'medium'      => esc_html__( 'Medium', 'cardealer-helper' ),
					'large'       => esc_html__( 'Large', 'cardealer-helper' ),
				),
			)
		);

		$this->add_control(
			'button_btn_full',
			array(
				'label'        => esc_html__( 'Full Width?', 'cardealer-helper' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Check the checkbox to add full width button.', 'cardealer-helper' ),
				'label_on'     => esc_html__( 'Yes', 'cardealer-helper' ),
				'label_off'    => esc_html__( 'No', 'cardealer-helper' ),
				'return_value' => 'true',
			)
		);

		$this->add_control(
			'icon',
			array(
				'label'     => esc_html__( 'Icon', 'cardealer-helper' ),
				'type'      => Controls_Manager::ICONS,
				'separator' => 'before',
				'default'   => array(
					'value'   => 'fas fa-star',
					'library' => 'solid',
				),
			)
		);

		$this->add_control(
			'icon_position',
			array(
				'label'   => esc_html__( 'Icon Position', 'cardealer-helper' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => array(
					'left'  => esc_html__( 'Before', 'cardealer-helper' ),
					'right' => esc_html__( 'After', 'cardealer-helper' ),
				),
			)
		);

		$this->add_control(
			'alighnment',
			array(
				'label'   => esc_html__( 'Alignment', 'cardealer-helper' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'cardealer-helper' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'cardealer-helper' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'cardealer-helper' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default' => 'center',
			)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => esc_html__( 'Normal', 'cardealer-helper' ),
			)
		);

		$this->add_control(
			'button_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'cardealer-helper' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .button' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label'     => esc_html__( 'Background Color', 'cardealer-helper' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .button' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => esc_html__( 'Hover', 'cardealer-helper' ),
			)
		);

		$this->add_control(
			'button_text_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'cardealer-helper' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .button:hover, {{WRAPPER}} .button:focus' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_color',
			array(
				'label'     => esc_html__( 'Background Color', 'cardealer-helper' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .button:before' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_popup_style',
			array(
				'label' => esc_html__( 'Popup', 'cardealer-helper' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'popup_width',
			array(
				'label'      => esc_html__( 'Popup Width', 'cardealer-helper' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 100,
						'max'  => 1800,
						'step' => 5,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 1000,
				),
				'selectors'  => array(
					'{{WRAPPER}} .pgs-popup-content-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

	}
}
