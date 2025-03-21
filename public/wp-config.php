<?php
define( 'SBI_ENCRYPTION_KEY', '4EhNMXSoZg1OaxFEG0QpcAawT%grX22p!LpA8IV$tp@D%*ehXL7C7wr8bbyN^q' );

define( 'SBI_ENCRYPTION_SALT', 'BCwDx8Lop@u9x^r#XDzQ(&YX2P6TsJ@^GT2J7xh^D15qR1MNW2^y@7o8wzns$aFo' );

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          ']?~MOk|7+7Rhk[L#wu^nwm`q),D#zO9!)vDb!^OgNds3-lvEOdS$MoKjmpJ9yBJ7' );
define( 'SECURE_AUTH_KEY',   '%h}vyK yDj52o$&IQ2rrZE1+ZJVjd5yLnc|N&vqjJV9hW]v{4wnr^P4k9d5QEF6q' );
define( 'LOGGED_IN_KEY',     'e)m]nG9=WI.K!+G!?$D?b7!_SbcoE6smu 23u$A}oGhgmcv_tq.u%dNLViy[=E&6' );
define( 'NONCE_KEY',         'fq{?%4%.~@Hqpa)* bNF`/w~-cjklR5ga Itn*?De;M9Bf5[9?<GI*)BG@<U-KQ2' );
define( 'AUTH_SALT',         '1TP:6K%dwD@I04Q4S4$ZjH1n3uOR,_)G(I^l1d4O=@uM<w4c<>&1k)]9Dhi[uTLf' );
define( 'SECURE_AUTH_SALT',  'K/f1Qn4Q[l`7FR9@40%8`c:y/cQpn5;tA!ml<Y/Cwur)J==J/vVLejCHsguyL0Qz' );
define( 'LOGGED_IN_SALT',    '. SJ*24>)g7dHVk34uUR44EwC_x_651Msl}F%,*bnl:59WJNf9v~RjogI;h+|8gt' );
define( 'NONCE_SALT',        '~=o2;}^6e!{,D>(Y$!n^R]BHG)*E5h?RPCl`=9jlO8Yzx,B(nRd=R[ u?1vQ|mB~' );
define( 'WP_CACHE_KEY_SALT', '}wq|HEQ@jS(}Q$v9${T800*QKt%4uSRabVqb[aiND%(k$Yy6Y3-U~aU+|;>uw*UM' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}



define( 'WP_ALLOW_MULTISITE', true );
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', false );
$base = '/';
define( 'DOMAIN_CURRENT_SITE', 'akomo.local' );
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
