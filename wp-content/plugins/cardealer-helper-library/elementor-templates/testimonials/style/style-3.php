<?php
/**
 * Testimonials widget template for style 3
 *
 * @package car-dealer-helper
 */

$content        = get_post_meta( get_the_ID(), 'content', true );
$designation    = get_post_meta( get_the_ID(), 'designation', true );
$profile_img_id = get_post_meta( get_the_ID(), 'profile_image', true );
$profile_img    = wp_get_attachment_image_src( $profile_img_id, 'thumbnail' );
$lazyload_class = isset( $settings['lazyload_class'] ) ? $settings['lazyload_class'] : '';

if ( $content ) {
	?>
	<div class="item">
		<div class="testimonial-block">
			<div class="testimonial-content">
				<i class="fas fa-quote-left"></i>
				<p> <?php echo $content; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE ?></p>
			</div>
			<div class="testimonial-info">
				<div class="testimonial-avatar">
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
						<img class="img-responsive" src="<?php echo esc_url( trailingslashit( CARDEALER_URL ) . 'images/default/96x96.svg' ); ?>" alt="" width="96px" height="96px">
						<?php
					}
					?>
				</div>
				<div class="testimonial-name">
					<h6 class="text-white"><?php the_title(); ?></h6>
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
	<?php
}
