<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Adds Cardealer Helpert Widget Price Range Filters.
 *
 * @package car-dealer-helper/functions
 * @version 1.0.0
 */

/**
 * Cardealer Helpert Widget Price Range Filters.
 */
class CDHL_Widget_Price_Range extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		$widget_ops = array(
			'classname'   => 'vehicle_price_range',
			'description' => esc_html__( 'Add vehicles price range filter widget in vehicle listing widget area.', 'cardealer-helper' ),
		);
		parent::__construct( 'vehicle_price_range', esc_html__( 'Car Dealer - Price Range Filter', 'cardealer-helper' ), $widget_ops );

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
		global $car_dealer_options;

		$layout = cardealer_get_vehicle_listing_page_layout();
		if ( ! wp_is_mobile() && ! apply_filters( 'cdhl_widget_price_range_display_in_desktop', false ) ) {
			return;
		}

		$widget_id = ! isset( $args['widget_id'] ) ? 1 : $args['widget_id'];
		echo $args['before_widget']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base ) . $args['after_title']; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE
		}

		if ( function_exists( 'cardealer_get_price_filters' ) ) {
			?>
			<div class="cars-price-range-widget <?php esc_attr_e( $widget_id ); ?>">
				<?php cardealer_get_price_filters( array( 'filter_location' => 'widget-vehicle-price-range' ) ); ?>
			</div>
			<?php
		}

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
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Filter by Price', 'cardealer-helper' );
		?>
		<div style="background-color: #fff6ca;border-color: #e8d8a6;color: #958234;padding: 10px;margin-top: 15px;display: inline-block;">
			<p style="margin: 0px;"><strong><?php esc_html_e( 'Important Note:', 'cardealer-helper' ); ?></strong><br><?php esc_html_e( 'This widget will display only on the mobile device because, in the desktop view, it is already added by default in the top sorting area.', 'cardealer-helper' ); ?></p>
		</div>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'cardealer-helper' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}
}
