<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', "m_auto_wp" );

/** MySQL database username */
define( 'DB_USER', "m-auto" );

/** MySQL database password */
define( 'DB_PASSWORD', "NtiTU28Xfo0bc2KFpuoy" );

/** MySQL hostname */
define( 'DB_HOST', "localhost" );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+

 * Authentication unique keys and salts.

 *

 * Change these to different unique phrases! You can generate these using

 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.

 *

 * You can change these at any point in time to invalidate all existing cookies.

 * This will force all users to have to log in again.

 *

 * @since 2.6.0

 */

define( 'AUTH_KEY',         '{wZhK%_`r7,E`hT:0n6aInYGXW u`_Ch`ECNzQ|r-Q8vco3.uWYBdvh<drk[v}$&' );

define( 'SECURE_AUTH_KEY',  ',(*lwD<CH#UsGN9uqeG8p;,x]DvsfCx`garg!3a*(fQ[09a`/<x_Af$@|Rx@7pgW' );

define( 'LOGGED_IN_KEY',    'vR;Zmc2}b}.!JeU*zUt~y6dV@E6r>]ewUeK*=q@vUWR8dWs7#_|32RZuT#K9USS7' );

define( 'NONCE_KEY',        ']fOiY+7tDC=V}vQTV6!Ct1QYXnY]JKSzif%kCMA!)Ct}D=~`W{|dREE~-L7SOUIu' );

define( 'AUTH_SALT',        '=?&-h2,#vRX&F0RDdeud!ob/j0DlM.|5O 72nyu-``-+N)o}m~cOWl7m1!j/.nyz' );

define( 'SECURE_AUTH_SALT', '$|F-zi/<KMSI2G4b*3l9 a8~bfY6rn8b(h-(usfp@LlNQp%j 1tVK@n8DN<Q&C#6' );

define( 'LOGGED_IN_SALT',   'dR>kwhX }Xv0t Y3]vwXmk1s=F>Q%Z|&pdWhXwTAaz/+Dwk]haT{M/|Od{;_ 9#~' );

define( 'NONCE_SALT',       '][laet;4iNde~Qg`5/iLKc{/l5N&`vX7wGj]5||@fr(JX)?)#|N]?t.zxNFTw9PE' );


/**#@-*/


/**

 * WordPress database table prefix.

 *

 * You can have multiple installations in one database if you give each

 * a unique prefix. Only numbers, letters, and underscores please!

 */

$table_prefix = 'wp_';


/**

 * For developers: WordPress debugging mode.

 *

 * Change this to true to enable the display of notices during development.

 * It is strongly recommended that plugin and theme developers use WP_DEBUG

 * in their development environments.

 *

 * For information on other constants that can be used for debugging,

 * visit the documentation.

 *

 * @link https://wordpress.org/support/article/debugging-in-wordpress/

 */

define( 'WP_DEBUG', false );
define( 'WP_MEMORY_LIMIT', '256M' );

/* Add any custom values between this line and the "stop editing" line. */




define( 'DUPLICATOR_AUTH_KEY', 'JLy+aG||Q4ALvAw#me@/kuV>i~-)!_Sy?GAdCzE&. I^B,t:;Il^I,kb+FM)<[Y7' );
define( 'WP_PLUGIN_DIR', '/home/m-auto/public_html/wp-content/plugins' );
define( 'WPMU_PLUGIN_DIR', '/home/m-auto/public_html/wp-content/mu-plugins' );
/* That's all, stop editing! Happy publishing. */


/** Absolute path to the WordPress directory. */

if ( ! defined( 'ABSPATH' ) ) {

	define( 'ABSPATH', dirname(__FILE__) . '/' );

}


/** Sets up WordPress vars and included files. */

require_once ABSPATH . 'wp-settings.php';

