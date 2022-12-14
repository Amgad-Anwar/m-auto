<?php
/**
 * Visual Composer Shortcode
 *
 * @author  TeamWP @Potenza Global Solutions
 * @package car-dealer-helper/functions
 * @version 1.0.0
 */

/**
 * Enable shortcodes in widgets.
 */
add_filter( 'widget_text', 'do_shortcode' );


if ( ! function_exists( 'cdhl_shortcodes_loader' ) ) {
	/**
	 * Shortcodes Loader
	 */
	function cdhl_shortcodes_loader() {
		if ( cdhl_plugin_active_status( 'js_composer/js_composer.php' ) ) {
			$shortcodes_path = trailingslashit( CDHL_PATH ) . 'includes/shortcodes/';
			if ( is_dir( $shortcodes_path ) ) {

				// shortcodes List.
				$shortcodes = array(
					$shortcodes_path . 'button.php',
					$shortcodes_path . 'popup.php',
					$shortcodes_path . 'call-to-action.php',
					$shortcodes_path . 'cars_custom_filters.php',
					$shortcodes_path . 'cars-condition-carousel.php',
					$shortcodes_path . 'cars-search.php',
					$shortcodes_path . 'cars-type-search.php',
					$shortcodes_path . 'clients.php',
					$shortcodes_path . 'counter.php',
					$shortcodes_path . 'custom-menu.php',
					$shortcodes_path . 'feature-box.php',
					$shortcodes_path . 'icon.php',
					$shortcodes_path . 'image-slider.php',
					$shortcodes_path . 'list.php',
					$shortcodes_path . 'multi_tab.php',
					$shortcodes_path . 'newsletter.php',
					$shortcodes_path . 'opening_hours.php',
					$shortcodes_path . 'our-team.php',
					$shortcodes_path . 'pgs-cars-carousel.php',
					$shortcodes_path . 'quick_links.php',
					$shortcodes_path . 'recent-posts.php',
					$shortcodes_path . 'section_title.php',
					$shortcodes_path . 'share.php',
					$shortcodes_path . 'social_icons.php',
					$shortcodes_path . 'space.php',
					$shortcodes_path . 'testimonials.php',
					$shortcodes_path . 'timeline.php',
					$shortcodes_path . 'vc_row.php',
					$shortcodes_path . 'vertical_multi_tab.php',
					$shortcodes_path . 'video.php',
					$shortcodes_path . 'video-slider.php',
				);

				if ( cdhl_plugin_active_status( 'cardealer-promocode/cardealer-promocode.php' ) ) {
					$shortcodes = array_merge( $shortcodes,
						array(
							$shortcodes_path . 'promocode.php',
							$shortcodes_path . 'promocode-image.php',
						)
					);
				}

				$shortcodes = apply_filters( 'cdhl_shortcodes_loader', $shortcodes );
				if ( ! empty( $shortcodes ) ) {
					foreach ( $shortcodes as $shortcode ) {
						include $shortcode;
					}
				}
			}
		}
	}
}

cdhl_shortcodes_loader();

if ( ! function_exists( 'cdhl_elementor_template' ) ) {
	/**
	 * New shortcde for Elementor template
	 *
	 * @param array $atts attribute.
	 */
	function cdhl_elementor_template( $atts ) {
		extract(
			shortcode_atts(
				array(
					'id' => 0,
				),
				$atts
			)
		);

		ob_start();

		$template = new \Elementor\Frontend();
		echo $template->get_builder_content_for_display( $id, true ); // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped

		return ob_get_clean();
	}
	add_shortcode( 'cdhl_elementor_template', 'cdhl_elementor_template' );
}
