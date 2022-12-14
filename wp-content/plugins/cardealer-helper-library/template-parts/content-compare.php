<?php
/**
 * Theme template for vehicle compare functionality.
 *
 * @author  TeamWP @Potenza Global Solutions
 * @package car-dealer-helper/templates
 * @version 1.0.0
 */

global $car_dealer_options;

$car_ids        = $args['car_ids'];
$num_of_cars    = $args['num_of_cars'];
$compare_fields = $args['compare_fields'];
?>
<div class="modal-header">
	<button type="button" class="close_model" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h1><?php cdhl_compare_popup_title(); ?></h1>
</div>
<div class="modal-content">
	<div class="table-Wrapper">
		<div class="heading-Wrapper">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<?php
				foreach ( $compare_fields as $key => $val ) {
					?>
					<tr><td class="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $val ); ?></td></tr>
					<?php
				}
				?>
			</table>
		</div>
		<div class="table-scroll modal-body" id="getCode">
			<div id="sortable" style="width:<?php echo esc_attr( $num_of_cars * 258 ); ?>px;">
				<?php
				for ( $cols = 1; $cols <= $num_of_cars; $cols++ ) {

					$car_id   = $car_ids[ $cols - 1 ];
					$car_post = get_post( $car_id );

					if ( ! $car_post || ( $car_post && 'cars' !== $car_post->post_type ) ) {
						continue;
					}

					$carlink = get_permalink( $car_id );
					$class   = ( 0 === $cols % 2 ) ? 'even' : 'odd';
					?>
					<div class="compare-list compare-datatable" data-id="<?php echo esc_attr( $car_id ); ?>">
						<table class="compare-list compare-datatable" width="100%" border="0" cellspacing="0" cellpadding="0">
							<tbody>
								<?php
								/**
								 * Action called before vehicle fields displayed in table for compare pop-up.
								 *
								 * @since 1.0
								 *
								 * @param string  $class    Class added in the table column.
								 * @param int     $car_id   Vehicle ID
								 *
								 * @hooked cdhl_compare_column_delete - 10
								 * @hooked cdhl_compare_column_image - 20
								 * @hooked cdhl_compare_column_price - 30
								 * @visible       true
								 */
								do_action( 'cdhl_compare_column_before_attributes', $class, $car_id );

								/**
								 * Action called when vehicle fields displayed in table for compare pop-up.
								 *
								 * @since 1.0
								 *
								 * @param array   $compare_fields An array of vehicle fields to be shown in compare pop-up.
								 * @param class   $string Class added in the table column.
								 * @param int     $car_id Vehicle ID
								 *
								 * @hooked        cdhl_compare_column_attributes_data - 10
								 * @visible       true
								 */
								do_action( 'cdhl_compare_column_attributes', $compare_fields, $class, $car_id );
								?>
							</tbody>
						</table>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</div>
