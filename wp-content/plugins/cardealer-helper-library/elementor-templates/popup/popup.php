<?php
/**
 * Button Elementor widget template
 *
 * @package car-dealer-helper
 */

$icon            = isset( $settings['icon'] ) ? $settings['icon'] : '';
$button_btn_full = isset( $settings['button_btn_full'] ) ? $settings['button_btn_full'] : '';
$alighnment      = isset( $settings['alighnment'] ) ? $settings['alighnment'] : '';
$button_size     = isset( $settings['button_size'] ) ? $settings['button_size'] : '';
$icon_position   = isset( $settings['icon_position'] ) ? $settings['icon_position'] : '';
$button_title    = isset( $settings['button_title'] ) ? $settings['button_title'] : '';
$content_source  = isset( $settings['content_source'] ) ? $settings['content_source'] : 'page';
$page_id         = isset( $settings['page_id'] ) ? (int) $settings['page_id'] : '';
$popup_content   = isset( $settings['popup_content'] ) ? $settings['popup_content'] : '';
$popup_width     = ( isset( $settings['popup_width'] ) && isset( $settings['popup_width']['size'] ) && isset( $settings['popup_width']['unit'] ) ) ? $settings['popup_width']['size'] . $settings['popup_width']['unit'] : '1000px';

$this->add_render_attribute(
	array(
		'widget_wrapper'           => array(
			'class' => array(
				'align-' . $alighnment,
				( $button_btn_full ) ? 'btn-block' : 'btn-normal',
			),
		),
		'cdhl_popup_btn'           => array(
			'class' => array(
				'button',
				'pgs_btn',
				'pgs-popup-btn',
				$button_size,
			),
			'href'  => '#model-' . $this->get_id(),
		),
		'cdhl_button_icon_align'   => array(
			'class' => array(
				'button-icon',
				'icon-position-' . $icon_position,
			),
		),
		'cdhl_popup_content_modal' => array(
			'class' => array(
				'pgs-popup-content-modal',
				'mfp-hide',
				'white-popup',
			),
			'id'    => 'model-' . $this->get_id(),
			'style' => array(
				"max-width:$popup_width;",
			),
		),
		'cdhl_popup_content'       => array(
			'class' => array(
				'pgs-popup-content',
			),
		),
	)
);
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<a <?php $this->print_render_attribute_string( 'cdhl_popup_btn' ); ?>>
		<?php
		if ( $icon && 'left' === $icon_position ) {
			?>
			<span <?php $this->print_render_attribute_string( 'cdhl_button_icon_align' ); ?>><?php \Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) ); ?></span>
			<?php
		}
		echo esc_html( $button_title );
		if ( $icon && 'right' === $icon_position ) {
			?>
			<span <?php $this->print_render_attribute_string( 'cdhl_button_icon_align' ); ?>><?php \Elementor\Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) ); ?></span>
			<?php
		}
		?>
	</a>
	<?php
	if ( ( 'page' === $content_source && $page_id ) || ( 'content' === $content_source && ! empty( $popup_content ) ) ) {
		?>
		<div <?php $this->print_render_attribute_string( 'cdhl_popup_content_modal' ); ?>>
			<button title="<?php esc_attr_e( 'Close (Esc)', 'cardealer-helper' ); ?>" type="button" class="mfp-close">&#215;</button>
			<div <?php $this->print_render_attribute_string( 'cdhl_popup_content' ); ?>>
				<?php
				if ( 'page' === $content_source ) {
					if ( get_the_ID() === $page_id ) {
						?>
						<div class="alert alert-danger" role="alert" style="margin: 0;">
							<h4 class="alert-heading"><?php esc_html_e( 'Important Note', 'pgs-core' ); ?></h4>
							<p><?php esc_html_e( 'Please choose another page. You cannot select the same page on the page where you are adding the popup.', 'cardealer-helper' ); ?></p>
						</div>
						<?php
					} else {
						echo cdhl_get_page_content( $page_id ); // phpcs:ignore
					}
				} elseif ( 'content' === $content_source ) {
					echo do_shortcode( $popup_content );
				}
				?>
			</div>
		</div>
		<?php
	}
	?>
</div>
