<?php
/**
 * Recent Posts Elementor widget template for grid layout
 *
 * @package car-dealer-helper
 */

global $car_dealer_options;

$class             = 'blog-2';
$thumbnail_size    = isset( $settings['thumbnail_size'] ) ? $settings['thumbnail_size'] : '';
$no_of_columns     = isset( $settings['no_of_columns'] ) ? $settings['no_of_columns'] : 2;
$facebook_share    = isset( $car_dealer_options['facebook_share'] ) ? $car_dealer_options['facebook_share'] : '';
$twitter_share     = isset( $car_dealer_options['twitter_share'] ) ? $car_dealer_options['twitter_share'] : '';
$linkedin_share    = isset( $car_dealer_options['linkedin_share'] ) ? $car_dealer_options['linkedin_share'] : '';
$google_plus_share = isset( $car_dealer_options['google_plus_share'] ) ? $car_dealer_options['google_plus_share'] : '';
$pinterest_share   = isset( $car_dealer_options['pinterest_share'] ) ? $car_dealer_options['pinterest_share'] : '';
$whatsapp_share    = isset( $car_dealer_options['whatsapp_share'] ) ? $car_dealer_options['whatsapp_share'] : '';

$excerpt = get_the_excerpt();
$excerpt = cdhl_shortenString( $excerpt, 120, false, true );

if ( 2 === (int) $no_of_columns ) {
	$row_cols = 6;
} elseif ( 3 === (int) $no_of_columns ) {
	$row_cols = 4;
} elseif ( 4 >= $no_of_columns ) {
	$row_cols = 3;
} else {
	$row_cols = 12;
}

$col_class = 'col-lg-' . $row_cols . ' col-md-' . $row_cols . ' col-sm-' . $row_cols;
if ( ! has_post_thumbnail() ) {
	$class .= ' blog-no-image';
}

$this->add_render_attribute( 'cdhl_recent_posts_grid_class', 'class', $col_class );
?>
<div <?php $this->print_render_attribute_string( 'cdhl_recent_posts_grid_class' ); ?>>
	<div class="<?php echo esc_attr( $class ); ?>">
		<div class="blog-image">
			<?php
			$img_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ), $thumbnail_size );
			if ( $img_url ) {
				if ( cardealer_lazyload_enabled() ) {
					?>
					<img class="img-responsive cardealer-lazy-load" data-src="<?php echo esc_html( $img_url ); ?>" src="<?php echo esc_url( LAZYLOAD_IMG ); ?>">
					<?php
				} else {
					the_post_thumbnail( $thumbnail_size, array( 'class' => 'img-responsive' ) );
				}
			}
			?>
			<div class="date-box">
				<span><?php echo sprintf( '%1$s', esc_html( get_the_date( 'M Y' ) ) ); ?></span>
			</div>
		</div>
		<div class="blog-content">
			<div class="blog-admin-main">
				<div class="blog-admin">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>
					<span>
						<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
							<?php echo esc_html__( 'By', 'cardealer-helper' ) . ' ' . get_the_author(); ?>
						</a>
					</span>
				</div>
				<div class="blog-meta pull-right">
					<ul>
						<li>
							<a href="<?php echo esc_url( get_comments_link( get_the_ID() ) ); ?>"> <i class="fas fa-comment"></i><br /> 
								<?php
								$comments_count = wp_count_comments( get_the_ID() );
								echo esc_html( $comments_count->approved );
								?>
							</a>
						</li>
						<?php
						if ( $facebook_share || $twitter_share || $linkedin_share || $google_plus_share || $pinterest_share || $whatsapp_share ) {
							?>
							<li class="share">
								<a href="#"><i class="fas fa-share-alt"></i><br /> ...</a>
								<div class="blog-social"> 
									<ul>
									<?php
									if ( $facebook_share ) {
										?>
										<li> 
											<a href="#" class="facebook-share" data-title="<?php echo esc_attr( get_the_title() ); ?>" data-url="<?php echo esc_url( get_permalink() ); ?>">
												<i class="fab fa-facebook-f"></i>
											</a>
										</li>
										<?php
									}
									if ( $twitter_share ) {
										?>
										<li>
											<a href="#"  data-title="<?php echo esc_attr( get_the_title() ); ?>" data-url="<?php echo esc_url( get_permalink() ); ?>" class="twitter-share">
												<i class="fab fa-twitter"></i>
											</a>
										</li>
										<?php
									}
									if ( $linkedin_share ) {
										?>
										<li>
											<a href="#"  data-title="<?php echo esc_attr( get_the_title() ); ?>" data-url="<?php echo esc_url( get_permalink() ); ?>" class="linkedin-share">
												<i class="fab fa-linkedin-in"></i>
											</a>
										</li>
										<?php
									}
									if ( $google_plus_share ) {
										?>
										<li>
											<a href="#"  data-title="<?php echo esc_attr( get_the_title() ); ?>" data-url="<?php echo esc_url( get_permalink() ); ?>" class="googleplus-share">
												<i class="fab fa-google-plus-g"></i>
											</a>
										</li>
										<?php
									}
									if ( $pinterest_share ) {
										?>
										<li>
											<a href="#"  data-title="<?php echo esc_attr( get_the_title() ); ?>" data-url="<?php echo esc_url( get_permalink() ); ?>" data-image="<?php the_post_thumbnail_url( 'full' ); ?>" class="pinterest-share">
												<i class="fab fa-pinterest-p"></i>
											</a>
										</li>
										<?php
									}
									if ( $whatsapp_share ) {
										if ( ! wp_is_mobile() ) {
											?>
											<li>
												<a href="#" data-url="<?php echo esc_url( get_permalink() ); ?>"  class="whatsapp-share">
													<i class="fab fa-whatsapp"></i>
												</a>
											</li>
											<?php
										} else {
											?>
											<li>
												<a target="_blank" href="https://wa.me/?text=<?php echo esc_url( get_permalink() ); ?>">
													<i class="fab fa-whatsapp"></i>
												</a>
											</li>               
											<?php
										}
									}
									?>
									</ul>
								</div>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
			</div>
			<div class="blog-description text-center">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				<div class="separator"></div>
				<p><?php echo $excerpt; // phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotE ?></p>
			</div>
		</div>
	</div>
</div>
