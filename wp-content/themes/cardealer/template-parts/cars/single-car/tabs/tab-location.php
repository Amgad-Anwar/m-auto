<?php
global $car_dealer_options;
$car_id = get_the_ID();
$lat    = '';
$lan    = '';

if ( ( isset( $car_dealer_options['default_value_lat'] ) && ! empty( $car_dealer_options['default_value_lat'] ) ) && ( isset( $car_dealer_options['default_value_long'] ) && ! empty( $car_dealer_options['default_value_long'] ) ) ) {
	$lat = $car_dealer_options['default_value_lat'];
	$lan = $car_dealer_options['default_value_long'];
}
$location = get_post_meta( $car_id, 'vehicle_location', true );

if ( ! empty( $location['address'] ) ) {
	$lat = $location['lat'];
	$lan = $location['lng'];
	if ( empty( $lat ) && ! empty( $lan ) ) {

		$get_lat_long = cardealer_getLatLnt( $location['address'] );
		$latitude     = ! empty( $get_lat_long['lat'] ) ? $get_lat_long['lat'] : '';
		$longitude    = ! empty( $get_lat_long['lng'] ) ? $get_lat_long['lng'] : '';

		// map location.
		if ( ! empty( $latitude ) && ! empty( $longitude ) ) {
			$new_location = array(
				'address' => $location['address'],
				'lat'     => $latitude,
				'lng'     => $longitude,
				'zoom'    => '10',
			);
			if ( '1' === $get_lat_long['addr_found'] ) {
				update_field( 'vehicle_location', $new_location, $car_id );
				$location = $new_location;
				$lat      = $location['lat'];
				$lan      = $location['lng'];
			}
		}
	}
} elseif ( ! empty( $location['lat'] ) && ! empty( $location['lng'] ) ) {
	$lat = $location['lat'];
	$lan = $location['lng'];
}
?>
<div class="acf-map">
	<div class="marker" data-lat="<?php echo esc_attr( $lat ); ?>" data-lng="<?php echo esc_attr( $lan ); ?>" style="text-align: center;top: calc( 50% - 11px );position: relative;"><i aria-hidden="true" class="fas fa-map-marker-alt"></i> <?php echo esc_html__( 'Loading...', 'cardealer' ); ?></div>
</div>
