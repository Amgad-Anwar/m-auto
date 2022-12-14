<?php
/**
 * Our Team Elementor widget template
 *
 * @package car-dealer-helper
 */

$lazyload         = cardealer_lazyload_enabled();
$style            = isset( $settings['style'] ) ? $settings['style'] : 'style-1';
$list_type        = isset( $settings['list_type'] ) ? $settings['list_type'] : 'grid';
$posts_per_page   = isset( $settings['posts_per_page'] ) ? $settings['posts_per_page'] : 10;
$data_space       = isset( $settings['data_space'] ) ? $settings['data_space'] : 20;
$data_md_items    = isset( $settings['data_md_items'] ) ? $settings['data_md_items'] : 3;
$data_sm_items    = isset( $settings['data_sm_items'] ) ? $settings['data_sm_items'] : 3;
$data_xs_items    = isset( $settings['data_xs_items'] ) ? $settings['data_xs_items'] : 3;
$data_xx_items    = isset( $settings['data_xx_items'] ) ? $settings['data_xx_items'] : 1;
$number_of_column = isset( $settings['number_of_column'] ) ? $settings['number_of_column'] : 3;
$arrow            = isset( $settings['arrow'] ) && $settings['arrow'] ? $settings['arrow'] : 'false';
$dots             = isset( $settings['dots'] ) && $settings['dots'] ? $settings['dots'] : 'false';
$autoplay         = isset( $settings['autoplay'] ) && $settings['autoplay'] ? $settings['autoplay'] : 'false';
$data_loop        = isset( $settings['data_loop'] ) && $settings['data_loop'] ? $settings['data_loop'] : 'false';

$args = array(
	'post_type'      => 'teams',
	'posts_per_page' => $posts_per_page,
);

$the_query = new WP_Query( $args );
$cnt       = $the_query->post_count;

if ( ! $the_query->have_posts() || ( 0 === (int) $posts_per_page ) ) {
	return;
}

$lazyload_class = ( 'true' === $data_loop ) ? 'cardealer-lazy-load owl-lazy' : 'cardealer-lazy-load';
if ( $the_query->post_count < $data_md_items ) {
	$lazyload_class = 'cardealer-lazy-load';
}

$this->add_render_attribute( 'cdhl_our_team', 'class', 'pgs_team ' . $style );
$this->add_render_attribute( 'cdhl_our_team', 'id', $this->get_id() );
if ( 'slider' === $list_type ) {
	$this->add_render_attribute(
		[
			'cdhl_our_team' => [
				'class'          => 'owl-carousel',
				'data-nav-arrow' => $arrow,
				'data-nav-dots'  => $dots,
				'data-autoplay'  => $autoplay,
				'data-lazyload'  => $lazyload,
				'data-space'     => $data_space,
				'data-loop'      => $data_loop,
				'data-items'     => $data_md_items,
				'data-md-items'  => $data_md_items,
				'data-sm-items'  => $data_sm_items,
				'data-xs-items'  => $data_xs_items,
				'data-xx-items'  => $data_xx_items,
			],
		]
	);
}
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_our_team' ); ?>>
	<?php
	$k = 0;
	while ( $the_query->have_posts() ) {

		$the_query->the_post();
		global $post;

		$designation   = get_post_meta( get_the_ID(), 'designation', $single = true );
		$facebook      = get_post_meta( get_the_ID(), 'facebook', $single = true );
		$twitter       = get_post_meta( get_the_ID(), 'twitter', $single = true );
		$pinterest     = get_post_meta( get_the_ID(), 'pinterest', $single = true );
		$behance       = get_post_meta( get_the_ID(), 'behance', $single = true );
		$default_image = CDHL_VC_URL . '/vc_images/team-member.png';

		if ( 'slider' === $list_type ) {
			if ( 'style-1' === $style || 'style-3' === $style ) {
				?>
				<div class="item">
					<div class="team text-center">
						<div class="team-image">
							<?php
							if ( has_post_thumbnail() ) {
								$img_size = ( 'style-3' === $style ) ? 'cardealer-homepage-thumb' : 'cardealer-team-thumb';
								$img_url  = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), $img_size );
								$class    = 'img-responsive icon ' . $lazyload_class;
							} else {
								$img_url = $default_image;
								$class    = 'img-responsive icon';
							}

							if ( $lazyload ) {
								?>
								<img src="<?php echo esc_url( LAZYLOAD_IMG ); ?>" data-src="<?php echo esc_url( $img_url ) ?>" class="<?php echo esc_attr( $class ) ?>">
								<?php
							} else {
								?>
								<img src="<?php echo esc_url( $img_url ); ?>" class="img-responsive icon">
								<?php
							}

							if ( $facebook || $twitter || $pinterest || $behance ) {
								?>
								<div class="team-social">
									<ul>
										<?php
										if ( $facebook ) {
											echo '<li><a class="icon-1" href="' . esc_url( $facebook ) . '"><i class="fab fa-facebook-f"></i></a></li>';
										}
										if ( $twitter ) {
											echo '<li><a class="icon-2" href="' . esc_url( $twitter ) . '"><i class="fab fa-twitter"></i></a></li>';
										}
										if ( $pinterest ) {
											echo '<li><a class="icon-3" href="' . esc_url( $pinterest ) . '"><i class="fab fa-pinterest"></i></a></li>';
										}
										if ( $behance ) {
											echo '<li><a class="icon-4" href="' . esc_url( $behance ) . '"><i class="fab fa-behance"></i></a></li>';
										}
										?>
									</ul>
								</div>
								<?php
							}
							?>
						</div>
						<div class="team-name">
							<h5 class="text-black">
								<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
							</h5>
							<?php
							if ( $designation ) {
								echo "<span class='text-black'>" . esc_html( $designation ) . '</span>';
							}
							?>
						</div>
					</div>
				</div>
				<?php
			} elseif ( 'style-2' === $style ) {
				?>
				<div class="team-2">
					<div class="team-image">
						<?php
						if ( has_post_thumbnail() ) {
							$img_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), 'cardealer-team-thumb' );
							$class   = 'img-responsive icon ' . $lazyload_class;
						} else {
							$img_url = $default_image;
							$class   = 'img-responsive icon';
						}

						if ( $lazyload ) {
							?>
							<img src="<?php echo esc_url( LAZYLOAD_IMG ); ?>" data-src="<?php echo esc_url( $img_url ) ?>" class="<?php echo esc_attr( $class ) ?>">
							<?php
						} else {
							?>
							<img src="<?php echo esc_url( $img_url ); ?>" class="img-responsive icon">
							<?php
						}
						?>
					</div>
					<div class="team-info">
						<div class="team-name">
							<?php
							if ( $designation ) {
								echo '<span>' . esc_html( $designation ) . '</span>';
							}
							?>
							<h5>
								<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
							</h5>
						</div>
						<?php
						if ( $facebook || $twitter || $pinterest || $behance ) {
							?>
							<div class="team-social">
								<ul>
									<?php
									if ( $facebook ) {
										echo '<li><a class="icon-1" href="' . esc_url( $facebook ) . '"><i class="fab fa-facebook-f"></i></a></li>';
									}
									if ( $twitter ) {
										echo '<li><a class="icon-2" href="' . esc_url( $twitter ) . '"><i class="fab fa-twitter"></i></a></li>';
									}
									if ( $pinterest ) {
										echo '<li><a class="icon-3" href="' . esc_url( $pinterest ) . '"><i class="fab fa-pinterest"></i></a></li>';
									}
									if ( $behance ) {
										echo '<li><a class="icon-4" href="' . esc_url( $behance ) . '"><i class="fab fa-behance"></i></a></li>';
									}
									?>
								</ul>
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<?php
			}
		} else {
			$i = 12 / $number_of_column;
			if ( 0 === (int) $k % $number_of_column ) {
				?>
				<div class="row">
				<?php
			}
			?>
			<div class='col-sm-<?php echo esc_attr( $i ); ?>'>
				<?php
				if ( 'style-1' === $style || 'style-3' === $style ) {
					?>
					<div class="team text-center">
						<div class="team-image">
							<?php
							if ( has_post_thumbnail() ) {
								$img_size = ( 'style-3' === $style ) ? 'cardealer-homepage-thumb' : 'cardealer-team-thumb';
								$img_url  = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), $img_size );
								$class    = 'img-responsive icon ' . $lazyload_class;
							} else {
								$img_url = $default_image;
								$class   = 'img-responsive icon';
							}

							if ( $lazyload ) {
								?>
								<img src="<?php echo esc_url( LAZYLOAD_IMG ); ?>" data-src="<?php echo esc_url( $img_url ) ?>" class="<?php echo esc_attr( $class ) ?>">
								<?php
							} else {
								?>
								<img src="<?php echo esc_url( $img_url ); ?>" class="img-responsive icon">
								<?php
							}

							if ( $facebook || $twitter || $pinterest || $behance ) {
								?>
								<div class="team-social">
									<ul>
									<?php
									if ( $facebook ) {
										echo '<li><a class="icon-1" href="' . esc_url( $facebook ) . '"><i class="fab fa-facebook-f"></i></a></li>';
									}
									if ( $twitter ) {
										echo '<li><a class="icon-2" href="' . esc_url( $twitter ) . '"><i class="fab fa-twitter"></i></a></li>';
									}
									if ( $pinterest ) {
										echo '<li><a class="icon-3" href="' . esc_url( $pinterest ) . '"><i class="fab fa-pinterest"></i></a></li>';
									}
									if ( $behance ) {
										echo '<li><a class="icon-4" href="' . esc_url( $behance ) . '"><i class="fab fa-behance"></i></a></li>';
									}
									?>
									</ul>
								</div>
								<?php
							}
							?>
						</div>
						<div class="team-name">
							<h5 class="text-black">
								<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
							</h5>
							<?php
							if ( $designation ) {
								echo "<span class='text-black'>" . esc_html( $designation ) . '</span>';
							}
							?>
						</div>
					</div>
					<?php
				} elseif ( 'style-2' === $style ) {
					?>
					<div class="team-2">
						<div class="team-image">
							<?php
							if ( has_post_thumbnail() ) {
								$img_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), 'cardealer-team-thumb' );
								$class   = 'img-responsive icon ' . $lazyload_class;
							} else {
								$img_url = $default_image;
								$class   = 'img-responsive icon';
							}

							if ( $lazyload ) {
								?>
								<img src="<?php echo esc_url( LAZYLOAD_IMG ); ?>" data-src="<?php echo esc_url( $img_url ) ?>" class="<?php echo esc_attr( $class ) ?>">
								<?php
							} else {
								?>
								<img src="<?php echo esc_url( $img_url ); ?>" class="<?php echo esc_attr( $class ) ?>">
								<?php
							}
							?>
						</div>
						<div class="team-info">
							<div class="team-name">
								<?php
								if ( $designation ) {
									echo '<span>' . esc_html( $designation ) . '</span>';
								}
								?>
								<h5>
									<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
								</h5>
							</div>
							<?php
							if ( $facebook || $twitter || $pinterest || $behance ) {
								?>
								<div class="team-social">
									<ul>
										<?php
										if ( $facebook ) {
											echo '<li><a class="icon-1" href="' . esc_url( $facebook ) . '"><i class="fab fa-facebook-f"></i></a></li>';
										}
										if ( $twitter ) {
											echo '<li><a class="icon-2" href="' . esc_url( $twitter ) . '"><i class="fab fa-twitter"></i></a></li>';
										}
										if ( $pinterest ) {
											echo '<li><a class="icon-3" href="' . esc_url( $pinterest ) . '"><i class="fab fa-pinterest"></i></a></li>';
										}
										if ( $behance ) {
											echo '<li><a class="icon-4" href="' . esc_url( $behance ) . '"><i class="fab fa-behance"></i></a></li>';
										}
										?>
									</ul>
								</div>
								<?php
							}
							?>
						</div>
					</div>
					<?php
				}
				?>
			</div>
			<?php
			$k++;
			if ( 0 === (int) $k % $number_of_column || $k === $posts_per_page ) {
				?>
				</div> 
				<?php
			}
		}
	}
	?>
	</div>
	<?php wp_reset_postdata(); ?>
</div>
