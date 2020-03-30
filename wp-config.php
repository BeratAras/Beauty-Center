<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'estetika2z' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '~.kZm0$_@a@n0Qt}4AFVrlHzmX?0YW1ACMpXP?zj#L|u$/(5UGv.3_!~R**SPp~c' );
define( 'SECURE_AUTH_KEY',  '{ !TaS43oDNC^e 1!y^l~&Y/J}x{PZl>:dMnkMCj^mSl/JUUkqELmm:;&R(UH#wv' );
define( 'LOGGED_IN_KEY',    ')ZP:CD1aP{},](+uJyjxI:ql#/neO{AU)xQs6_q*k]=u<..bILG~6 pDF6K1nX>S' );
define( 'NONCE_KEY',        '+&s>!_k:D[E?kakeqz$Ou=JSg%^pMR`_(4j_q8!W+F2ij1UTv]#p8nP$~MKlUZ-M' );
define( 'AUTH_SALT',        'tFtLiD~Bq5b98|XlR4h_,ZqIp4Iq{vT?XE8`H=bUM%oXtwF$-NBInafj2,,~Fx`a' );
define( 'SECURE_AUTH_SALT', 'm{myTW0nb5_ndBXRkP p$TmRVj*:l6Ql}[0a=</TAgSkLB+Ptf%V<Q8p 3zB|G:e' );
define( 'LOGGED_IN_SALT',   'Eg5`v`2/o{z.[vGKB3 *Kk;ZT^U<g_~HU.cH<J=y*O4WiX~+``T]h#*y{C<tpMVR' );
define( 'NONCE_SALT',       'I4mLYP+mnJLtGlza U>V[@$YA;Y&RPg)ZUYI:dD4C_a?MDG1]/7^s OEts=piQ+x' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
