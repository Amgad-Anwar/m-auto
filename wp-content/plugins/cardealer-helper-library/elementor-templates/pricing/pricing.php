<?php
/**
 * Pricing Elementor widget template
 *
 * @package car-dealer-helper
 */

$p_title      = isset( $settings['title'] ) ? $settings['title'] : '';
$subtitle     = isset( $settings['subtitle'] ) ? $settings['subtitle'] : '';
$btntext      = isset( $settings['btntext'] ) ? $settings['btntext'] : '';
$price        = isset( $settings['price'] ) ? $settings['price'] : '';
$frequency    = isset( $settings['frequency'] ) ? $settings['frequency'] : '';
$features     = isset( $settings['features'] ) ? $settings['features'] : '';
$bestseller   = isset( $settings['bestseller'] ) ? $settings['bestseller'] : '';
$product_plan = isset( $settings['product_plan'] ) ? $settings['product_plan'] : '';

if ( ! $p_title || ! $features ) {
	return;
}

if ( $bestseller ) {
	$this->add_render_attribute( 'cdhl_pricing', 'class', 'active' );
}

$features = explode( "\n", $features );

// Clean br tags from lines.
foreach ( $features as $line_k => $line ) {
	$line        = trim( $line );
	$line_length = strlen( $line );

	if ( substr( $line, -6 ) === '<br />' || substr( $line, -4 ) === '<br>' ) {
		if ( substr( $line, -6 ) === '<br />' ) {
			$line = mb_substr( $line, 0, $line_length - 6 );
		} elseif ( substr( $line, -4 ) === '<br>' ) {
			$line = mb_substr( $line, 0, $line_length - 4 );
		}
	}
	$features[ $line_k ] = $line;
}

$url = '#';
if ( $product_plan ) {
	$url = wc_get_checkout_url() . '?add-to-cart=' . $product_plan;
}

$this->add_render_attribute( 'cdhl_pricing', 'class', 'cd-pricing-table pricing-table text-center' );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_pricing' ); ?>>
		<?php
		if ( $bestseller ) {
			$price_ribbon_img = CDFS_URL . '/images/ribbon.png';
			?>
			<div class="pricing-ribbon">
				<img src="<?php echo esc_url( $price_ribbon_img ); ?>" alt="">
			</div>
			<?php
		}
		?>
		<div class="pricing-title">
			<h2 class="<?php echo ( $bestseller ? 'text-white text-bg' : '' ); ?>"><?php echo esc_html( $p_title ); ?></h2>
			<span><?php echo esc_html( $subtitle ); ?></span>
			<div class="pricing-prize">
				<h2><?php echo esc_html( $price ); ?></h2>
				<span><?php echo esc_html( $frequency ); ?></span>
			</div>
		</div>
		<div class="pricing-list">
			<?php
			if ( $features ) {
				?>
				<ul>
					<?php
					foreach ( $features as $feature ) {
						?>
						<li>
							<?php
							echo wp_kses(
								$feature,
								array(
									'a'    => array(
										'class' => true,
										'href'  => true,
									),
									'b'    => array(),
									'span' => array(
										'class' => true,
									),
								)
							);
							?>
						</li>
						<?php
					}
					?>
				</ul>
				<?php
			}
			?>
		</div>
		<div class="pricing-order">
			<a href="<?php echo esc_url( $url ); ?>" class="button button-border gray">
				<?php echo esc_html( $btntext ); ?>
			</a>
		</div>
	</div>
</div>
