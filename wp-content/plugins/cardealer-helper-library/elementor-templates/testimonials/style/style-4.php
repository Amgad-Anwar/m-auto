<?php
/**
 * Testimonials widget template for style 4
 *
 * @package car-dealer-helper
 */

$content = get_post_meta( get_the_ID(), 'content', true );
if ( $content ) {
	?>
	<div class="item">
		<div class="testimonial-block text-center">
			<i class="fas fa-quote-left"></i>
			<p><?php echo $content; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE ?></p>
			<h6 class="text-red"><?php the_title(); ?></h6>
		</div>
	</div>
	<?php
}
