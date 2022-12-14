<?php // phpcs:ignore WordPress.Files.FileName.NotHyphenatedLowercase
/**
 * Import XML
 *
 * @package car-dealer-helper/functions
 */

if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
	define('WP_LOAD_IMPORTERS', true);
}

/** Display verbose errors */
if ( ! defined( 'CARDEALER_HELPER_IMPORT_DEBUG' ) ) {
	define( 'CARDEALER_HELPER_IMPORT_DEBUG', false );
}

/** WordPress Import Administration API */
require_once ABSPATH . 'wp-admin/includes/import.php';

if ( ! class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	if ( file_exists( $class_wp_importer ) )
		require $class_wp_importer;
}

/** Functions missing in older WordPress versions. */
require_once trailingslashit( CDHL_PATH ) . 'includes/importer/compat.php';

/** WXR_Parser class */
require_once trailingslashit( CDHL_PATH ) . 'includes/importer/parsers/class-cdhl-wxr-parser.php';

/** WXR_Parser_SimpleXML class */
require_once trailingslashit( CDHL_PATH ) . 'includes/importer/parsers/class-cdhl-wxr-parser-simplexml.php';

/** WXR_Parser_XML class */
require_once trailingslashit( CDHL_PATH ) . 'includes/importer/parsers/class-cdhl-wxr-parser-xml.php';

/** WXR_Parser_Regex class */
require_once trailingslashit( CDHL_PATH ) . 'includes/importer/parsers/class-cdhl-wxr-parser-regex.php';

/** WP_Import class */
require_once trailingslashit( CDHL_PATH ) . 'includes/importer/class-cdhl-wp-import.php';

function cdhl_helper_wordpress_importer_init() {
	/**
	 * WordPress Importer object for registering the import callback
	 * @global Cardealer_Helper_WP_Import $cardealer_helper_wp_import
	 */
	$GLOBALS['cardealer_helper_wp_import'] = new Cardealer_Helper_WP_Import();
}
add_action( 'admin_init', 'cdhl_helper_wordpress_importer_init' );

