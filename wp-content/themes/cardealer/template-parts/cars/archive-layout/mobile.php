<?php
/**
 * Template part.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package CarDealer
 */

global $car_dealer_options;

$filter_location = cardealer_vehicle_listing_mobile_filter_location();
?>
<div class="row">
	<?php
	do_action( 'cardealer/vehicle_listing/mobile/before_page_content' );

	if ( $args['inv_page_id'] && $args['inv_page_content'] ) {
		?>
		<div class="col-sm-12">
			<?php get_template_part( 'template-parts/cars/archive-sections/page-content', null, $args ); ?>
		</div>
		<?php
	}

	/**
	 * Hook: cardealer/vehicle_listing/mobile/before_listing.
	 *
	 * @hooked cardealer_vehicle_listing_page_mobile_filters - 10
	 */
	do_action( 'cardealer/vehicle_listing/mobile/before_listing' );
	?>
	<div <?php cardealer_cars_content_class(); ?>>

		<?php
		$cars_term = get_queried_object();
		if ( is_tax() && $cars_term && ! empty( $cars_term->description ) ) {
			?>
			<div class="term-description"><?php echo do_shortcode( $cars_term->description ); ?></div>
			<?php
		}
		?>
		<div class="cars-top-filters-box cars-filters-mobile">
			<div class="cars-top-filters-box-left">
				<?php cardealer_get_cars_details_breadcrumb(); ?>
			</div>
			<div class="cars-top-filters-box-right">
				<?php
				if ( 'off-canvas' === $filter_location ) {

					$show_sidebar_label = ( isset( $car_dealer_options['vehicle_listing_mobile_show_sidebar_label'] ) && ! empty( $car_dealer_options['vehicle_listing_mobile_show_sidebar_label'] ) ) ? $car_dealer_options['vehicle_listing_mobile_show_sidebar_label'] : esc_html__( 'Show sidebar', 'cardealer' );
					?>
					<div class="off-canvas-toggle">
						<a href="#" rel="nofollow"><i class="fas fa-bars"></i> <?php echo esc_html( $show_sidebar_label ); ?></a>
					</div>
					<?php
				}
				cardealer_cars_catalog_ordering( array( 'enable_ordering' => false ) );
				?>
			</div>
			<div class="clearfix"></div>
		</div>
		<?php
		$getlayout = cardealer_get_cars_list_layout_style();
		global $cars_grid;

		$cars_grid = '';
		if ( isset( $_COOKIE['cars_grid'] ) && in_array( $_COOKIE['cars_grid'], array( 'yes', 'no' ), true ) ) {
			$cars_grid = sanitize_text_field( wp_unslash( $_COOKIE['cars_grid'] ) );
		}

		if ( isset( $_REQUEST['cars_grid'] ) && in_array( $_REQUEST['cars_grid'], array( 'yes', 'no' ), true ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			$cars_grid = sanitize_text_field( wp_unslash( $_REQUEST['cars_grid'] ) ); // phpcs:ignore WordPress.Security.NonceVerification
		}

		if ( ! $cars_grid ) {
			$cars_grid = cardealer_get_cars_catlog_style();
		}

		if ( 'yes' === $cars_grid ) {
			?>
			<div class="row">
			<?php
		}
		if ( have_posts() ) {
			?>
			<div class="all-cars-list-arch">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/cars/content', 'cars' );
				endwhile; // end of the loop.
				?>
			</div>
			<?php
		} else {
			?>
			<div class="all-cars-list-arch">
				<div class="col-sm-12">
					<div class="alert alert-warning">
					<?php
					esc_html_e( 'No result were found matching your selection.', 'cardealer' );
					?>
					</div>
				</div>
			</div>
			<?php
		}
		if ( 'yes' === $cars_grid ) {
			?>
			</div>
			<?php
		}
		if ( have_posts() ) {
			get_template_part( 'template-parts/cars/pagination' );
		}
		?>
	</div>
	<?php do_action( 'cardealer/vehicle_listing/mobile/after_listing' ); ?>
</div>
