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
define('DB_NAME', 'mustard');

/** MySQL database username */
define('DB_USER', 'webrds');

/** MySQL database password */
define('DB_PASSWORD', 'JGv3iwY8ssTrKsna2oC7');

/** MySQL hostname */
define('DB_HOST', 'websitesrds-cluster.cluster-cgvhvb5gxn1g.eu-west-1.rds.amazonaws.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'ZO:= xr|PD:!2TN^1o7G3A[^3drq4Vc%VCem1*8_VNyRz&Dt|}$y2[fM|Un)ci+=');
define('SECURE_AUTH_KEY',  ' %IK{#$5zdD.B0~Pl57?VXz?~o^Ag?3?eer#w)$8>=ZT>~M$#!R0LR%wT9cU&[s;');
define('LOGGED_IN_KEY',    'jNq%jKj^Qa!*qv!qzDS!&1|J$2SI^)u{X kN%m{HY|9=q>X<?>P/O~dnw!zu6e}h');
define('NONCE_KEY',        'b]o:`f-yg}HmS4TD~Eb%*[Vk9-LqNHV4%C+Z:zElw!|S|I{awt;$c,Bsk&Qbdp{C');
define('AUTH_SALT',        'w>$Fn+&dJ4f5B6w<HqPpL$TfRgnJFLfO?CXc-Ww:UR#0$mBK;~q}]<Egtz.9x`O(');
define('SECURE_AUTH_SALT', '_QG<0ujtA!NF}x`Lt2Hs*veVwN&K1{tP=s_Tt+? K2@A*~C|RO/Wh#7+XBhzsfE>');
define('LOGGED_IN_SALT',   'J/$OM)+e>qL`!ua o?K3Y,.B-bL&i5u<NZJ vdS;-H_~-lh.D.Ex:dllqFRTo+]v');
define('NONCE_SALT',       'q[j]G=L @m14kr6Z@$QesEeY,&.$[nVjkK0HY[|ukTH346k4-<5n#p_mw9|Mk.(`');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
