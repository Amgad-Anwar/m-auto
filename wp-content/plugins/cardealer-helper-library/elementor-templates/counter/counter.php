<?php
/**
 * Counter Elementor widget template
 *
 * @package car-dealer-helper
 */

$icon          = isset( $settings['icon'] ) ? $settings['icon'] : '';
$style         = isset( $settings['style'] ) ? $settings['style'] : '';
$label         = isset( $settings['label'] ) ? $settings['label'] : '';
$counter       = isset( $settings['counter'] ) ? $settings['counter'] : '';
$counter_speed = isset( $settings['counter_speed'] ) ? $settings['counter_speed'] : 10000;

if ( ! $label || ! $counter ) {
	return;
}

$this->add_render_attribute( 'cdhl_counter', 'class', 'counter clearfix counter-' . $style );
if ( 'style-2' === $style ) {
	$this->add_render_attribute( 'cdhl_counter', 'class', 'icon left' );
} elseif ( 'style-3' === $style ) {
	$this->add_render_attribute( 'cdhl_counter', 'class', 'icon right' );
} elseif ( 'style-4' === $style ) {
	$this->add_render_attribute( 'cdhl_counter', 'class', 'left-separator' );
}

$this->add_render_attribute(
	[
		'cdhl_counter_timer' => [
			'class'      => 'timer',
			'data-to'    => $counter,
			'data-speed' => $counter_speed,
		],
	]
);
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_counter' ); ?> >
	<?php
	if ( 'style-4' === $style ) {
		?>
		<div class="separator"></div>
		<div class="info">
			<h6><?php echo esc_html( $label ); ?></h6>
			<?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
			<b <?php $this->print_render_attribute_string( 'cdhl_counter_timer' ); ?>></b>
		</div>
		<?php
	} else {
		if ( $icon ) {
			?>
			<div class="icon">
				<?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
			</div>
			<?php
		}
		?>
		<div class="content">
			<h6><?php echo esc_html( $label ); ?></h6>
			<b <?php $this->print_render_attribute_string( 'cdhl_counter_timer' ); ?>></b>
		</div>
		<?php
	}
	?>
	</div>
</div>
