<?php
/**
 * Video Elementor widget template
 *
 * @package car-dealer-helper
 */

$video_link        = isset( $settings['video_link'] ) ? $settings['video_link'] : '';
$video_position    = isset( $settings['video_position'] ) ? $settings['video_position'] : '';
$video_image_title = esc_html__( 'Video Img', 'cardealer-helper' );

if ( ! $video_link ) {
	if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
		?>
		<div class="alert alert-danger" role="alert" style="margin: 0;">
			<h4 class="alert-heading"><?php esc_html_e( 'Important Note', 'cardealer-helper' ); ?></h4>
			<p><?php esc_html_e( 'If "Video URL" is not set, the widget content will not be rendered. Please enter Video URL to display widget content.', 'cardealer-helper' ); ?></p>
		</div>
		<?php
	}
	return;
}

if ( isset( $settings['video_img'] ) && isset( $settings['video_img']['id'] ) && $settings['video_img']['id'] ) {
	$video_image_data = wp_get_attachment_image_src( $settings['video_img']['id'], 'full' );
	$video_img_arr    = ( function_exists( 'cardealer_get_attachment_detail' ) ) ? cardealer_get_attachment_detail( $settings['video_img']['id'] ) : '';

	if ( isset( $video_img_arr['alt'] ) && $video_img_arr['alt'] ) {
		$video_image_title = $video_img_arr['alt'];
	}
}

if ( isset( $video_image_data[0] ) && $video_image_data[0] ) {
	$video_image = $video_image_data[0];
} else {
	$video_image = trailingslashit( CDHL_URL ) . 'images/bg/07.jpg';
}

$this->add_render_attribute( 'cdhl_video', 'class', 'play-video popup-gallery ' . $video_position );
$this->add_render_attribute( 'cdhl_video_outer', 'class', 'video-info text-center' );

if ( cardealer_lazyload_enabled() ) {
	$this->add_render_attribute(
		[
			'cdhl_video_image' => [
				'class'    => 'img-responsive center-block cardealer-lazy-load',
				'src'      => LAZYLOAD_IMG,
				'data-src' => $video_image,
				'alt'      => $video_image_title,
			],
		]
	);
} else {
	$this->add_render_attribute(
		[
			'cdhl_video_image' => [
				'class' => 'img-responsive center-block',
				'src'   => $video_image,
				'alt'   => $video_image_title,
			],
		]
	);
}

$this->add_render_attribute(
	[
		'cdhl_video_popup' => [
			'class' => 'popup-video',
			'href'  => $video_link,
		],
	]
);
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_video' ); ?>>
		<div <?php $this->print_render_attribute_string( 'cdhl_video_outer' ); ?>>
			<img <?php $this->print_render_attribute_string( 'cdhl_video_image' ); ?>>
			<a <?php $this->print_render_attribute_string( 'cdhl_video_popup' ); ?>><i class="fas fa-play"></i></a>
		</div>
	</div>
</div>
