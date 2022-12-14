<?php
/**
 * Custom Menu Elementor widget template
 *
 * @package car-dealer-helper
 */

$style          = isset( $settings['style'] ) ? $settings['style'] : '';
$fb_title       = isset( $settings['title'] ) ? $settings['title'] : '';
$description    = isset( $settings['description'] ) ? $settings['description'] : '';
$back_image     = isset( $settings['back_image'] ) ? $settings['back_image'] : '';
$back_image_url = isset( $settings['back_image_url']['url'] ) ? $settings['back_image_url']['url'] : '';
$border         = isset( $settings['border'] ) ? $settings['border'] : '';
$hover_style    = isset( $settings['hover_style'] ) ? $settings['hover_style'] : '';
$icon           = isset( $settings['icon'] ) ? $settings['icon'] : '';

if ( ! $fb_title ) {
	return;
}

if ( $style ) {
	$this->add_render_attribute( 'cdhl_feature_box', 'class', $style );
} else {
	$this->add_render_attribute( 'cdhl_feature_box', 'class', 'text-center' );
}

if ( 'style-1' === $style ) {
	$this->add_render_attribute( 'cdhl_feature_box', 'class', 'round-icon' );
} elseif ( 'style-2' === $style ) {
	$this->add_render_attribute( 'cdhl_feature_box', 'class', 'round-icon left' );
} elseif ( 'style-3' === $style ) {
	$this->add_render_attribute( 'cdhl_feature_box', 'class', 'round-icon right' );
} elseif ( 'style-4' === $style ) {
	$this->add_render_attribute( 'cdhl_feature_box', 'class', 'default-feature' );
} elseif ( 'style-5' === $style ) {
	$this->add_render_attribute( 'cdhl_feature_box', 'class', 'left-icon' );
} elseif ( 'style-6' === $style ) {
	$this->add_render_attribute( 'cdhl_feature_box', 'class', 'right-icon' );
} elseif ( 'style-6' === $style ) {
	$this->add_render_attribute( 'cdhl_feature_box', 'class', 'text-right' );
} elseif ( 'style-7' === $style ) {
	$this->add_render_attribute( 'cdhl_feature_box', 'class', 'round-border' );
} elseif ( 'style-8' === $style || 'style-10' === $style ) {
	$this->add_render_attribute( 'cdhl_feature_box', 'class', 'left-align' );
} elseif ( 'style-9' === $style ) {
	$this->add_render_attribute( 'cdhl_feature_box', 'class', 'right-align' );
}

if ( 'true' === $hover_style ) {
	$this->add_render_attribute( 'cdhl_feature_box', 'class', 'box-hover' );
}

if ( 'true' === $border ) {
	$this->add_render_attribute( 'cdhl_feature_box', 'class', 'feature-border' );
}

if ( ! $back_image && ! $back_image_url ) {
	$this->add_render_attribute( 'cdhl_feature_box', 'class', 'no-image' );
}

if ( isset( $settings['url']['url'] ) && $settings['url']['url'] ) {
	$this->add_render_attribute( 'cdhl_feature_box_button', 'id', $this->get_id() );
	if ( isset( $settings['url']['is_external'] ) && $settings['url']['is_external'] ) {
		$this->add_render_attribute( 'cdhl_feature_box_button', 'target', '_blank' );
	}
	if ( isset( $settings['url']['nofollow'] ) && $settings['url']['nofollow'] ) {
		$this->add_render_attribute( 'cdhl_feature_box_button', 'rel', 'nofollow' );
	}
	if ( isset( $settings['url']['url'] ) && $settings['url']['url'] ) {
		$this->add_render_attribute( 'cdhl_feature_box_button', 'href', $settings['url']['url'] );
	}
}

$this->add_render_attribute( 'cdhl_feature_box', 'class', 'feature-box' );
$this->add_render_attribute( 'cdhl_feature_box', 'id', 'cd_feature_box_' . $this->get_id() );
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_feature_box' ); ?> >
		<?php
		if ( $back_image_url ) {
			?>
			<img class="img-responsive center-block" src="<?php echo esc_url( $back_image_url ); ?>" alt="">
			<?php
		}
		?>
		<div class="icon">
			<?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
		</div>
		<div class="content">
			<a <?php $this->print_render_attribute_string( 'cdhl_feature_box_button' ); ?>>
				<?php
				if ( $fb_title ) {
					echo '<h6>' . esc_html( $fb_title ) . '</h6>';
				}
				?>
			</a>
			<?php
			if ( $description ) {
				echo '<p>' . esc_html( $description ) . '</p>';
			}
			?>
		</div>
	</div>
</div>
