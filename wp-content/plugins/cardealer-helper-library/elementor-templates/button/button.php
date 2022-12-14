<?php
/**
 * Button Elementor widget template
 *
 * @package car-dealer-helper
 */

$icon            = isset( $settings['icon'] ) ? $settings['icon'] : '';
$style           = isset( $settings['style'] ) ? $settings['style'] : '';
$button_title    = isset( $settings['button_title'] ) ? $settings['button_title'] : '';
$button_btn_full = isset( $settings['button_btn_full'] ) ? $settings['button_btn_full'] : '';
$alighnment      = isset( $settings['alighnment'] ) ? $settings['alighnment'] : '';
$button_size     = isset( $settings['button_size'] ) ? $settings['button_size'] : '';
$icon_position   = isset( $settings['icon_position'] ) ? $settings['icon_position'] : '';

if ( isset( $settings['button_link']['url'] ) && $settings['button_link']['url'] ) {
	if ( isset( $settings['button_link']['is_external'] ) && $settings['button_link']['is_external'] ) {
		$this->add_render_attribute( 'cdhl_button', 'target', '_blank' );
	}
	if ( isset( $settings['button_link']['nofollow'] ) && $settings['button_link']['nofollow'] ) {
		$this->add_render_attribute( 'cdhl_button', 'rel', 'nofollow' );
	}
	if ( isset( $settings['button_link']['url'] ) && $settings['button_link']['url'] ) {
		$this->add_render_attribute( 'cdhl_button', 'href', $settings['button_link']['url'] );
	}
}

$this->add_render_attribute(
	[
		'cdhl_button'    => [
			'class' => [
				'button',
				'pgs_btn',
				$style,
				$button_size,
			],
		],
		'widget_wrapper' => [
			'class' => [
				'align-' . $alighnment,
				( $button_btn_full ) ? 'btn-block' : 'btn-normal',
			],
		],
	]
);

$this->add_render_attribute( 'cdhl_button_icon_align', 'class', 'button-icon icon-position-' . $icon_position );
if ( isset( $settings['button_link']['url'] ) && $settings['button_link']['url'] && $button_title ) {
	?>
	<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
		<a <?php $this->print_render_attribute_string( 'cdhl_button' ); ?>>
			<?php
			if ( $icon && 'left' === $icon_position ) {
				?>
				<span <?php $this->print_render_attribute_string( 'cdhl_button_icon_align' ); ?>>
				<?php
				\Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
				?>
				</span>
				<?php
			}
			?>
			<?php echo esc_html( $button_title ); ?>
			<?php
			if ( $icon && 'right' === $icon_position ) {
				?>
				<span <?php $this->print_render_attribute_string( 'cdhl_button_icon_align' ); ?>>
				<?php
				\Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
				?>
				</span>
				<?php
			}
			?>
		</a>
	</div>
	<?php
}
