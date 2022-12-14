<?php
/**
 * Promocode Elementor widget template
 *
 * @package car-dealer-helper
 */

$promo_title = isset( $settings['promo_title'] ) ? $settings['promo_title'] : '';
$title_align = isset( $settings['title_align'] ) ? $settings['title_align'] : '';
$color_style = isset( $settings['color_style'] ) ? $settings['color_style'] : '';

$this->add_render_attribute(
	[
		'cdhl_promocode' => [
			'class' => [
				'promocode-box',
				$title_align,
				$color_style,
			],
		],
	]
);

$this->add_render_attribute(
	[
		'cdhl_promocode_button' => [
			'class'    => [
				'button',
				'promocode-btn',
			],
			'type'     => [
				'button',
			],
			'data-fid' => [
				$this->get_id(),
			],
		],
	]
);

$this->add_render_attribute( 'cdhl_promocode_form', 'class', 'promocode-form form-inline' );
$this->add_render_attribute( 'cdhl_promocode_form', 'id', $this->get_id() );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_promocode' ); ?>>
		<div <?php $this->print_render_attribute_string( 'cdhl_promocode_form' ); ?>>
			<?php
			if ( $promo_title ) {
				$this->add_render_attribute( 'cdhl_promocode_title', 'class', 'text-red' );
				?>
				<h4 <?php $this->print_render_attribute_string( 'cdhl_promocode_title' ); ?>><?php echo esc_html( $promo_title ); ?></h4>
				<?php
			}
			?>
			<input type="hidden" name="action" class="promocode_action" value="validate_promocode">            
			<input type="hidden" name="promocode_nonce" class="promocode_nonce" value="<?php echo esc_attr( wp_create_nonce( 'cdhl-promocode-form' ) ); ?>">
			<div class="form-group">
				<label for="promocode" class="sr-only"><?php echo esc_html__( 'Promo Code', 'cardealer-helper' ); ?></label>
				<input type="text" name="promocode" class="form-control promocode" placeholder="<?php echo esc_attr__( 'Promo Code', 'cardealer-helper' ); ?>">
				<span class="spinimg"></span>
			</div>
			<button <?php $this->print_render_attribute_string( 'cdhl_promocode_button' ); ?>><?php esc_html_e( 'Go', 'cardealer-helper' ); ?></button>
			<p class="promocode-msg" style="display:none;"></p>
		</div>
	</div>
</div>
