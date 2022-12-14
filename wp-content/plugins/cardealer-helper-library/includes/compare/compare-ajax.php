<?php
/**
 * This function used to compare cars.
 *
 * @author  TeamWP @Potenza Global Solutions
 * @package car-dealer-helper
 */

add_action( 'wp_ajax_car_compare_action', 'cdhl_car_compare_action' );
add_action( 'wp_ajax_nopriv_car_compare_action', 'cdhl_car_compare_action' );
if ( ! function_exists( 'cdhl_car_compare_action' ) ) {
	/**
	 * Get compare option
	 */
	function cdhl_car_compare_action() {
		$car_ids     = ( isset( $_REQUEST['car_ids'] ) && ! empty( $_REQUEST['car_ids'] ) ) ? json_decode( sanitize_text_field( wp_unslash( $_REQUEST['car_ids'] ) ), true ) : array(); // phpcs:ignore WordPress.Security.NonceVerification
		$num_of_cars = count( $car_ids );

		if ( empty( $car_ids ) ) {
			return;
		}
		cdhl_get_template_part( 'content-compare', '', array(
			'car_ids'        => $car_ids,
			'num_of_cars'    => $num_of_cars,
			'compare_fields' => cdhl_compare_column_fields(),
		) );
		die;
	}
}
