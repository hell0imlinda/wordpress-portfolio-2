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
define('DB_NAME', 'portfolio');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'xiuu?U$6}*|0OGb)8PC+8b+,5F1^#Z/Vo~CRCK)kVQ`PxOO^k<+fB 3&3^O{:Afg');
define('SECURE_AUTH_KEY',  '=~;]TWBFYv&;3$euIu(ZHO{x~i_#2_%^V$2!sb>8tUfm,umrv$[;*-)32z_0W,H{');
define('LOGGED_IN_KEY',    '2uo EcmPj24FQDSO x<36XtF&NhjUFnj0/U@zEAiWXuLOKI)ebL%,1R PeCvmfAy');
define('NONCE_KEY',        'oYOK0i0XQ?&S3LE#TAXCuA4R$sf.;O njcvbF*$iK_4+`.ajC1dX`9W!Onq--%-I');
define('AUTH_SALT',        '4326Ok8YET-2V#~[EERVdSu}FYC_Qc?H&*=:bmIE{j](b$Tnf&IU*NkQ@1~]w}-E');
define('SECURE_AUTH_SALT', ']i]d~L,jY(Jp#%A%>$bNV2wQu&X=N<fiITCKy1dbV;%5c))91Sks3cv`S?i7l2I/');
define('LOGGED_IN_SALT',   '{AID+,L2PL=eD{G~vHFH~m8?uCZpFSvxTQmcclB&_jq.N19lp6Ovk]3+~~a]?:1K');
define('NONCE_SALT',       'V 2M8l9#/K}SXXh(pdJ?,hZmwZ,lt78sb#Ia*u{`TZp`V=/cP*V-Nv{~[VA_<.@=');

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
