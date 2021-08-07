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
define( 'DB_NAME', 'Wiofy' );

/** MySQL database username */
define( 'DB_USER', 'ysam020' );

/** MySQL database password */
define( 'DB_PASSWORD', 'ysam#24369' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         'w?i|iOCI14Ls//!YQTfgGiBy[FZwY,j0fws578h_lQt[b5y}pChW^^y]Ma5+dyXS' );
define( 'SECURE_AUTH_KEY',  'EaVOLvB-6as6#(IDo1B~M)e ={NdF*Nt&3 BfJ*PQXK$FBE6rRo}{LdH&@sFpt^7' );
define( 'LOGGED_IN_KEY',    'U0+Pb=m:vm(@[d[o^B#0rn3-F([CS/M:&%X2)?>dNr?Pv[z%NQz2up%>B2WPUbX}' );
define( 'NONCE_KEY',        '3JN%GS;6x=yY}Z4FkUhCBvzBuMe+Fwp]48*4$)fULAg0*Uk&G8=1)}JH=D3c-5PQ' );
define( 'AUTH_SALT',        '&*M55sx??5cMJD|H~T(~(tGz(~8tLyk7{ufxlU_a`@]t^mm}O9j>a,a+L%]=r;eV' );
define( 'SECURE_AUTH_SALT', '-%%Bc|%.RB4x*I,;H6|]2z-?@PhF3Om/7w4M1Bbp`.lO]P<OkMu!,[-h,SU_As`0' );
define( 'LOGGED_IN_SALT',   '4d/nA_mBysw[g1pxCvOEkfS_@hZSD-yDokJyCvI|Gk_^ M_8P.ra5:Yvh=/oAFS[' );
define( 'NONCE_SALT',       'm&D[o?U;.GqY2#q:/@,ar2[.5T.MKk~:Q@ieQ9#7)!C}|#rb.q!bTo,Z*;;c6-ZR' );

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

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
