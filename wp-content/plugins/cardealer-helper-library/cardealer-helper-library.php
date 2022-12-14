<?php
/**
 * Plugin Name:       Car Dealer - Helper Library
 * Plugin URI:        http://www.potenzaglobalsolutions.com/
 * Description:       This plugin contains important functions and features for "Car Dealer" theme.
 * Version:           3.6.0
 * Author:            Potenza Global Solutions
 * Author URI:        http://www.potenzaglobalsolutions.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cardealer-helper
 *
 * @package car-dealer-helper/functions
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$cdhl_current_theme_data = wp_get_theme( get_template() );
if ( 'CarDealer' !== $cdhl_current_theme_data->get( 'Name' ) && ! apply_filters( 'cdhl_accessible_with_non_cd_theme', false ) ) {
	return;
}

if ( ! defined( 'CDHL_PATH' ) ) {
	define( 'CDHL_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'CDHL_URL' ) ) {
	define( 'CDHL_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'CDHL_VER_LOG' ) ) {
	define( 'CDHL_VER_LOG', str_replace( '\\', '/', WP_CONTENT_DIR ) . '/uploads/cardealer-helper/update-logs/' );
}
if ( ! defined( 'CDHL_LOG' ) ) {
	define( 'CDHL_LOG', str_replace( '\\', '/', WP_CONTENT_DIR ) . '/uploads/cardealer-helper/back-process-logs/' );
}

if ( ! defined( 'CDHL_THEME_OPTIONS_NAME' ) ) {
	define( 'CDHL_THEME_OPTIONS_NAME', 'car_dealer_options' );
}
if ( ! defined( 'CDHL_VERSION' ) ) {
	define( 'CDHL_VERSION', '3.6.0' );
}
if ( ! defined( 'PGS_ENVATO_API' ) ) {
	define( 'PGS_ENVATO_API', 'http://envatoapi.potenzaglobalsolutions.com/' );
}
global $cdhl_globals;
$cdhl_globals = array();


// Plugin activation/deactivation hooks.
register_activation_hook( __FILE__, 'cdhl_activate' );
register_deactivation_hook( __FILE__, 'cdhl_deactivate' );
add_action( 'plugins_loaded', 'cdhl_helper_theme_functions_load_textdomain', 0 );
if ( ! function_exists( 'cdhl_helper_theme_functions_load_textdomain' ) ) {
	/**
	 * Load plugin textdomain.
	 *
	 * @since 1.0.0
	 */
	function cdhl_helper_theme_functions_load_textdomain() {
		load_plugin_textdomain( 'cardealer-helper', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}
}
if ( ! function_exists( 'cdhl_activate' ) ) {
	/**
	 * The code that runs during plugin activation.
	 */
	function cdhl_activate() {
		// Display admin notice if Visual Composer is not activated.
		add_action( 'admin_notices', 'cdhl_is_vc_active' );
		add_action( 'admin_notices', 'cdhl_plugin_active_notices' );

		// For Version From 1.0.3.
		$default_version = get_option( 'cdhl_version' );
		if ( ( false !== (bool) $default_version ) && ( (bool) version_compare( '0.0.0', $default_version, '=' ) === true ) ) {
			update_option( 'cdhl_version', CDHL_VERSION );
			update_option( 'cdhl_version_status', 'up-to-date' );
		}
	}
}

if ( ! function_exists( 'cdhl_deactivate' ) ) {
	/**
	 * The code that runs during plugin deactivation.
	 */
	function cdhl_deactivate() {
		// TODO: Add settings for plugin deactivation.
		$dependent = 'cardealer-front-submission/cardealer-frontend-submission.php';
		if ( cdhl_plugin_active_status( $dependent ) ) {
			add_action( 'update_option_active_plugins', 'deactivate_dependent_plugins' );
		}
	}
}

if ( ! function_exists( 'deactivate_dependent_plugins' ) ) {
	/**
	 * Deactivate deendent pluigns.
	 *
	 * @return void
	 */
	function deactivate_dependent_plugins() {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		$dependent = 'cardealer-front-submission/cardealer-frontend-submission.php';
		deactivate_plugins( $dependent );
	}
}

// Display admin notice if Visual Composer is not activated.
add_action( 'admin_notices', 'cdhl_plugin_active_notices' );

if ( ! function_exists( 'cdhl_plugin_active_notices' ) ) {
	/**
	 * Display admin notice if required plugins are not active.
	 *
	 * @return void
	 */
	function cdhl_plugin_active_notices() {

		$page_builder = cardealer_get_default_page_builder();

		$plugins_requried = array(
			'advanced-custom-fields-pro/acf.php' => esc_html__( 'Advanced Custom Fields PRO', 'cardealer-helper' ),
		);

		if ( 'wpbakery' === $page_builder ) {
			$plugins_requried['js_composer/js_composer.php'] = esc_html__( 'WPBakery Visual Composer', 'cardealer-helper' );
		} elseif ( 'elementor' === $page_builder ) {
			$plugins_requried['elementor/elementor.php'] = esc_html__( 'Elementor Website Builder', 'cardealer-helper' );
		}

		$plugins_inactive = array();

		// Check required plugin active status.
		foreach ( $plugins_requried as $plugin_requried => $plugin_requried_name ) {

			if ( ! cdhl_plugin_active_status( $plugin_requried ) ) {
				$plugins_inactive[] = $plugin_requried_name;
			}
		}

		if ( ! empty( $plugins_inactive ) && is_array( $plugins_inactive ) ) {

			$plugins_inactive_str = implode( ', ', $plugins_inactive );
			?>
			<div class="notice notice-error">
				<p><?php esc_html_e( 'Below required plugin(s) are not installed or activated. Please install/activate to enable feature/functionality.', 'cardealer-helper' ); ?></p>
				<p><strong><?php echo esc_html( $plugins_inactive_str ); ?></strong></p>
			</div>
			<?php
		}
	}
}

require_once trailingslashit( CDHL_PATH ) . 'includes/helper_functions.php';                             // Helper Functions.
require_once trailingslashit( CDHL_PATH ) . 'includes/cars_filter_functions.php';                        // Cars Filter Functions.
require_once trailingslashit( CDHL_PATH ) . 'includes/cpt.php';                                          // CPTs.
require_once trailingslashit( CDHL_PATH ) . 'includes/cpts/functions/cpt-functions.php';                 // CPTs Functions.
require_once trailingslashit( CDHL_PATH ) . 'includes/acf/acf-init.php';                                 // ACF.
require_once trailingslashit( CDHL_PATH ) . 'includes/sample_data/sample_data.php';                      // Sample Data.
require_once trailingslashit( CDHL_PATH ) . 'includes/widgets.php';                                      // Widgets.
require_once trailingslashit( CDHL_PATH ) . 'includes/mailchimp.php';                                    // mailchimp.
require_once trailingslashit( CDHL_PATH ) . 'includes/elementor/elementor.php';                                    // mailchimp.

/* Only car details pages */
require_once trailingslashit( CDHL_PATH ) . 'includes/dealer_forms/common/cardealer-mail-functions.php';
require_once trailingslashit( CDHL_PATH ) . 'includes/dealer_forms/inquiry.php';                         // inquiry post type [ CarDetail Page ].
require_once trailingslashit( CDHL_PATH ) . 'includes/dealer_forms/schedule-test-drive.php';             // Schedule Test Drive Form [ CarDetail Page ].
require_once trailingslashit( CDHL_PATH ) . 'includes/dealer_forms/email-to-friend.php';                 // Email to Friend Form [ CarDetail Page ].
require_once trailingslashit( CDHL_PATH ) . 'includes/dealer_forms/financial-form.php';                  // Financial Form  [ CarDetail Page ].
require_once trailingslashit( CDHL_PATH ) . 'includes/dealer_forms/make-an-offer.php';                   // Make An Offer Form  [ CarDetail Page ].

require_once trailingslashit( CDHL_PATH ) . 'includes/coming_soon.php';                                  // Notify Mail Form  [ Comming Soon Page ].
require_once trailingslashit( CDHL_PATH ) . 'includes/compare/compare.php';                              // Car Compare functions.
require_once trailingslashit( CDHL_PATH ) . 'includes/compare/compare-ajax.php';                         // Car Compare ajax call.
require_once trailingslashit( CDHL_PATH ) . 'includes/scripts_and_styles.php';                           // CSS & Javascript.
require_once trailingslashit( CDHL_PATH ) . 'includes/version_update/version.php';                       // Version Update.
require_once trailingslashit( CDHL_PATH ) . 'includes/third-party/third-party-support.php';              // Third party plugin support.
require_once trailingslashit( CDHL_PATH ) . 'includes/option_page/functions/option-page-functions.php';      // Car Dealer Option Pages functions.

add_action( 'init', 'cdhl_include_admin_files', 9 );

if ( ! function_exists( 'cdhl_include_admin_files' ) ) {
	/**
	 * Include admin files.
	 *
	 * @return void
	 */
	function cdhl_include_admin_files() {

		global $pagenow;

		if ( is_admin() ) {
			require_once trailingslashit( CDHL_PATH ) . 'includes/option_page/cardealer-core-additional-attributes.php'; // Car Dealer Core/Additional Attributes Option Pages.
			require_once trailingslashit( CDHL_PATH ) . 'includes/admin-guides/admin-guides-init.php';                   // Admin Guides.
		}

		require_once trailingslashit( CDHL_PATH ) . 'includes/redux/redux-init.php';   // Redux.
	}
}

add_action( 'init', 'cdhl_inc_files', 9 );

if ( ! function_exists( 'cdhl_inc_files' ) ) {
	/**
	 * Include files.
	 *
	 * @return void
	 */
	function cdhl_inc_files() {
		require_once trailingslashit( CDHL_PATH ) . 'includes/vc/vc.php';  // Visual Composer.
		require_once trailingslashit( CDHL_PATH ) . 'includes/shortcode.php'; // Shortcodes.
		require_once trailingslashit( CDHL_PATH ) . 'includes/custom_shortcodes.php'; // Shortcodes.
	}
}

if ( ! function_exists( 'cdhl_do_featured' ) ) {
	/**
	 * Update post meta.
	 *
	 * @return void
	 */
	function cdhl_do_featured() {

		$post_id = ( isset( $_GET['post_id'] ) && ! empty( $_GET['post_id'] ) ) ? absint( wp_unslash( $_GET['post_id'] ) ) : '';

		if ( $post_id && current_user_can( 'edit_post', $post_id ) && check_admin_referer( 'cdhl-feature-car' ) && isset( $_GET['featured'] ) && in_array( $_GET['featured'], array( 'yes', 'no' ), true ) ) {

			$featured = ( isset( $_GET['featured'] ) && ! empty( $_GET['featured'] ) ) ? sanitize_text_field( wp_unslash( $_GET['featured'] ) ) : '';

			if ( $featured && 'yes' === $featured ) {
				update_post_meta( $post_id, 'featured', 0 );
			} else {
				update_post_meta( $post_id, 'featured', 1 );
			}
		}

		wp_safe_redirect( wp_get_referer() ? remove_query_arg( array( 'trashed', 'untrashed', 'deleted', 'ids' ), wp_get_referer() ) : admin_url( 'edit.php?post_type=cars' ) );
		exit;

	}
}
add_action( 'wp_ajax_cdhl_do_featured', 'cdhl_do_featured' );
add_action( 'wp_ajax_nopriv_cdhl_do_featured', 'cdhl_do_featured' );

if ( ! function_exists( 'cdhl_mime_type' ) ) {
	/**
	 * Allow Json key file to upload.
	 *
	 * @param array $mime_types mime types.
	 */
	function cdhl_mime_type( $mime_types ) {
		$mime_types['json'] = 'application/json'; // Adding svg extension.
		return $mime_types;
	}
}
add_filter( 'upload_mimes', 'cdhl_mime_type', 1, 1 );
