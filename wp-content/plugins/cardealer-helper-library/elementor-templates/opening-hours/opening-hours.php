<?php
/**
 * Opening hours template
 *
 * @package car-dealer-helper
 */

$oh_title      = isset( $settings['opening_hours_title'] ) ? $settings['opening_hours_title'] : '';
$day_monday    = isset( $settings['day_monday'] ) ? $settings['day_monday'] : '';
$day_tuesday   = isset( $settings['day_tuesday'] ) ? $settings['day_tuesday'] : '';
$day_wednesday = isset( $settings['day_wednesday'] ) ? $settings['day_wednesday'] : '';
$day_thursday  = isset( $settings['day_thursday'] ) ? $settings['day_thursday'] : '';
$day_friday    = isset( $settings['day_friday'] ) ? $settings['day_friday'] : '';
$day_saturday  = isset( $settings['day_saturday'] ) ? $settings['day_saturday'] : '';
$day_sunday    = isset( $settings['day_sunday'] ) ? $settings['day_sunday'] : '';
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div class="opening-hours gray-bg">
		<?php
		if ( $oh_title ) {
			?>
			<h6><?php echo esc_html( $oh_title ); ?></h6>
			<?php
		}
		?>
		<ul class="list-style-none">
			<li>
				<strong><?php echo esc_html__( 'Monday', 'cardealer-helper' ); ?></strong>
				<?php
				if ( ! $day_monday ) {
					?>
					<span class="text-red"><?php echo esc_html__( 'closed', 'cardealer-helper' ); ?></span>
					<?php
				} else {
					?>
					<span><?php echo esc_html( $day_monday ); ?></span>
					<?php
				}
				?>
			</li>
			<li>
				<strong><?php echo esc_html__( 'Tuesday', 'cardealer-helper' ); ?></strong>
				<?php
				if ( ! $day_tuesday ) {
					?>
					<span class="text-red"><?php echo esc_html__( 'closed', 'cardealer-helper' ); ?></span>
					<?php
				} else {
					?>
					<span><?php echo esc_html( $day_tuesday ); ?></span>
					<?php
				}
				?>
			</li>
			<li>
				<strong><?php echo esc_html__( 'Wednesday', 'cardealer-helper' ); ?></strong>
				<?php
				if ( ! $day_wednesday ) {
					?>
					<span class="text-red"><?php echo esc_html__( 'closed', 'cardealer-helper' ); ?></span>
					<?php
				} else {
					?>
					<span><?php echo esc_html( $day_wednesday ); ?></span>
					<?php
				}
				?>
			</li>
			<li>
				<strong><?php echo esc_html__( 'Thursday', 'cardealer-helper' ); ?></strong>
				<?php
				if ( ! $day_thursday ) {
					?>
					<span class="text-red"><?php echo esc_html__( 'closed', 'cardealer-helper' ); ?></span>
					<?php
				} else {
					?>
					<span><?php echo esc_html( $day_thursday ); ?></span>
					<?php
				}
				?>
			</li>
			<li>
				<strong><?php echo esc_html__( 'Friday', 'cardealer-helper' ); ?></strong>
				<?php
				if ( ! $day_friday ) {
					?>
					<span class="text-red"><?php echo esc_html__( 'closed', 'cardealer-helper' ); ?></span>
					<?php
				} else {
					?>
					<span><?php echo esc_html( $day_friday ); ?></span>
					<?php
				}
				?>
			</li>
			<li>
				<strong><?php echo esc_html__( 'Saturday', 'cardealer-helper' ); ?></strong>
				<?php
				if ( ! $day_saturday ) {
					?>
					<span class="text-red"><?php echo esc_html__( 'closed', 'cardealer-helper' ); ?></span>
					<?php
				} else {
					?>
					<span><?php echo esc_html( $day_saturday ); ?></span>
					<?php
				}
				?>
			</li>
			<li>
				<strong><?php echo esc_html__( 'Sunday', 'cardealer-helper' ); ?></strong>
				<?php
				if ( ! $day_sunday ) {
					?>
					<span class="text-red"><?php echo esc_html__( 'closed', 'cardealer-helper' ); ?></span>
					<?php
				} else {
					?>
					<span><?php echo esc_html( $day_sunday ); ?></span>
					<?php
				}
				?>
			</li>
		</ul>
	</div>
</div>
