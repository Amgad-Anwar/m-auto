<?php
/**
 * Include elementor files.
 *
 * @author  TeamWP @Potenza Global Solutions
 * @package car-dealer-helper/functions
 * @version 1.0.0
 */

// Define PGSCORE_INC_PATH and PGSCORE_INC_URL.
define( 'CDHL_ELEMENTOR_PATH', trailingslashit( CDHL_PATH ) . 'includes/elementor' );
define( 'CDHL_ELEMENTOR_URL', trailingslashit( CDHL_URL ) . 'includes/elementor' );
define( 'CDHL_ELEMENTOR_CAT', 'aqb-potenza' );

add_action( 'plugins_loaded', 'cdhl_elementor_init' );

/**
 * Elementor Init
 */
function cdhl_elementor_init() {
	require_once trailingslashit( CDHL_ELEMENTOR_PATH ) . 'class-cdhl-elementor.php';
}

/**
 * Reorder Widget Categories.
 * Ref: https://github.com/elementor/elementor/issues/7445#issuecomment-472822406
 */
function add_elementor_widget_categories( \Elementor\Elements_Manager $elements_manager ) {

	$category_prefix = 'aqb-';

	$elements_manager->add_category(
		CDHL_ELEMENTOR_CAT,
		array(
			'title' => esc_html__( 'Potenza Elements', 'cardealer-helper' ),
			'icon'  => 'font',
		)
	);

	// Hack into the private $categories member, and reorder it so our stuff is at the top.
	$reorder_cats = function() use( $category_prefix ) {
		uksort( $this->categories, function( $keyOne, $keyTwo ) use( $category_prefix ) {
			if ( substr( $keyOne, 0, 4 ) == $category_prefix ) {
				return -1;
			}
			if ( substr( $keyTwo, 0, 4 ) == $category_prefix ) {
				return 1;
			}
			return 0;
		});
	};

	$reorder_cats->call( $elements_manager );
}
add_action( 'elementor/elements/categories_registered', 'add_elementor_widget_categories' );
