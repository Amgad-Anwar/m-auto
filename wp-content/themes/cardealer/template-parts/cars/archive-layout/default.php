<?php
/**
 * Template part.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package CarDealer
 */

?>
<div class="row">
	<?php
	if ( $args['inv_page_id'] && $args['inv_page_content'] ) {
		?>
		<div class="col-sm-12">
			<?php get_template_part( 'template-parts/cars/archive-sections/page-content', null, $args ); ?>
		</div>
		<?php
	}
	?>
	<div class="col-sm-12 <?php echo esc_attr( $args['inv_page_content_class'] ); ?>">
		<?php
		$cars_term = get_queried_object();
		if ( is_tax() && $cars_term && ! empty( $cars_term->description ) ) {
			?>
			<div class="term-description"><?php echo do_shortcode( $cars_term->description ); ?></div>
			<?php
		}
		?>
		<div class="cars-top-filters-box">
			<div class="cars-top-filters-box-left">
				<?php cardealer_get_price_filters( array( 'filter_location' => 'cars-top-filters-box' ) ); ?>
			</div>
			<div class="cars-top-filters-box-right">
				<?php
				cardealer_cars_catalog_ordering();
				cardealer_get_catlog_view();
				?>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
<div class="row">
	<?php
	/*
	 * Custome left-sidebar
	 */
	cardealer_get_car_catlog_sidebar_left();
	?>
	<div <?php cardealer_cars_content_class(); ?>>
		<?php
		$getlayout            = cardealer_get_cars_list_layout_style();
		$flag                 = false;
		$masonry_style_status = false;

		if ( isset( $getlayout ) && in_array( $getlayout, array( 'view-grid-masonry-left', 'view-grid-masonry-full', 'view-grid-masonry-right' ), true ) ) {
			$masonry_style_status = true;
		}

		if ( isset( $getlayout ) && in_array( $getlayout, array( 'view-grid-full', 'view-grid-masonry-full', 'view-list-full' ), true ) ) {
			$flag = true;
		} else {
			if ( is_active_sidebar( 'listing-cars' ) ) {
				global $wp_registered_widgets;
				$widgets = get_option( 'sidebars_widgets', array() );
				$widgets = $widgets['listing-cars'];
				foreach ( $widgets as $widget ) {
					if ( isset( $wp_registered_widgets[ $widget ]['classname'] ) && 'cars_filters' === $wp_registered_widgets[ $widget ]['classname'] ) {
						$flag = false;
						break;
					} else {
						$flag = true;
					}
				}
			} else {
				$flag = true;
			}
		}
		if ( $flag ) {
			?>
			<div class="sorting-options-main">
				<div class="sort-filters-box">
					<?php cardealer_get_all_filters(); ?>
				</div>
			</div>
			<?php
		}

		global $cars_grid,$car_in_compare;

		$cars_grid = '';
		if ( isset( $_COOKIE['cars_grid'] ) && in_array( $_COOKIE['cars_grid'], array( 'yes', 'no' ), true ) ) {
			$cars_grid = sanitize_text_field( wp_unslash( $_COOKIE['cars_grid'] ) );
		}

		if ( isset( $_REQUEST['cars_grid'] ) && in_array( $_REQUEST['cars_grid'], array( 'yes', 'no' ), true ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			$cars_grid = sanitize_text_field( wp_unslash( $_REQUEST['cars_grid'] ) ); // phpcs:ignore WordPress.Security.NonceVerification
		}

		if ( '' === $cars_grid ) {
			$cars_grid = cardealer_get_cars_catlog_style();
		}

		if ( 'yes' === $cars_grid ) {
			$masonry_style_class = ( true === $masonry_style_status ) ? 'masonry-main' : '';
			?>
			<div class="row <?php echo esc_attr( $masonry_style_class ); ?>">
			<?php
		}
		if ( have_posts() ) {
			$masonry_style_class = ( true === $masonry_style_status ) ? esc_attr( 'isotope-2 masonry filter-container' ) : '';
			?>
			<div class="all-cars-list-arch <?php echo esc_attr( $masonry_style_class ); ?>">
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
	<?php
	/**
	 * Custome right-sidebar
	 * */
	cardealer_get_car_catlog_sidebar_right();
	?>
</div>
