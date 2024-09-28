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
define( 'AUTH_KEY',         '`I6yRZ:fFJpyvA5%i:wo7q^:GR.^1U=>v_&&p{{]K/r+Dcs%J:c&TyGEaL.I7bT(' );
define( 'SECURE_AUTH_KEY',  '[}>J7C,>Qq-M~y_7MwPk5CiDh9b,8@f+Jn=&z7pmQV7z;EpnX`c6n^;LO]@/J~y:' );
define( 'LOGGED_IN_KEY',    'q8oDX/}Ls#D,0W6w=)#:hMcdM.b8_=#;&yD4{_=./oMjOf.wcj:L&7?b%M$9(+wq' );
define( 'NONCE_KEY',        'Lz!V!! Ad8sxWSi1rBt|1A&H5^Id: g2+8+N;Ez9 K,|tc]^u:.)*P2G U1o}bNs' );
define( 'AUTH_SALT',        '60i!V`el;4@bGnt&^cws*up9bP5PRB?2qnNz^:&/]mG~~ooCKu2e47id6cEC)=JR' );
define( 'SECURE_AUTH_SALT', 'mcISjp<;n9q}e+wuC@,T>tO=n1g5V:IC!~t6^;OsK{Pcfl,KfZJ_rj~ 4@RQ.Mli' );
define( 'LOGGED_IN_SALT',   'B`P<SIWfA0k3nXa>^rw$oWaq-J*v=iA~$n]5Y9iz3k)C(?TRj:Om79{5{]#(v;CQ' );
define( 'NONCE_SALT',       'VXN=v-J s>7j4K)5ZI*UK^v!^zo,yPE%o?,dm^hj+^5CIS-|nA+0315:O|E%o^=m' );

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
