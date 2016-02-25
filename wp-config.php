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
define('DB_NAME', 'test');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'rootroot');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         'K -2m4-nWF*u3F 0V!q>1$e?xv-mf(Yg[s+J~s{Z*Z?wY|d7[|/sy5|ub^-y{1|W');
define('SECURE_AUTH_KEY',  'BvG+*32}A`.)%,)$]Bz|Rx$>Y+A QIFtuq4_&}/LrJiav`F=+/*h@n8rT|tMy-G@');
define('LOGGED_IN_KEY',    '<^Kd|bhOV9_q=e@|:9:L7@Mk0UkATV&n+syH@?[5W4k[_~n2-Qyu3]DO,{e_Vf&E');
define('NONCE_KEY',        '8wM--ieMI|I |~,?]hXqT^+ a|QLmMx(4T+xgDO1`OI>yI!y7K:A9tI3dS5A1)3j');
define('AUTH_SALT',        '+=rj?g8TW(ZPlO5Slb.kcD}]Nb7=l |+9t74gv/`@aHu3-@ aWwZgcieva%P]S+)');
define('SECURE_AUTH_SALT', 'gcI4r7f&YMKx0/3i(0TWOED_xPQ0NR<Hv2@<&dw.!9AG)c#>v]_^[$0;]GDc=M#,');
define('LOGGED_IN_SALT',   'H%hUyu$}nHd/3,o^wEFY5B7h3<1#`r|1X9z48)pJ%KPm{=J!6^7&LGi!8-zN|D`O');
define('NONCE_SALT',       '^IO4`n|#j<EKuv*9!o45G=82klD-G+Kk&! F7MhnRBO@}P+PG0l[>pSH=/yd;PX!');

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
