<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Adds Cardealer Helpert Widget Year Range Filters.
 *
 * @package car-dealer-helper/functions
 * @version 1.0.0
 */

/**
 * Cardealer Helpert Widget Year Range Filters.
 */
class CDHL_Widget_Year_Rang extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_ops = array(
			'classname'   => 'vehicle_year_rang',
			'description' => esc_html__( 'Add vehicles year range filter widget in vehicle listing widget area.', 'cardealer-helper' ),
		);
		parent::__construct( 'vehicle_year_rang', esc_html__( 'Car Dealer - Year Range Filter', 'cardealer-helper' ), $widget_ops );

	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		global $car_dealer_options, $cardealer_year_range_instance;
		$cardealer_year_range_instance = ( isset( $cardealer_year_range_instance ) ) ? $cardealer_year_range_instance + 1 : 1;

		$year_range_slider_id = "dealer-slider-year-range-$cardealer_year_range_instance";
		$year_slider_range_id = "slider-year-range-$cardealer_year_range_instance";

		$year_range_slider_location = cardealer_get_year_range_slider_location();
		if ( 'in_widgets' !== $year_range_slider_location ) {
			return;
		}

		// Find min and max price in current result set.
		$year_range = ( function_exists( 'cardealer_get_year_range' ) ) ? cardealer_get_year_range() : '';
		$yearmin    = floor( $year_range['min_year'] );
		$yearmax    = ceil( $year_range['max_year'] );

		if ( $yearmin === $yearmax ) {
			return;
		}

		$pgs_year_range_min = isset( $_GET['min_year'] ) ? sanitize_text_field( wp_unslash( $_GET['min_year'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
		$pgs_year_range_max = isset( $_GET['max_year'] ) ? sanitize_text_field( wp_unslash( $_GET['max_year'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification

		$widget_id = ! isset( $args['widget_id'] ) ? 1 : $args['widget_id'];

		echo $args['before_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE
		}
		?>
		<div class="cars-year-range-widget <?php esc_attr_e( $widget_id ); ?>">
			<div class="year-range-slider-wrapper" data-range-location="widgets">
				<div class="year-range-slide">
					<div class="year_range">
						<input type="hidden" class="pgs-year-range-min" name="min_year" value="<?php echo esc_attr( $pgs_year_range_min ); ?>" data-yearmin="<?php echo esc_attr( $yearmin ); ?>">
						<input type="hidden" class="pgs-year-range-max" name="max_year" value="<?php echo esc_attr( $pgs_year_range_max ); ?>" data-yearmax="<?php echo esc_attr( $yearmax ); ?>">

						<div id="<?php echo esc_attr( $year_slider_range_id ); ?>" class="slider-year-range range-slide-slider" data-cfb=""></div>
					</div>
					<div class="range-btn-wrapper year-range-btn-wrapper">
						<div class="dealer-slider-year-range">
							<label for="<?php echo esc_attr( $year_range_slider_id ); ?>"><?php echo esc_html__( 'Year:', 'cardealer' ); ?></label>
							<input type="text" id="<?php echo esc_attr( $year_range_slider_id ); ?>" readonly="" value="" class="dealer-slider-year-range">
						</div>
						<button id="year-range-filter-btn-<?php echo esc_attr( $cardealer_year_range_instance ); ?>" class="year-range-filter-btn button"><?php esc_html_e( 'Filter', 'cardealer' ); ?></button>
					</div>
				</div>
			</div>
		</div>
		<?php
		echo $args['after_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Filter by Year', 'cardealer-helper' );
		?>
		<div style="background-color: #fff6ca;border-color: #e8d8a6;color: #958234;padding: 10px;margin-top: 15px;display: inline-block;">
			<p style="margin: 0px;"><strong><?php esc_html_e( 'Important Note:', 'cardealer-helper' ); ?></strong><br><?php esc_html_e( 'This widget will display only when "Year Range Slider Location" is set to "In Widgets".', 'cardealer-helper' ); ?></p>
		</div>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'cardealer-helper' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}
}
