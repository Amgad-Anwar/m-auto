<?php
/**
 * Section title Elementor widget template
 *
 * @package car-dealer-helper
 */

$style              = isset( $settings['style'] ) ? $settings['style'] : 'style-1';
$section_title      = isset( $settings['section_title'] ) ? $settings['section_title'] : '';
$section_sub_title  = isset( $settings['section_sub_title'] ) ? $settings['section_sub_title'] : '';
$title_align        = isset( $settings['title_align'] ) ? $settings['title_align'] : 'text-center';
$section_number_tag = isset( $settings['section_number_tag'] ) ? $settings['section_number_tag'] : '';
$section_number     = isset( $settings['section_number'] ) ? $settings['section_number'] : '';
$hide_seperator     = isset( $settings['hide_seperator'] ) ? $settings['hide_seperator'] : '';
$show_content       = isset( $settings['show_content'] ) ? $settings['show_content'] : '';
$heading_tag        = isset( $settings['heading_tag'] ) ? $settings['heading_tag'] : '';
$content            = isset( $settings['content'] ) ? $settings['content'] : '';

if ( ! $section_title ) {
	return;
}

$this->add_render_attribute( 'cdhl_section_title', 'class', 'section-title ' . $title_align );
$this->add_render_attribute( 'cdhl_section_title', 'class', str_replace( '-', '_', $style ) );
$this->add_render_attribute( 'cdhl_section_title', 'id', $this->get_id() );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_section_title' ); ?>>
	<?php
	if ( 'style-2' === $style ) {
		?>
		<<?php echo esc_html( $section_number_tag ); ?> class="title-number">
			<?php echo esc_html( $section_number ); ?>
		</<?php echo esc_html( $section_number_tag ); ?>>
		<span class="main-title"><?php echo esc_html( $section_title ); ?></span>
		<?php
		if ( ! $hide_seperator ) {
			?>
			<div class="separator"></div>
			<?php
		}
	} else {
		?>
		<span class="sub-title"><?php echo esc_html( $section_sub_title ); ?></span>
		<<?php echo esc_html( $heading_tag ); ?> class="main-title">
			<?php echo esc_html( $section_title ); ?>
		</<?php echo esc_html( $heading_tag ); ?>>
		<?php
		if ( ! $hide_seperator ) {
			?>
			<div class="separator"></div>
			<?php
		}
		if ( $show_content && $content ) {
			?>
			<p><?php echo do_shortcode( $content ); ?></p>
			<?php
		}
	}
	?>
	</div>
</div>
