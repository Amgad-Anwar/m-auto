<?php
/**
 * Share Elementor widget template
 *
 * @package car-dealer-helper
 */

$add_pdf            = isset( $settings['add_pdf'] ) ? $settings['add_pdf'] : '';
$pdf_label          = isset( $settings['pdf_label'] ) ? $settings['pdf_label'] : '';
$add_video          = isset( $settings['add_video'] ) ? $settings['add_video'] : '';
$video_label        = isset( $settings['video_label'] ) ? $settings['video_label'] : '';
$video_url          = isset( $settings['video_url'] ) ? $settings['video_url'] : '';
$pdf_file           = isset( $settings['pdf_file'] ) ? json_decode( $settings['pdf_file'], JSON_OBJECT_AS_ARRAY ) : array();
$social_icons       = isset( $settings['social_icons'] ) ? $settings['social_icons'] : array();
$social_icons_label = isset( $settings['social_icons_label'] ) ? $settings['social_icons_label'] : '';
$color_class        = ( isset( $settings['back_color'] ) && $settings['back_color'] ) ? ' cd-back-color' : '';

$this->add_render_attribute( 'cdhl_share', 'class', 'overview-share' . $color_class );
$this->add_render_attribute( 'cdhl_share', 'id', 'cardealer_share_' . $this->get_id() );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_share' ); ?> >
		<?php
		if ( 'true' === $add_pdf && isset( $pdf_file['url'] ) ) {
			?>
			<div class="pdf">
				<div class="icon"> 
					<i class="far fa-file-pdf"></i>
				</div>
				<div class="info">
					<a href="<?php echo esc_url( $pdf_file['url'] ); ?>" download>
						<?php echo esc_html( $pdf_label ); ?>
					</a>
				</div>
			</div>
			<?php
		}
		if ( 'true' === $add_video && $video_url && ( strpos( $video_url, 'youtube' ) > 0 || strpos( $video_url, 'vimeo' ) > 0 || strpos( $video_url, 'youtu.be' ) > 0 ) ) {
			?>
			<div class="see-video">
				<div class="icon"> 
					<i class="fas fa-play"></i>
				</div>
				<div class="info">
					<a class="popup-youtube" href="<?php echo esc_url( $video_url ); ?>"> 
						<?php echo esc_html( $video_label ); ?>
					</a>
				</div>
			</div>
			<?php
		}
		if ( $social_icons ) {
			?>
			<div class="share">
				<span><?php echo esc_html( $social_icons_label ); ?></span>
				<ul class="list-unstyled">
					<?php
					foreach ( $social_icons as $icon ) {
						?>
						<li>
							<a href="javascript:void(0)" class="<?php echo esc_attr( str_replace( '-', '', $icon ) ); ?>-share"data-title="<?php echo esc_attr( get_the_title() ); ?>" data-url="<?php echo esc_url( get_permalink() ); ?>">
								<i class="fa fa-<?php echo esc_attr( $icon ); ?>"></i>
							</a>
						</li>
						<?php
					}
					?>
				</ul>
			</div>
			<?php
		}
		?>
	</div>
</div>
