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
class PGS_File_Upload extends Base_Data_Control {

	/**
	 * The type of control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'pgs_file_upload';

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
		wp_register_style( 'pgs-file-upload', trailingslashit( CDHL_ELEMENTOR_URL ) . 'controls/pgs-file-upload/pgs-file-upload.css', array(), false );
		wp_enqueue_style( 'pgs-file-upload' );

		// Scripts
		wp_register_script( 'pgs-file-upload', trailingslashit( CDHL_ELEMENTOR_URL ) . 'controls/pgs-file-upload/pgs-file-upload.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'pgs-file-upload' );
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
            'label'     => 'Upload File',
            'mime_type' => 'application/pdf',
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
		<#
		var getImageData = '';
		if ( data.controlValue ) {
			getImageData = JSON.parse( data.controlValue );
		}
		#>
		<div class="elementor-control-field pgs-elementor-control-file">
			<label for="<?php echo esc_attr( $control_uid ); ?>" class="elementor-control-title">
				{{{ data.label }}}
			</label>

            <div class="elementor-control-input-wrapper pgs-elementor-control-file-upload-wrapper">
				<div style="flex-grow:1;">
					<a href="#" class="pgs-field-file-button elementor-button elementor-button-success" data-mime="{{data.mime_type}}">
						<# if ( ! getImageData ) { #>
							<?php esc_html_e( 'Select', 'cardealer-helper' ); ?>
						<# } #>
						<# if ( getImageData ) { #>
						<?php esc_html_e( 'Edit', 'cardealer-helper' ); ?>
						<# } #>
					</a>
				</div>
				<# if ( getImageData ) { #>
					<div style="flex-shrink:1;">
						<a href="#" class="pgs-file-remove elementor-button elementor-button-danger" title="<?php esc_html_e( 'Remove', 'cardealer-helper' ); ?>">
							<i class="eicon-trash" style="margin-right:0;"></i>
						</a>
					</div>
				<# } #>
				<input class="pgs-file-data" id="<?php echo esc_attr( $control_uid ); ?>" data-setting="{{ data.name }}" type="hidden" />
				<# if ( getImageData ) {
					#>
					<div class="pgs-file-content">
						<div class="pgs-file-info">
							<a href="{{ getImageData.url }}" target="_blank">{{ getImageData.title }}</a>
						</div>
					</div>
					<#
				}
				#>
            </div>
        </div>
		<?php
	}
}
