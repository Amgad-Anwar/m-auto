<?php
/**
 * Video Slider Elementor widget template
 *
 * @package car-dealer-helper
 */

$video_links = isset( $settings['videos'] ) ? $settings['videos'] : '';

$this->add_render_attribute( 'cdhl_video_slider', 'class', 'video-slider slick_sider' );
$this->add_render_attribute( 'cdhl_video_slider', 'id', 'cd_video_slider_' . $this->get_id() );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_video_slider' ); ?>>
		<div class="sliderMain">
			<?php
			foreach ( $video_links as $v_link ) {
				if ( isset( $v_link['video_url'] ) && $v_link['video_url'] ) {
					$video_type = cdhl_check_video_type( $v_link['video_url'] );
					if ( $video_type && 'other' !== $video_type ) {
						if ( 'youtube' === $video_type ) {
							$video_id = cdhl_get_video_id( 'youtube', $v_link['video_url'] );
							if ( ! $video_id ) {
								continue;
							}
							?>
							<div class="item youtube">
								<iframe id="<?php echo esc_attr( $video_type ); ?>_<?php echo esc_attr( $this->get_id() ); ?>" width="920" height="518" src="//www.youtube.com/embed/<?php echo esc_attr( $video_id ); ?>?rel=0&amp;enablejsapi=1&showinfo=0&loop=1" frameborder="0" allowfullscreen></iframe><!-- Make sure to enable the API by appending the "&enablejsapi=1" parameter onto the URL. -->
							</div>
							<?php
						} else {
							$video_id = cdhl_get_video_id( 'vimeo', $v_link['video_url'] );
							if ( ! $video_id ) {
								continue;
							}
							?>
							<div class="item vimeo">
								<iframe id="<?php echo esc_attr( $video_type ); ?>_<?php echo esc_attr( $this->get_id() ); ?>" width="920" height="518" src="https://player.vimeo.com/video/<?php echo esc_attr( $video_id ); ?>?byline=0&amp;portrait=0&amp;api=1&loop=1" frameborder="0" allowfullscreen></iframe> <!-- Make sure to enable the API by appending the "&enablejsapi=1" parameter onto the URL. -->
							</div>
							<?php
						}
					}
				}
			}
			?>
		</div>
		<div class="sliderSidebar">
			<?php
			foreach ( $video_links as $v_link ) {
				if ( isset( $v_link['video_url'] ) && $v_link['video_url'] ) {
					$video_type = cdhl_check_video_type( $v_link['video_url'] );
					if ( $video_type ) {
						if ( 'vimeo' === $video_type ) {
							$video_id = cdhl_get_video_id( 'vimeo', $v_link['video_url'] );
							if ( ! $video_id ) {
								continue;
							}
							$url = cdhl_get_vimeo_thumb_image_url( $video_id, '320x180' );
						} elseif ( 'youtube' === $video_type ) {
							$video_id = cdhl_get_video_id( 'youtube', $v_link['video_url'] );
							if ( ! $video_id ) {
								continue;
							}
							$url = ( is_ssl() ? 'https' : 'http' ) . '://i3.ytimg.com/vi/' . $video_id . '/mqdefault.jpg';
						} else {
							continue;
						}
						?>
						<div class="item"><img src="<?php echo esc_url( $url ); ?>" /></div>
						<?php
					}
				}
			}
			?>
		</div>
	</div>
</div>
