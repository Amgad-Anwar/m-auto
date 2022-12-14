<?php
/**
 * PGSCore Elementor class.
 *
 * @package cardealer-helper/elementor
 * @since   5.0.0
 */

namespace Cdhl_Elementor;

use Elementor;
use Elementor\Plugin;
use Cdhl_Elementor\Widget_Controller;
use Cdhl_Elementor\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Cdhl_Elementor.
 *
 * @since   5.0.0
 */
class Cdhl_Elementor {

	/**
	 * Instance
	 *
	 * @since 5.0.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 5.0.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Class constructor.
	 *
	 * Register plugin action hooks and filters.
	 *
	 * @since 5.0.0
	 * @access public
	 */
	public function __construct() {
		// Register category.
		add_action( 'elementor/init', array( $this, 'register_category' ) );

		// Register controls.
		add_action( 'elementor/controls/controls_registered', array( $this, 'register_controls' ) );

		// Register editor scripts/styles.
		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'editor_styles' ) );

		// Register widgets.
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ) );

		// Register additional icons.
		add_filter( 'elementor/icons_manager/additional_tabs', array( $this, 'register_additional_icons' ) );
	}

	/**
	 * Register potenza category for elementor if not exists
	 *
	 * @return void
	 */
	public function register_category() {

		$elements_manager = Elementor\Plugin::instance()->elements_manager;

		$elements_manager->add_category(
			CDHL_ELEMENTOR_CAT,
			array(
				'title' => esc_html__( 'Potenza', 'cardealer-helper' ),
				'icon'  => 'font',
			)
		);
	}

	/**
	 * Register elementor controles.
	 *
	 * @param object $controls_manager elementor controls manager.
	 * @return void
	 */
	public function register_controls( $controls_manager ) {
		$controls = $this->get_controls_list();

		// Its is now safe to include Control files.
		$available_controls = $this->include_controls_files( $controls );

		foreach ( $available_controls as $control_id => $control_data ) {
			$control_class = false;

			if ( is_array( $control_data ) && isset( $control_data['class'] ) && empty( $control_data['class'] ) ) {
				$control_class = $control_data['class'];
			} else {
				$control_class = '\Cdhl_Elementor\Controls\\' . $control_data;
			}

			if ( $control_class ) {
				$controls_manager->register_control( $control_id, new $control_class() );
			}
		}

	}

	/**
	 * Get elementor controle list.
	 *
	 * @return array
	 */
	private function get_controls_list() {
		// Elementor Controls List.
		$controls = array(
			'pgs_select_image' => 'PGS_Select_Image',
			'pgs_file_upload'  => 'PGS_File_Upload',
		);

		$controls = apply_filters( 'cdhl_elementor_controls', $controls );

		return $controls;
	}

	/**
	 * Include Controls files
	 *
	 * Load controls files
	 *
	 * @param array $controls list of elementor controles.
	 * @since 5.0.0
	 * @access private
	 */
	private function include_controls_files( $controls = array() ) {
		$available_controls = $controls;

		foreach ( $controls as $control_id => $control_data ) {
			$control_path = '';
			if ( is_array( $control_data ) && isset( $control_data['path'] ) && empty( $control_data['path'] ) ) {
				$control_path = $control_data['path'];
			} else {
				$control_filename = str_replace( '_', '-', "controls/{$control_id}/class-{$control_id}.php" );
				$control_path     = trailingslashit( CDHL_ELEMENTOR_PATH ) . $control_filename;
			}

			if ( $control_path && file_exists( $control_path ) ) {
				require_once $control_path;
			} else {
				unset( $available_controls[ $control_id ] );
			}
		}

		return $available_controls;
	}

	/**
	 * Editor scripts
	 *
	 * Enqueue plugin javascripts integrations for Elementor editor.
	 *
	 * @since 5.0.0
	 * @access public
	 */
	public function editor_scripts() {
		// Use minified libraries if SCRIPT_DEBUG is turned off.
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		add_filter( 'script_loader_tag', array( $this, 'editor_scripts_as_a_module' ), 10, 2 );
	}

	/**
	 * Editor styles.
	 *
	 * Enqueue plugin styles integrations for Elementor editor.
	 *
	 * @since 5.0.0
	 * @access public
	 */
	public function editor_styles() {
		$direction_suffix = is_rtl() ? '-rtl' : '';

		wp_enqueue_style( 'cdhl-elementor-flaticon', get_parent_theme_file_uri( '/css/flaticon.min.css' ), array(), CARDEALER_VERSION );
		wp_enqueue_style( 'cdhl-elementor-editor', trailingslashit( CDHL_ELEMENTOR_URL ) . 'assets/css/editor/cdhl-elementor-editor' . $direction_suffix . '.css', array(), CARDEALER_VERSION );
	}

	/**
	 * Force load editor script as a module.
	 *
	 * @since 5.0.0
	 *
	 * @param string $tag      Enqueue tag.
	 * @param string $handle   Enqueue handle.
	 *
	 * @return string
	 */
	public function editor_scripts_as_a_module( $tag, $handle ) {
		if ( 'pgscore-elementor-editor' === $handle ) {
			$tag = str_replace( '<script', '<script type="module"', $tag );
		}

		return $tag;
	}

	/**
	 * Include Widgets files.
	 *
	 * Load widgets files.
	 *
	 * @since 5.0.0
	 * @access private
	 *
	 * @param array $widgets  Array of widgets.
	 */
	private function include_widgets_files( $widgets = array() ) {
		$available_widgets = $widgets;

		foreach ( $widgets as $widget_id => $widget_data ) {
			$widget_path = '';
			if ( is_array( $widget_data ) && isset( $widget_data['path'] ) && empty( $widget_data['path'] ) ) {
				$widget_path = $widget_data['path'];
			} else {
				$widget_path = trailingslashit( CDHL_ELEMENTOR_PATH ) . "widgets/class-{$widget_id}.php";
			}

			if ( $widget_path && file_exists( $widget_path ) ) {
				require_once $widget_path;
			} else {
				unset( $available_widgets[ $widget_id ] );
			}
		}

		return $available_widgets;
	}

	/**
	 * Get all the elementor widget list.
	 */
	private function get_widgets_list() {

		// Elementor Widgets List.
		$widgets = array(
			'button'                   => 'Button',
			'popup'                    => 'Popup',
			'call-to-action'           => 'Call_To_Action',
			'counter'                  => 'Counter',
			'custom-menu'              => 'Custom_Menu',
			'opening-hours'            => 'Opening_Hours',
			'icon'                     => 'Icon',
			'video'                    => 'Video',
			'video-slider'             => 'Video_Slider',
			'clients'                  => 'Clients',
			'image-slider'             => 'Image_Slider',
			'timeline'                 => 'Timeline',
			'lists'                    => 'Lists',
			'newsletter'               => 'Newsletter',
			'quick-links'              => 'Quick_Links',
			'recent-posts'             => 'Recent_Posts',
			'testimonials'             => 'Testimonials',
			'vehicles-conditions-tabs' => 'Vehicles_Conditions_Tabs',
			'vehicles-search'          => 'Vehicles_Search',
			'vehicles-by-type'         => 'Vehicles_By_Type',
			'custom-filters'           => 'Custom_Filters',
			'feature-box'              => 'Feature_Box',
			'feature-box-slider'       => 'Feature_Box_Slider',
			'multi-tab'                => 'Multi_Tab',
			'vertical-multi-tab'       => 'Vertical_Multi_Tab',
			'social-icons'             => 'Social_Icons',
			'vehicles-list'            => 'Vehicles_List',
			'share'                    => 'Share',
			'our-team'                 => 'Our_Team',
			'section-title'            => 'Section_Title',
		);

		if ( cdhl_plugin_active_status( 'cardealer-promocode/cardealer-promocode.php' ) ) {
			$widgets = array_merge(
				$widgets,
				array(
					'promocode'       => 'Promocode',
					'promocode-image' => 'Promocode_Image',
				)
			);
		}

		if ( class_exists( 'CDFS_Autoloader' ) ) {
			$widgets = array_merge(
				$widgets,
				array(
					'pricing' => 'Pricing',
				)
			);
		}

		$widgets = apply_filters( 'cdhl_elementor_widgets', $widgets );

		return $widgets;

	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 5.0.0
	 * @access public
	 */
	public function register_widgets() {

		$widgets = $this->get_widgets_list();

		require_once trailingslashit( CDHL_ELEMENTOR_PATH ) . 'class-widget-controller.php';

		// Its is now safe to include Widgets files.
		$available_widgets = $this->include_widgets_files( $widgets );

		foreach ( $available_widgets as $widget_id => $widget_data ) {
			$widget_class = false;

			if ( is_array( $widget_data ) && isset( $widget_data['class'] ) && empty( $widget_data['class'] ) ) {
				$widget_class = $widget_data['class'];
			} else {
				$widget_class = '\Cdhl_Elementor\Widgets\\' . $widget_data;
			}

			if ( $widget_class ) {
				\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new $widget_class() );
			}
		}

	}

	/**
	 * Register Additional Icons
	 *
	 * @since 5.0.0
	 *
	 * @param array $settings icon arguments.
	 * @access public
	 */
	public function register_additional_icons( $settings ) {

		// Flaticon.
		$settings['flaticon'] = array(
			'name'          => 'flaticon',
			'label'         => esc_html__( 'Flaticon', 'cardealer-helper' ),
			'url'           => '',
			'enqueue'       => '',
			'prefix'        => '',
			'displayPrefix' => '',
			'labelIcon'     => 'glyph-icon flaticon-air-conditioning',
			'ver'           => '1.0',
			'fetchJson'     => CDHL_URL . 'includes/elementor/assets/js/icons/flaticon.js',
		);

		return $settings;
	}

}

// Instantiate Cdhl_Elementor Class.
Cdhl_Elementor::instance();
