<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */
 

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'admin' );

/** Database username */
define( 'DB_USER', 'admin' );

/** Database password */
define( 'DB_PASSWORD', '1' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'GgN|Eqz .}L{hd1lxX#|}E{EQdE=bye>qUI$hVNV/uq>!dy@eQNHC.6TuqP_9!Y&' );
define( 'SECURE_AUTH_KEY',  '-%T7}.>-R?tEBZn7H5-jw~=V1NE.65(pFVT{/51+i~wDuVfHF,R.Naevc88WKL9I' );
define( 'LOGGED_IN_KEY',    '4RFxG: I`=I5f z1XL=9?.2wXd:cil>%y*m^xKfGSeu$8|(Jy^u^X1er>R7b,[;{' );
define( 'NONCE_KEY',        '2isc6S8&g;K5V>]6Z_-]iuW]2.#5HtYGJ$p&k4fy$<4(-:N_ncp,vns&~7.MHhMQ' );
define( 'AUTH_SALT',        '%fsiCIAcs1sQYijM$Oc+pV+U%S9>E0X?I[[abxE~2Ucr$Qbe ,X6|3`+vhD@OW:i' );
define( 'SECURE_AUTH_SALT', 'ABodbR.#DPkfXgmakA?&zj%TfH-$FnXL*~wypxCXCob>:}xO}t{~&I*|h(MV&5R;' );
define( 'LOGGED_IN_SALT',   '/!l,J&#B^=hPhJ$q4cFHH?:3t}*!n>X:dy|-tQlrAVa3-B/?x+k|Hu_c}fi2!de%' );
define( 'NONCE_SALT',       '#& 3)gVJYCwpqvWWgwN!t]Uv|ajWSM2kE2@Rq+>-*v#X,[9E;B3mCcn1p2o=G/L3' );

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
