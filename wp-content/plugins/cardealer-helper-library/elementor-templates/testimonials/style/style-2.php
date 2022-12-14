<?php
/**
 * Testimonials widget template for style 2
 *
 * @package car-dealer-helper
 */

$content        = get_post_meta( get_the_ID(), 'content', true );
$designation    = get_post_meta( get_the_ID(), 'designation', true );
$profile_img_id = get_post_meta( get_the_ID(), 'profile_image', true );
$profile_img    = wp_get_attachment_image_src( $profile_img_id, 'medium' );
$lazyload_class = isset( $settings['lazyload_class'] ) ? $settings['lazyload_class'] : '';

if ( $content ) {
	?>
	<div class="item">
		<div class="testimonial-block">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-3">
					<div class="testimonial-avtar">
						<?php
						if ( $profile_img ) {
							if ( cardealer_lazyload_enabled() ) {
								?>
								<img class="img-responsive <?php echo esc_attr( $lazyload_class ); ?>" data-src="<?php echo esc_url( $profile_img[0] ); ?>" src="<?php echo esc_url( LAZYLOAD_IMG ); ?>" width="<?php echo esc_attr( $profile_img[1] ); ?>" height="<?php echo esc_attr( $profile_img[2] ); ?>">
								<?php
							} else {
								?>
								<img class="img-responsive" src="<?php echo esc_url( $profile_img[0] ); ?>" width="<?php echo esc_attr( $profile_img[1] ); ?>" height="<?php echo esc_attr( $profile_img[2] ); ?>">
								<?php
							}
						} else {
							?>
							<img class="img-responsive" src="<?php echo esc_url( trailingslashit( CARDEALER_URL ) . 'images/default/263x274.svg' ); ?>" alt="" width="263px" height="274px">
							<?php
						}
						?>
					</div>
				</div>
				<div class="col-lg-9 col-md-9 col-sm-9">
					<div class="testimonial-content">
						<p>
							<i class="fas fa-quote-left"></i>
							<span><?php echo $content; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE ?></span>
							<i class="fas fa-quote-right pull-right"></i>
						</p>
					</div>
					<div class="testimonial-info">
						<h6><?php the_title(); ?></h6>
						<?php
						if ( $designation ) {
							?>
							<span><?php echo esc_html( $designation ); ?></span>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
