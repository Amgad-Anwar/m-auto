<?php
/**
 * Feature box slider Elementor widget template
 *
 * @package car-dealer-helper
 */

$list_items = isset( $settings['list_items'] ) ? $settings['list_items'] : '';
$this->add_render_attribute(
	[
		'cdhl_feature_box_slider' => [
			'class'         => [
				'owl-carousel',
				'cd-featured-carousel',
				'cardealer-featured-box-carousel',
			],
			'data-loop'     => [
				'false',
			],
			'data-space'    => [
				'20',
			],
			'data-nav-dots' => [
				'true',
			],
			'data-items'    => [
				'3',
			],
			'data-md-items' => [
				'2',
			],
			'data-sm-items' => [
				'1',
			],
			'data-xs-items' => [
				'1',
			],
		],
	]
);
?>
<div <?php $this->print_render_attribute_string( 'widget_wrapper' ); ?>>
	<div <?php $this->print_render_attribute_string( 'cdhl_feature_box_slider' ); ?>>
	<?php
	foreach ( $list_items as $list_item  ) {
		$e_id                = isset( $list_item['_id'] ) ? $list_item['_id'] : uniqid();
		$cdhl_feature_box_id = 'cdhl_feature_box_' . $e_id;
		$style               = isset( $list_item['style'] ) ? $list_item['style'] : '';
		$fb_title            = isset( $list_item['title'] ) ? $list_item['title'] : '';
		$description         = isset( $list_item['description'] ) ? $list_item['description'] : '';
		$back_image          = isset( $list_item['back_image'] ) ? $list_item['back_image'] : '';
		$back_image_url      = isset( $list_item['back_image_url']['url'] ) ? $list_item['back_image_url']['url'] : '';
		$border              = isset( $list_item['border'] ) ? $list_item['border'] : '';
		$hover_style         = isset( $list_item['hover_style'] ) ? $list_item['hover_style'] : '';
		$icon                = isset( $list_item['icon'] ) ? $list_item['icon'] : '';

		$this->add_render_attribute( $cdhl_feature_box_id, 'class', 'elementor-repeater-item-' . $list_item['_id'] );
		if ( $style ) {
			$this->add_render_attribute( $cdhl_feature_box_id, 'class', $style );
		} else {
			$this->add_render_attribute( $cdhl_feature_box_id, 'class', 'text-center' );
		}

		if ( 'style-1' === $style ) {
			$this->add_render_attribute( $cdhl_feature_box_id, 'class', 'round-icon' );
		} elseif ( 'style-2' === $style ) {
			$this->add_render_attribute( $cdhl_feature_box_id, 'class', 'round-icon left' );
		} elseif ( 'style-3' === $style ) {
			$this->add_render_attribute( $cdhl_feature_box_id, 'class', 'round-icon right' );
		} elseif ( 'style-4' === $style ) {
			$this->add_render_attribute( $cdhl_feature_box_id, 'class', 'default-feature' );
		} elseif ( 'style-5' === $style ) {
			$this->add_render_attribute( $cdhl_feature_box_id, 'class', 'left-icon' );
		} elseif ( 'style-6' === $style ) {
			$this->add_render_attribute( $cdhl_feature_box_id, 'class', 'right-icon' );
		} elseif ( 'style-6' === $style ) {
			$this->add_render_attribute( $cdhl_feature_box_id, 'class', 'text-right' );
		} elseif ( 'style-7' === $style ) {
			$this->add_render_attribute( $cdhl_feature_box_id, 'class', 'round-border' );
		} elseif ( 'style-8' === $style || 'style-10' === $style ) {
			$this->add_render_attribute( $cdhl_feature_box_id, 'class', 'left-align' );
		} elseif ( 'style-9' === $style ) {
			$this->add_render_attribute( $cdhl_feature_box_id, 'class', 'right-align' );
		}

		if ( 'true' === $hover_style ) {
			$this->add_render_attribute( $cdhl_feature_box_id, 'class', 'box-hover' );
		}

		if ( 'true' === $border ) {
			$this->add_render_attribute( $cdhl_feature_box_id, 'class', 'feature-border' );
		}

		if ( ! $back_image && ! $back_image_url ) {
			$this->add_render_attribute( $cdhl_feature_box_id, 'class', 'no-image' );
		}

		if ( isset( $list_item['url']['url'] ) && $list_item['url']['url'] ) {
			$this->add_render_attribute( 'cdhl_feature_box_button_' . $e_id, 'id', $e_id );
			if ( isset( $list_item['url']['is_external'] ) && $list_item['url']['is_external'] ) {
				$this->add_render_attribute( 'cdhl_feature_box_button_' . $e_id, 'target', '_blank' );
			}
			if ( isset( $list_item['url']['nofollow'] ) && $list_item['url']['nofollow'] ) {
				$this->add_render_attribute( 'cdhl_feature_box_button_' . $e_id, 'rel', 'nofollow' );
			}
			if ( isset( $list_item['url']['url'] ) && $list_item['url']['url'] ) {
				$this->add_render_attribute( 'cdhl_feature_box_button_' . $e_id, 'href', $list_item['url']['url'] );
			}
		}

		$this->add_render_attribute( $cdhl_feature_box_id, 'class', 'feature-box' );
		$this->add_render_attribute( $cdhl_feature_box_id, 'id', 'cd_feature_box_' . $e_id );
		?>
		<div <?php $this->print_render_attribute_string( $cdhl_feature_box_id ); ?> >
			<?php
			if ( $back_image_url ) {
				?>
				<img class="img-responsive center-block" src="<?php echo esc_url( $back_image_url ); ?>" alt="">
				<?php
			}
			if ( $icon ) {
				?>
				<div class="icon">
					<?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
				</div>
				<?php
			}
			?>
			<div class="content">
				<a <?php $this->print_render_attribute_string( 'cdhl_feature_box_button_' . $e_id ); ?>>
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
		<?php
	}
	?>
	</div>
</div>
