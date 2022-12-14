<?php
global $car_dealer_options;
?>
<div class="car-detail-post-option">
	<ul>
		<?php
		if ( ! isset( $car_dealer_options['is-compare-on-vehicle-detail'] ) || 'yes' === $car_dealer_options['is-compare-on-vehicle-detail'] ) {
			?>
			<li><a href="javascript:void(0)" title="<?php echo esc_attr( get_the_title() ); ?>" data-id="<?php echo get_the_ID(); ?>" class="pgs_compare_popup compare_pgs"><i class="fas fa-exchange-alt"></i> <?php esc_html_e( 'Add to compare', 'cardealer' ); ?></a></li>
			<?php
		}
		get_template_part( 'template-parts/cars/single-car/forms/pdf_brochure' );
		get_template_part( 'template-parts/cars/single-car/forms/print_form' );
		?>
	</ul>
	<?php get_template_part( 'template-parts/cars/single-car/share' ); ?>
	<div class="clearfix"></div>
</div>
