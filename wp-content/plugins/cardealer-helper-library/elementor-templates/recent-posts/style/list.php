<?php
/**
 * Recent Posts Elementor widget template for list layout
 *
 * @package car-dealer-helper
 */

$thumbnail_size    = isset( $settings['thumbnail_size'] ) ? $settings['thumbnail_size'] : '';
$detail_link_title = isset( $settings['detail_link_title'] ) ? $settings['detail_link_title'] : '';

$excerpt = get_the_excerpt();
$excerpt = cdhl_shortenString( $excerpt, 120, false, true );
?>
<div class="blog-1">
	<div class="row">
		<?php
		$class = 'col-lg-12 col-md-12 col-sm-12';
		if ( has_post_thumbnail() ) {
			$class = 'col-lg-6 col-md-6 col-sm-6';
			?>
			<div class="col-lg-6 col-md-6 col-sm-6">
				<div class="blog-image">
					<?php
					$img_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ), $thumbnail_size );
					if ( $img_url ) {
						if ( cardealer_lazyload_enabled() ) {
							?>
							<img class="img-responsive cardealer-lazy-load" data-src="<?php echo esc_url( $img_url ); ?>" src="<?php echo esc_url( LAZYLOAD_IMG ); ?>">
							<?php
						} else {
							the_post_thumbnail( $thumbnail_size, array( 'class' => 'img-responsive' ) );
						}
					}
					?>
				</div>
			</div>
			<?php
		}
		?>
		<div class="<?php echo esc_attr( $class ); ?>">
			<div class="blog-content">
				<a href="<?php the_permalink(); ?>" class="link"><?php echo esc_html( get_the_title() ); ?></a>
				<span class="uppercase">
					<?php echo esc_html( get_the_date( 'F d, Y' ) ); ?> | <strong class="text-red"> <?php echo esc_html__( 'post by', 'cardealer-helper' ) . ' ' . get_the_author(); ?> </strong>
				</span>
				<p><?php echo $excerpt; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE ?></p>
				<?php
				if ( $detail_link_title ) {
					?>
					<a class="button border" href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo esc_html( $detail_link_title ); ?></a>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</div>
<br />
