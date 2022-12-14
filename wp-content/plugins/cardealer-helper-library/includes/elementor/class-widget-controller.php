<?php
/**
 * Widget Controller class.
 *
 * @package cardealer-helper/elementor
 * @since   5.0.0
 */

namespace Cdhl_Elementor\Widget_Controller;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Widget_Controller.
 *
 * @since   5.0.0
 */
class Widget_Controller extends Widget_Base {

	/**
	 * Widget prefix.
	 *
	 * @var string
	 */
	protected $widget_slug_prefix = 'cdhl_';

	/**
	 * Widget Icon.
	 *
	 * @var string
	 */
	protected $widget_icon = 'eicon-settings';

	/**
	 * Retrieve the widget name.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return $this->widget_slug_prefix . $this->widget_slug;
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {

		if ( ! isset( $this->widget_icon ) || empty( $this->widget_icon ) ) {
			$this->widget_icon = 'eicon-settings';
		}

		return $this->widget_icon;
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( CDHL_ELEMENTOR_CAT );
	}

	/**
	 * Get keywords.
	 */
	public function get_keywords() {
		$keywords = array_merge( array( 'pgs', 'potenza' ), (array) $this->keywords );
		return $keywords;
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 5.0.0
	 *
	 * @access protected
	 */
	protected function render() {

		$settings    = $this->get_settings_for_display();
		$widget_slug = $this->get_widget_slug();
		$widget      = $this;

		$this->widget_wrapper_attributes();

		$this->get_templates( "{$this->widget_slug}/{$this->widget_slug}", null, array( 'settings' => $settings ) );
	}

	/**
	 * Get the all widget slugs.
	 */
	public function get_widget_slug() {
		$search_str  = 'pgscore_';
		$widget_name = $this->get_name();
		$widget_slug = $this->get_name();

		if ( substr( $widget_name, 0, strlen( $search_str ) ) === $search_str ) {
			$widget_slug = str_replace( $search_str, '', $widget_name );
		}

		return $widget_slug;
	}

	/**
	 * Set the widget attributes.
	 */
	protected function widget_wrapper_attributes() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'widget_wrapper', 'class', $this->get_name() . '_wrapper' );

		if ( isset( $settings['_element_id'] ) && ! empty( $settings['_element_id'] ) ) {
			$this->add_render_attribute( 'widget_wrapper', 'id', $settings['_element_id'] );
		}

		if ( isset( $settings['_css_classes'] ) && ! empty( $settings['_css_classes'] ) ) {
			$this->add_render_attribute( 'widget_wrapper', 'class', $settings['_css_classes'] );
		}

	}

	/**
	 * Add widget render attributes.
	 *
	 * Used to add attributes to the current widget wrapper HTML tag.
	 *
	 * @since 5.0.0
	 * @access protected
	 */
	protected function _add_render_attributes() {
		parent::_add_render_attributes();

		$settings = $this->get_settings();

		$this->remove_render_attribute( '_wrapper', 'id' );
	}

	/**
	 * Get shortcode template parts.
	 *
	 * @param string $slug slug of widget.
	 * @param string $name name of widget.
	 * @param array  $args argument for widget.
	 */
	public function get_templates( $slug, $name = null, $args = array() ) {
		$template      = '';
		$template_path = 'template-parts/elementor/';
		$plugin_path   = trailingslashit( CDHL_PATH );

		// Look in yourtheme/template-parts/elementor/slug-name.php.
		if ( $name ) {
			$template = locate_template(
				array(
					$template_path . "{$slug}-{$name}.php",
				)
			);
		}

		// Get default slug-name.php.
		if ( ! $template && $name && file_exists( $plugin_path . "elementor-templates/{$slug}-{$name}.php" ) ) {
			$template = $plugin_path . "elementor-templates/{$slug}-{$name}.php";
		}

		// If template file doesn't exist, look in yourtheme/template-parts/elementor/slug.php.
		if ( ! $template ) {
			$template = locate_template(
				array(
					$template_path . "{$slug}.php",
				)
			);
		}

		// Get default slug.php.
		if ( ! $template && file_exists( $plugin_path . "elementor-templates/{$slug}.php" ) ) {
			$template = $plugin_path . "elementor-templates/{$slug}.php";
		}

		// Allow 3rd party plugins to filter template file from their plugin.
		$template = apply_filters( 'pgscore_get_elementor_templates', $template, $slug, $name );

		if ( $template ) {
			if ( isset( $args['settings'] ) ) {
				$settings = $args['settings'];
			}
			require $template;
		}
	}

}
