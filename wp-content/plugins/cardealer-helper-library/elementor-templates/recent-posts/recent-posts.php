<?php
/**
 * Recent Posts Elementor widget template
 *
 * @package car-dealer-helper
 */

$style       = isset( $settings['style'] ) ? $settings['style'] : '';
$no_of_posts = isset( $settings['no_of_posts'] ) ? $settings['no_of_posts'] : '-1';

$args = array(
	'post_type'           => 'post',
	'post_status'         => array( 'publish' ),
	'posts_per_page'      => $no_of_posts,
	'ignore_sticky_posts' => true,
);

$post_meta_info = new WP_Query( $args );
if ( ! $post_meta_info->have_posts() ) {
	return;
}

$this->add_render_attribute( 'cdhl_recent_posts', 'class', 'our-blog page-section-pb our-blog-' . $style );
$this->add_render_attribute( 'cdhl_recent_posts', 'id', $this->get_id() );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_recent_posts' ); ?>>
		<div class="row">
			<?php
			while ( $post_meta_info->have_posts() ) {
				$post_meta_info->the_post();
				$this->get_templates( "{$this->widget_slug}/style/" . $style, null, array( 'settings' => $settings ) );
			}
			wp_reset_postdata();
			?>
		</div>
	</div>
</div>
