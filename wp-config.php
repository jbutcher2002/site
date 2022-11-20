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
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'site_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'p]]Eu6P73C^+a|W1lgFW2*>(^):/JrZn;,0_2FSYTGKMfy[Kvl_aI_`LW:{`NIkl' );
define( 'SECURE_AUTH_KEY',  'Fo$F;O[xpO8uv0k;<b6foqk14s?Nxg^Hiqs Rske>6]7o[jY+*Vx{2Cr8c]hDmXG' );
define( 'LOGGED_IN_KEY',    '03KE^`g0_m^^FHYib4 ycRE9-M7d*nSx_6*dmm^47*O{XNoZY3NjB8>^?>;ehq8|' );
define( 'NONCE_KEY',        '#B&cDE#?rWx94M])mfgDrCV|viJ<E_xqa3@Yg?|63!% X0C`Xi|W3hLLNknn*n3o' );
define( 'AUTH_SALT',        'sF?m_1 [I(UI}|V`uYR#aca*]z]iJSTpA~<HMYeAPjam!WvZmv!`eA,)c@r8<0jU' );
define( 'SECURE_AUTH_SALT', 'jZ^rrss}qJBEsjU8g9 50U|q4f`43FMYu%_tI8Sfr6uIirWRAdPx#IXR}e#Z+@*a' );
define( 'LOGGED_IN_SALT',   '$LM@dpKHZ:YlXf6U70C2%ui=GCDA5-F`z/kcX|F}OcV<7vP]8WOa#dYL1nh0|->?' );
define( 'NONCE_SALT',       'B+8cTW6 q3<dJ_9$7Ra&:+t<l@A{UU*~bxl$@epyqpL$R0`?KJ}CTPD ny) &1O*' );

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
