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
use Elementor\Group_Control_Typography;

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
class Share extends Widget_Controller {

	/**
	 * Widget slug
	 *
	 * @var string
	 */
	protected $widget_slug = 'share';

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
	protected $keywords = array( 'share' );

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
		return esc_html__( 'Potenza Share', 'cardealer-helper' );
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
			'add_color',
			[
				'label'        => esc_html__( 'Add Color?', 'cardealer-helper' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Check this to add background color to shortcode elements.', 'cardealer-helper' ),
				'label_on'     => esc_html__( 'Yes', 'cardealer-helper' ),
				'label_off'    => esc_html__( 'No', 'cardealer-helper' ),
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'font_color',
			[
				'label'       => esc_html__( 'Font Color', 'cardealer-helper' ),
				'type'        => Controls_Manager::COLOR,
				'default'     => '#eeeeee',
				'description' => esc_html__( 'Select font color for shortcode elements.', 'cardealer-helper' ),
				'selectors'   => [
					'{{WRAPPER}} .pdf'                       => 'color: {{VALUE}};',
					'{{WRAPPER}} .share'                     => 'color: {{VALUE}};',
					'{{WRAPPER}} .share .list-unstyled li a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .share span'                => 'color: {{VALUE}};',
					'{{WRAPPER}} .fa-file-pdf'               => 'color: {{VALUE}};',
					'{{WRAPPER}} .pdf .info a'               => 'color: {{VALUE}};',
					'{{WRAPPER}} .see-video'                 => 'color: {{VALUE}};',
					'{{WRAPPER}} .see-video .icon i'         => 'color: {{VALUE}};',
					'{{WRAPPER}} .popup-youtube'             => 'color: {{VALUE}};',
				],
				'condition'   => [
					'add_color' => 'true',
				],
			]
		);

		$this->add_control(
			'back_color',
			[
				'label'       => esc_html__( 'Background Color', 'cardealer-helper' ),
				'type'        => Controls_Manager::COLOR,
				'description' => esc_html__( 'Select background color for shortcode elements.', 'cardealer-helper' ),
				'default'     => '#ffffff',
				'selectors'   => [
					'{{WRAPPER}} .pdf'       => 'background: {{VALUE}};',
					'{{WRAPPER}} .see-video' => 'background: {{VALUE}};',
					'{{WRAPPER}} .share'     => 'background: {{VALUE}};',
				],
				'condition'   => [
					'add_color' => 'true',
				],
			]
		);

		$this->add_control(
			'add_pdf',
			[
				'label'        => esc_html__( 'Add PDF?', 'cardealer-helper' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Check this to add PDF option.', 'cardealer-helper' ),
				'label_on'     => esc_html__( 'Yes', 'cardealer-helper' ),
				'label_off'    => esc_html__( 'No', 'cardealer-helper' ),
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'pdf_label',
			[
				'label'       => esc_html__( 'PDF Label', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'See PDF', 'cardealer-helper' ),
				'description' => esc_html__( 'Enter label for PDF to be uploaded.', 'cardealer-helper' ),
				'condition'   => [
					'add_pdf' => 'true',
				],
			]
		);

		$this->add_control(
			'pdf_file',
			[
				'label'       => esc_html__( 'Select PDF File', 'cardealer-helper' ),
				'type'        => 'pgs_file_upload',
				'mime_type'   => 'application/pdf',
				'description' => esc_html__( 'Upload only .pdf files.', 'cardealer-helper' ),
				'condition'   => [
					'add_pdf' => 'true',
				],
			]
		);

		$this->add_control(
			'add_video',
			[
				'label'        => esc_html__( 'Add Video?', 'cardealer-helper' ),
				'type'         => Controls_Manager::SWITCHER,
				'description'  => esc_html__( 'Check this to add video option.', 'cardealer-helper' ),
				'label_on'     => esc_html__( 'Yes', 'cardealer-helper' ),
				'label_off'    => esc_html__( 'No', 'cardealer-helper' ),
				'return_value' => 'true',
			]
		);

		$this->add_control(
			'video_label',
			[
				'label'       => esc_html__( 'Video Label', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'See Video', 'cardealer-helper' ),
				'description' => esc_html__( 'Enter label for Video to be displayed.', 'cardealer-helper' ),
				'condition'   => [
					'add_video' => 'true',
				],
			]
		);

		$this->add_control(
			'video_url',
			[
				'label'       => esc_html__( 'Video URL', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter video URL to display video. Enter only youtube or vimeo video link.', 'cardealer-helper' ),
				'condition'   => [
					'add_video' => 'true',
				],
			]
		);

		$this->add_control(
			'social_icons_label',
			[
				'label'       => esc_html__( 'Social Icons Label', 'cardealer-helper' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Share', 'cardealer-helper' ),
				'description' => esc_html__( 'Enter label for social icons to be displayed.', 'cardealer-helper' ),
				'condition'   => [
					'add_video' => 'true',
				],
			]
		);

		$this->add_control(
			'social_icons',
			[
				'label'       => esc_html__( 'Select Social Icons', 'cardealer-helper' ),
				'type'        => Controls_Manager::SELECT2,
				'description' => esc_html__( 'Select social media icons to include within share', 'cardealer-helper' ),
				'multiple'    => true,
				'options'     => [
					'facebook'    => esc_html__( 'Facebook', 'cardealer-helper' ),
					'twitter'     => esc_html__( 'Twitter', 'cardealer-helper' ),
					'linkedin'    => esc_html__( 'LinkedIn', 'cardealer-helper' ),
					'google-plus' => esc_html__( 'Google Plus', 'cardealer-helper' ),
					'pinterest'   => esc_html__( 'Pinterest', 'cardealer-helper' ),
				],
			]
		);

		$this->end_controls_section();
	}
}
