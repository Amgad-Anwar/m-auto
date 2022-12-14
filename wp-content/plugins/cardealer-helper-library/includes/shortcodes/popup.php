<?php
/**
 * CarDealer popup Shortcode
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package car-dealer-helper/functions
 */

add_shortcode( 'cd_popup', 'cdhl_shortcode_popup' );

/**
 * Shortcode HTML.
 *
 * @param array $atts .
 */
function cdhl_shortcode_popup( $atts ) {
	$atts = shortcode_atts(
		array(
			'button_title'        => esc_html__( 'Click Here', 'cardealer-helper' ),
			'content_source'      => 'page',
			'page_id'             => '',
			'popup_content'       => '',
			'size'                => 'medium',
			'alignment'           => '',
			'text_color'          => '',
			'text_bg_color'       => '',
			'text_hover_color'    => '',
			'text_hover_bg_color' => '',
			'full_width'          => '',
			'add_icon'            => false,
			'icon_position'       => 'before',
			'icon_type'           => 'fontawesome',
			'icon_fontawesome'    => 'fas fa-info-circle',
			'icon_openiconic'     => 'vc-oi vc-oi-dial',
			'icon_typicons'       => 'typcn typcn-adjust-brightness',
			'icon_entypo'         => 'entypo-icon entypo-icon-note',
			'icon_linecons'       => 'vc_li vc_li-heart',
			'icon_monosocial'     => 'vc-mono vc-mono-fivehundredpx',
			'icon_flaticon'       => 'glyph-icon flaticon-air-conditioning',
			'popup_width'         => '1000',
		),
		$atts
	);

	if ( empty( $atts['button_title'] ) ) {
		return;
	}

	$icon                 = '';
	$unique_id            = 'model-' . wp_rand( 0, 9999 ) . time();
	$unique_class         = 'button-' . wp_rand( 0, 9999 ) . time();
	$icon_position        = isset( $atts['icon_position'] ) ? $atts['icon_position'] : 'before';
	$icon_type            = isset( $atts['icon_type'] ) ? $atts['icon_type'] : 'fontawesome';
	$add_icon             = isset( $atts['add_icon'] ) ? $atts['add_icon'] : false;
	$full_width           = isset( $atts['full_width'] ) ? $atts['full_width'] : false;
	$size                 = isset( $atts['size'] ) ? $atts['size'] : '';
	$alignment            = isset( $atts['alignment'] ) ? $atts['alignment'] : '';
	$text_color           = isset( $atts['text_color'] ) ? $atts['text_color'] : '';
	$text_bg_color        = isset( $atts['text_bg_color'] ) ? $atts['text_bg_color'] : '';
	$text_hover_color     = isset( $atts['text_hover_color'] ) ? $atts['text_hover_color'] : '';
	$text_hover_bg_color  = isset( $atts['text_hover_bg_color'] ) ? $atts['text_hover_bg_color'] : '';
	$content_source       = isset( $atts['content_source'] ) ? $atts['content_source'] : 'page';
	$page_id              = isset( $atts['page_id'] ) ? (int) $atts['page_id'] : '';
	$popup_content        = isset( $atts['popup_content'] ) ? $atts['popup_content'] : '';
	$popup_content        = str_replace( array( '`{`', '`}`', '``' ), array( '[', ']', '"' ), $popup_content );
	$popup_width          = ( isset( $atts['popup_width'] ) && ! empty( $atts['popup_width'] ) ) ? $atts['popup_width'] . 'px' : '1000px';

	if ( $text_color || $text_bg_color || $text_hover_color || $text_hover_bg_color ) {
		$custom_css = '';
		if ( $text_color ) {
			$custom_css .= '.' . $unique_class . ' {color: ' . $text_color . ' !important;}';
		}

		if ( $text_bg_color ) {
			$custom_css .= '.' . $unique_class . ' {background-color: ' . $text_bg_color . ' !important;}';
		}

		if ( $text_hover_color ) {
			$custom_css .= '.' . $unique_class . ':hover, ' . $unique_class . ':focus {color: ' . $text_hover_color . ' !important;}';
		}

		if ( $text_hover_bg_color ) {
			$custom_css .= '.' . $unique_class . ':before {background-color: ' . $text_hover_bg_color . ' !important;}';
		}

		if ( $custom_css ) {
			wp_register_style( 'cd-popup-inline', false );
			wp_enqueue_style( 'cd-popup-inline' );
			wp_add_inline_style( 'cd-popup-inline', $custom_css );
		}
	}

	$button_class = 'button pgs_btn pgs-popup-btn ' . $unique_class;
	if ( $size ) {
		$button_class .= ' '. $size;
	}

	if ( $icon_position ) {
		$button_class .= ' ' . 'icon-position-' . $icon_position;
	}

	$button_outer_class = 'pgs-popup-shortcode-wrapper ';
	$button_outer_class .= ( $full_width ) ? 'btn-block' : 'btn-normal';
	if ( $alignment ) {
		$button_outer_class .= ' align-' . $alignment;
	}

	if ( $add_icon ) {
		$icon      = $atts[ 'icon_' . $icon_type ];
		vc_icon_element_fonts_enqueue( $icon_type );
	}

	ob_start();
	?>
	<div class="<?php echo esc_attr( $button_outer_class ); ?>">
		<a class="<?php echo esc_attr( $button_class ); ?>" href="#<?php echo esc_attr( $unique_id ); ?>">
			<?php
			if ( $add_icon && $icon && 'before' === $icon_position ) {
				?>
				<i class="<?php echo esc_attr( $icon ); ?>"></i>
				<?php
			}
			echo esc_html( $atts['button_title'] );
			if ( $add_icon && $icon && 'after' === $icon_position ) {
				?>
				<i class="<?php echo esc_attr( $icon ); ?>"></i>
				<?php
			}
			?>
		</a>
		<?php
		if ( ( 'page' === $content_source && $page_id ) || ( 'content' === $content_source && ! empty( $popup_content ) ) ) {
			?>
			<div class="pgs-popup-content-modal mfp-hide white-popup" id="<?php echo esc_attr( $unique_id ); ?>" style="<?php echo esc_attr( "max-width:$popup_width;" ); ?>">
				<button title="<?php esc_attr_e( 'Close (Esc)', 'cardealer-helper' ); ?>" type="button" class="mfp-close">&#215;</button>
				<div class="pgs-popup-content">
					<?php
					if ( 'page' === $content_source ) {
						if ( get_the_ID() === (int) $atts['page_id'] ) {
							?>
							<div class="alert alert-danger" role="alert" style="margin: 0;">
								<h4 class="alert-heading"><?php esc_html_e( 'Important Note', 'pgs-core' ); ?></h4>
								<p><?php esc_html_e( 'Please choose another page. You cannot select the same page on the page where you are adding the popup.', 'cardealer-helper' ); ?></p>
							</div>
							<?php
						} else {
							echo cdhl_get_page_content( $page_id ); // phpcs:ignore
						}
					} elseif ( 'content' === $content_source ) {
						echo do_shortcode( $popup_content );
					}
					?>
				</div>
			</div>
			<?php
		}
		?>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Shortcode mapping.
 *
 * @return void
 */
function cdhl_popup_shortcode_vc_map() {
	if ( function_exists( 'vc_map' ) ) {
		$list_of_pages_args = array();
		$current_page_id    = '';

		if ( ( isset( $_POST['action'] ) && 'vc_edit_form' === $_POST['action'] ) && ( isset( $_POST['post_id'] ) && ! empty( $_POST['post_id'] ) ) ) {
			$current_page_id = (int) sanitize_text_field( wp_unslash( $_POST['post_id'] ) );
		}

		if ( ! empty( $current_page_id ) ) {
			$list_of_pages_args['exclude'] = array( $current_page_id );
		}

		$select[0] = esc_html__( 'Select', 'cardealer-helper' );
		$pages     = function_exists( 'cdhl_get_list_of_pages' ) ? cdhl_get_list_of_pages( $list_of_pages_args ) : array();

		foreach ( $pages as $page_id => $page_title ) {
			$select[ $page_id ] = "$page_title ($page_id)";
		}

		$pages = array_flip( $select );

		$params = array(
			// Content
			array(
				'type'        => 'textfield',
				'param_name'  => 'button_title',
				'heading'     => esc_html__( 'Button Title', 'cardealer-helper' ),
				'description' => esc_html__( 'Enter title here', 'cardealer-helper' ),
				'value'       => esc_html__( 'Click Here', 'cardealer-helper' ),
				'group'       => esc_html__( 'Content', 'cardealer-helper' ),
			),
			array(
				'type'        => 'cd_html',
				'param_name'  => 'important_note_popup_content',
				'html'        => '<div style="margin-top: 15px;color: #f00;font-size: 16px;">' . wp_kses( __( '<strong>Important Note</strong>: Adding nested content (like a popup inside a popup) either will not work or break the structure.', 'cardealer-helper' ), array( 'strong' => array() ) ) . '</div>',
				'group'       => esc_html__( 'Content', 'cardealer-helper' ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Popup Content Source', 'cardealer-helper' ),
				'param_name'  => 'content_source',
				'value'       => array_flip( array(
					'page'    => esc_html__( 'Page', 'cardealer-helper' ),
					'content' => esc_html__( 'Content', 'cardealer-helper' ),
				) ),
				'default'     => 'page',
				'save_always' => true,
				'description' => esc_html__( 'Select page to show in popup.', 'cardealer-helper' ),
				'group'       => esc_html__( 'Content', 'cardealer-helper' ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Popup Page', 'cardealer-helper' ),
				'param_name'  => 'page_id',
				'value'       => $pages,
				'save_always' => true,
				'description' => esc_html__( 'Select page to show in popup.', 'cardealer-helper' ),
				'group'       => esc_html__( 'Content', 'cardealer-helper' ),
				'dependency'  => array(
					'element' => 'content_source',
					'value'   => 'page',
				),
			),
			array(
				'type'        => 'textarea',
				'heading'     => esc_html__( 'Popup Content', 'cardealer-helper' ),
				'param_name'  => 'popup_content',
				'description' => esc_html__( 'Enter popup content here. You can add shortcode too.', 'cardealer-helper' ),
				'group'       => esc_html__( 'Content', 'cardealer-helper' ),
				'dependency'  => array(
					'element' => 'content_source',
					'value'   => 'content',
				),
			),

			// Style
			array(
				'type'             => 'cd_number_min_max',
				'heading'          => esc_html__( 'Popup Width', 'cardealer-helper' ),
				'param_name'       => 'popup_width',
				'min'              => '100',
				'max'              => '1800',
				'step'             => '5',
				'value'            => '1000',
				// 'edit_field_class' => 'vc_col-sm-6 vc_column',
				'group'       => esc_html__( 'Style', 'cardealer-helper' ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Size', 'cardealer-helper' ),
				'param_name'  => 'size',
				'value'       => array(
					esc_html__( 'Extra Small', 'cardealer-helper' ) => 'extra-small',
					esc_html__( 'Small', 'cardealer-helper' )       => 'small',
					esc_html__( 'Medium', 'cardealer-helper' )      => 'medium',
					esc_html__( 'Large', 'cardealer-helper' )       => 'large',
				),
				'description'      => esc_html__( 'Select size.', 'cardealer-helper' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'admin_label'      => true,
				'save_always'      => true,
				'group'            => esc_html__( 'Style', 'cardealer-helper' ),
			),
			array(
				'type'       => 'dropdown',
				'param_name' => 'alignment',
				'value'      => 'left',
				'heading'    => esc_html__( 'Alignment', 'cardealer-helper' ),
				'value'      => array(
					'Left'   => 'left',
					'Right'  => 'right',
					'Center' => 'center',
				),
				'default'    => 'left',
				'edit_field_class' => 'vc_col-sm-6 vc_column',
				'group'      => esc_html__( 'Style', 'cardealer-helper' ),
			),
			array(
				'type'             => 'colorpicker',
				'param_name'       => 'text_color',
				'value'            => '#ffffff',
				'heading'          => esc_html__( 'Text Color', 'cardealer-helper' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
				'description'      => esc_html__( 'Choose text color.', 'cardealer-helper' ),
				'save_always'      => true,
				'group'            => esc_html__( 'Style', 'cardealer-helper' ),
			),
			array(
				'type'             => 'colorpicker',
				'param_name'       => 'text_bg_color',
				'value'            => '',
				'heading'          => esc_html__( 'Background Color', 'cardealer-helper' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
				'description'      => esc_html__( 'Choose background color.', 'cardealer-helper' ),
				'save_always'      => true,
				'group'            => esc_html__( 'Style', 'cardealer-helper' ),
			),
			array(
				'type'             => 'colorpicker',
				'param_name'       => 'text_hover_color',
				'value'            => '#ffffff',
				'heading'          => esc_html__( 'Hover Text Color', 'cardealer-helper' ),
				'description'      => esc_html__( 'Choose text hover color.', 'cardealer-helper' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
				'save_always'      => true,
				'group'            => esc_html__( 'Style', 'cardealer-helper' ),
			),
			array(
				'type'             => 'colorpicker',
				'param_name'       => 'text_hover_bg_color',
				'value'            => '',
				'heading'          => esc_html__( 'Hover Background Color', 'cardealer-helper' ),
				'edit_field_class' => 'vc_col-sm-6 vc_column vc_column-with-padding',
				'description'      => esc_html__( 'Choose backgound hover color.', 'cardealer-helper' ),
				'save_always'      => true,
				'group'            => esc_html__( 'Style', 'cardealer-helper' ),
			),
			array(
				'type'        => 'checkbox',
				'heading'     => esc_html__( 'Full Width ?', 'cardealer-helper' ),
				'param_name'  => 'full_width',
				'value'       => array(
					esc_html__( 'Enable full width', 'cardealer-helper' ) => 'enable',
				),
				'description' => esc_html__( 'Check this box to enable full width.', 'cardealer-helper' ),
				'group'       => esc_html__( 'Style', 'cardealer-helper' ),
			),
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add icon?', 'cardealer-helper' ),
				'param_name' => 'add_icon',
				'group'            => esc_html__( 'Style', 'cardealer-helper' ),
			),
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Icon Position', 'cardealer-helper' ),
				'param_name'  => 'icon_position',
				'value'       => array(
					esc_html__( 'Before', 'cardealer-helper' ) => 'before',
					esc_html__( 'After', 'cardealer-helper' )  => 'after',
				),
				'dependency'  => array(
					'element' => 'add_icon',
					'value'   => 'true',
				),
				'group'            => esc_html__( 'Style', 'cardealer-helper' ),
			),
		);

		$params = array_merge(
			$params,
			cdhl_iconpicker(
				array(
					'element' => 'add_icon',
					'value'   => 'true',
				),
				array(
					'group' => esc_html__( 'Style', 'cardealer-helper' ),
				)
			),
			array(
				array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'CSS box', 'cardealer-helper' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design Options', 'cardealer-helper' ),
				),
			)
		);

		vc_map(
			array(
				'name'                    => esc_html__( 'Potenza Popup', 'cardealer-helper' ),
				'description'             => esc_html__( 'Potenza Popup', 'cardealer-helper' ),
				'base'                    => 'cd_popup',
				'class'                   => 'cardealer_helper_element_wrapper',
				'controls'                => 'full',
				'icon'                    => cardealer_vc_shortcode_icon( 'cd_popup' ),
				'category'                => esc_html__( 'Potenza', 'cardealer-helper' ),
				'show_settings_on_create' => true,
				'params'                  => $params
			)
		);
	}
}
add_action( 'vc_before_init', 'cdhl_popup_shortcode_vc_map' );
