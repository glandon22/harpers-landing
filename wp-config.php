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
define( 'DB_NAME', 'wp' );

/** MySQL database username */
define( 'DB_USER', 'george' );

/** MySQL database password */
define( 'DB_PASSWORD', 'taylord22' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '#$S/HTw=xu_L+ie!W,)MZ&)fc1j8o%R+infvEd>CrWzd1V_7vD^Pck&/[eRrpuZ6' );
define( 'SECURE_AUTH_KEY',  '4($h@ww1:}#J%6pS#9sI[T%wRG05XmTT:AbN`9~rj)8U6<|#osd]BfzEi]>B962y' );
define( 'LOGGED_IN_KEY',    '/*/>;I*$PjRi=.<UlQ3.^d/@JHVX}D`Y+w6)R~=xBqB1j`DTus34avPh]s)6p~H=' );
define( 'NONCE_KEY',        '}egg,(cRms*2M]+53CM>iaQ[WD3MhbM`d?dg^(xm!6}B8Q0m#HV`NG,kDM>8c?Pv' );
define( 'AUTH_SALT',        '8Qg%Y!!,+na(y1Ys<GB(^)o9OcW$Ud1+I30d,i<{1j.tBo{=sBz_L-7!h`EcV?rG' );
define( 'SECURE_AUTH_SALT', 'f5#8t%LF`LKC-;d&|L.%D})(6D,ksD)5gZEC-1$0y38(Ju/2]vX^Bgyvf$eoA2~C' );
define( 'LOGGED_IN_SALT',   'BEcv86RKgr{<w=6ci*t^ ephhR;LjUP2_Yct#keXAektWXs2/m3Hz9O9[S;I!&!w' );
define( 'NONCE_SALT',       'wvJA:;E<y+%:/lJn(E?2**@l|)Q.oV:&kB]86)cQ]SqR<H(w#CR`%*]SMkey|`/.' );

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
