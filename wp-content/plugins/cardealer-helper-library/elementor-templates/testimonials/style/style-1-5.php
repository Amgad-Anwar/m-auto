<?php
/**
 * Testimonials widget template for style 1, 5
 *
 * @package car-dealer-helper
 */
global $post;

$content        = get_post_meta( get_the_ID(), 'content', true );
$designation    = get_post_meta( get_the_ID(), 'designation', true );
$profile_img_id = get_post_meta( get_the_ID(), 'profile_image', true );
$profile_img    = wp_get_attachment_image_src( $profile_img_id, 'thumbnail' );
$lazyload_class = isset( $settings['lazyload_class'] ) ? $settings['lazyload_class'] : '';

if ( $content ) {
	?>
	<div class="item">
		<div class="testimonial-block text-center">
			<div class="testimonial-image">
				<?php
				if ( has_post_thumbnail() ) {
					if ( cardealer_lazyload_enabled() ) {
						$img_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), 'cardealer-blog-thumb' );
						?>
						<img class="img-responsive <?php echo esc_attr( $lazyload_class ); ?>" data-src="<?php echo esc_html( $img_url ); ?>" src="<?php echo esc_url( LAZYLOAD_IMG ); ?>">
						<?php
					} else {
						the_post_thumbnail( 'cardealer-blog-thumb' );
					}
				} else {
					?>
					<img class="img-responsive" src="<?php echo esc_url( trailingslashit( CARDEALER_URL ) . 'images/default/366x80.svg' ); ?>" alt="" width="366px" height="80px">
					<?php
				}
				?>
			</div>
			<div class="testimonial-box">
				<div class="testimonial-avtar">
					<?php
					if ( $profile_img ) {
						if ( cardealer_lazyload_enabled() ) {
							?>
							<img class="img-responsive <?php echo esc_attr( $lazyload_class ); ?>" src="<?php echo esc_url( LAZYLOAD_IMG ); ?>" data-src="<?php echo esc_url( $profile_img[0] ); ?>" width="<?php echo esc_attr( $profile_img[1] ); ?>" height="<?php echo esc_attr( $profile_img[2] ); ?>">
							<?php
						} else {
							?>
							<img class="img-responsive" src="<?php echo esc_url( $profile_img[0] ); ?>" width="<?php echo esc_attr( $profile_img[1] ); ?>" height="<?php echo esc_attr( $profile_img[2] ); ?>">
							<?php
						}
					} else {
						?>
						<svg style="background-color: #cccccc;border-radius: 50%;border: 4px #fff solid;" version="1.1" xmlns="http://www.w3.org/2000/svg" height="80px" width="80px"></svg>
						<?php
					}
					?>
					<h6><?php the_title(); ?></h6>
					<?php
					if ( $designation ) {
						?>
						<span><?php echo esc_html( $designation ); ?></span>
						<?php
					}
					?>
				</div>
				<div class="testimonial-content">
					<p><?php echo $content; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE ?></p>
					<i class="fas fa-quote-right"></i>
				</div>
			</div>
		</div>
	</div>
	<?php
}
