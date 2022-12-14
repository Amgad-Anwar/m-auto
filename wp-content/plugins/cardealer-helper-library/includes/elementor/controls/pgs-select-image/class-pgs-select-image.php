<?php
namespace Cdhl_Elementor\Controls;

use Elementor\Base_Data_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Elementor select image control.
 *
 * @since 1.0.0
 */
class PGS_Select_Image extends Base_Data_Control {

	/**
	 * The type of control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'pgs_select_image';

	/**
	 * Get select control type.
	 *
	 * Retrieve the control type, in this case `select`.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Control type.
	 */
	public function get_type() {
		return $this->type;
	}

	/**
	 * Enqueue emoji one area control scripts and styles.
	 *
	 * Used to register and enqueue custom scripts and styles used by the emoji one
	 * area control.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enqueue() {
		// Styles
		wp_register_style( 'pgs-select-image', trailingslashit( CDHL_ELEMENTOR_URL ) . 'controls/pgs-select-image/pgs-select-image.css', array(), false );
		wp_enqueue_style( 'pgs-select-image' );

		// Scripts
		wp_register_script( 'pgs-select-image-control', trailingslashit( CDHL_ELEMENTOR_URL ) . 'controls/pgs-select-image/pgs-select-image.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'pgs-select-image-control' );
	}

	/**
	 * Get select control default settings.
	 *
	 * Retrieve the default settings of the select control. Used to return the
	 * default settings while initializing the select control.
	 *
	 * @since 2.0.0
	 * @access protected
	 *
	 * @return array Control default settings.
	 */
	protected function get_default_settings() {
		return [
			'options' => array(),
		];
	}

	/**
	 * Render select control output in the editor.
	 *
	 * Used to generate the control HTML in the editor using Underscore JS
	 * template. The variables for the class are available using `data` JS
	 * object.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function content_template() {
		$control_uid = $this->get_control_uid();
		?>
		<div class="elementor-control-field elementor-control-media">
			<#
			var selected_option = _.find(data.options, function (option_data, option_value) {
				return option_value == data.controlValue;
			})
			#>

			<# if ( data.label ) {#>
				<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">{{{ data.label }}}</label>
			<# } #>
			<div class="elementor-control-input-wrapper elementor-control-unit-5">
				<select id="<?php echo esc_attr( $control_uid ); ?>" data-setting="{{ data.name }}">
				<#
					var printOptions = function( options ) {
						_.each( options, function( option_data, option_value ) { #>
							<option value="{{ option_value }}" data-option_img="{{ option_data.image }}">{{{ option_data.label }}}</option>
						<# } );
					};

					printOptions( data.options );
				#>
				</select>
			</div>
			<div class="elementor-control-input-preview-wrapper">
				<img class="elementor-control-media__preview" src="{{{ selected_option.image }}}" />
			</div>
		</div>
		<# if ( data.description ) { #>
			<div class="elementor-control-field-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}
}
