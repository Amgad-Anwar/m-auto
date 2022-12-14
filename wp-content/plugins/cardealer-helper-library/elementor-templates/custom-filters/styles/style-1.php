<?php
/**
 * Custom filters Elementor widget template style 1
 *
 * @package car-dealer-helper
 */

// phpcs:disable WordPress.Security.NonceVerification.Recommended
global $car_dealer_options;

$cars_filters               = isset( $settings['cars_filters'] ) ? $settings['cars_filters'] : '';
$src_button_label           = isset( $settings['src_button_label'] ) ? $settings['src_button_label'] : '';
$step                       = isset( $car_dealer_options['price_range_step'] ) && $car_dealer_options['price_range_step'] ? $car_dealer_options['price_range_step'] : 100;
$cars_year_range_slider_cfb = isset( $settings['cars_year_range_slider_cfb'] ) ? $settings['cars_year_range_slider_cfb'] : false;
$cars_price_range_slider    = isset( $settings['cars_price_range_slider'] ) ? $settings['cars_price_range_slider'] : false;

if ( ! $cars_filters ) {
	return;
}

if ( $cars_year_range_slider_cfb ) {
	$key = array_search( 'car_year', $cars_filters );
	unset( $cars_filters[ $key ] );
}
?>
<div class="col-lg-8 col-md-8 col-sm-8">
	<div class="row sort-filters-box">
		<?php
		$t = 0;
		$j = 1;

		if ( $cars_year_range_slider_cfb ) {
			?>
			<div class="col-lg-4 col-md-4 col-sm-4">
			<?php echo cardealer_get_year_range_filters( 'yes', array( 'location' => 'elementor-widget' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
			<?php
		}

		foreach ( $cars_filters as $filters ) {
			$tax_terms     = cdhl_get_terms( array( 'taxonomy' => $filters ) );
			$taxonomy_name = get_taxonomy( $filters );
			$label         = $taxonomy_name->labels->singular_name;
			?>
			<div class="col-lg-4 col-md-4 col-sm-4">
				<span><?php esc_html_e( 'Select', 'cardealer-helper' ); ?> <?php echo esc_html( $label ); ?></span>
				<div class="selected-box">
					<select data-uid="<?php echo esc_attr( $this->get_id() ); ?>" id="sort_<?php echo esc_attr( $filters . '_' . $this->get_id() ); ?>" data-id="<?php echo esc_attr( $filters ); ?>" class="selectpicker custom-filters-box col-4 cd-select-box">
						<option value=""><?php esc_html_e( '--Select--', 'cardealer-helper' ); ?></option>
						<?php
						foreach ( $tax_terms as $tax_key => $tax_term ) {
							if ( 'car_mileage' === $taxonomy_name->name ) {
								$mileage_array = cardealer_get_mileage_array();
								if ( 1 === $j ) {
									foreach ( $mileage_array as $mileage ) {
										?>
										<option value="<?php echo esc_attr( $mileage ); ?>">&leq; <?php echo esc_html( $mileage ); ?></option>
										<?php
									}
								}
								$j++;
							} else {
								?>
								<option value="<?php echo esc_attr( $tax_term ); ?>"><?php echo esc_html( $tax_key ); ?></option>
								<?php
							}
						}
						?>
					</select>
				</div>
			</div>
			<?php
			$t++;
		}
		?>
	</div>
</div>
<div class="col-lg-4 col-md-4 col-sm-4">
	<?php
	global $cardealer_price_range_instance;
	$cardealer_price_range_instance = ( isset( $cardealer_price_range_instance ) ) ? $cardealer_price_range_instance + 1 : 1;

	$price_range_slider_id = "dealer-slider-amount-$cardealer_price_range_instance";
	$price_slider_range_id = "slider-range-$cardealer_price_range_instance";

	// Find min and max price in current result set.
	$pgs_min_price = isset( $_GET['min_price'] ) ? (int) $_GET['min_price'] : '';
	$pgs_max_price = isset( $_GET['max_price'] ) ? (int) $_GET['max_price'] : '';
	$prices        = ( function_exists( 'cardealer_get_car_filtered_price' ) ) ? cardealer_get_car_filtered_price() : '';
	$min           = floor( $prices->min_price );
	$max           = ceil( $prices->max_price );
	?>
	<div class="price_slider_wrapper">
		<div class="price-slide">
			<div class="price">
				<?php
				if (  $cars_price_range_slider && $min !== $max && ( $min > 0 || $max > 0 ) ) {
					?>
					<input type="hidden" class="pgs-price-slider-min" name="min_price" value="<?php echo esc_attr( $pgs_min_price ); ?>" data-min="<?php echo esc_attr( $min ); ?>"/>
					<input type="hidden" class="pgs-price-slider-max" name="max_price" value="<?php echo esc_attr( $pgs_max_price ); ?>" data-max="<?php echo esc_attr( $max ); ?>" data-step="<?php echo esc_attr( $step ); ?>"/>
					<div class="price-range-slider-value-wrapper range-slider-value-wrapper">
						<label for="<?php echo esc_attr( $price_range_slider_id ); ?>"><?php echo esc_html__( 'Price:', 'cardealer-helper' ); ?></label>
						<input type="text" id="<?php echo esc_attr( $price_range_slider_id ); ?>" class="dealer-slider-amount" readonly class="amount" value="" />
					</div>
					<div id="<?php echo esc_attr( $price_slider_range_id ); ?>" class="slider-range range-slide-slider"></div>
					<?php
				}
				?>
				<a class="button cfb-submit-btn" href="javascript:void(0);"><?php echo esc_html( $src_button_label ); ?></a>
			</div>
		</div>
	</div>
</div>
