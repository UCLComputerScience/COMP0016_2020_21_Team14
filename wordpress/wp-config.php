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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress01' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         'zldlC<}!2/-LD/FzdsA!Pd6om=<xohHN:Z-v?ri#s:M@AWp4+/y5>rgN<f,^pjhP' );
define( 'SECURE_AUTH_KEY',  '>W]-3C;~tYLi]D#X7Wkjh`Y*b8SWW$</O4<,`5BJ~J:hzFmm<Z<lmzv&UKJL_%<j' );
define( 'LOGGED_IN_KEY',    'b>!e^Qic3D<mC|btRR~Lc~S8<XLlpw>QDeOy0h+Ba5T9D1]h>%Q$f~%}O(0q[`[?' );
define( 'NONCE_KEY',        '!6I3cP847OThlnG`GX2$KXZEcCJ?k084T2>ti3Bh<k)nqg.FBeGzq{{:+{!~^|OJ' );
define( 'AUTH_SALT',        'Gc]wy_s!MJ.O#XOaMg+9;CyB)(|*VEAv8S [N>Cs_|T?E#&d^j;LOehaKPQ%!g[/' );
define( 'SECURE_AUTH_SALT', 'AG<CEfm4_)zB3/:Y zhETRLm3D*7RjscpCF6tYh%+?YEyqZ!.J+=n;JUgM=/fudz' );
define( 'LOGGED_IN_SALT',   '`Nx/afbHVK^,0HGcJzro-;}<O(CY%^A<7uU*<3%<{+XOR<>9y=C=Y8ykvD$<Y-]!' );
define( 'NONCE_SALT',       'CpTofoEOMX1 9eiWYc+Gr)O9{,f^)|([occss3/i=h+s/$6pd6?BtId++)CrcU(N' );

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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
