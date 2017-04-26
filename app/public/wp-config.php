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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'vvNfmLpYuoqW5zkXzMw4WigSZNkmKYPRQPAuFpnWBnozTYAu2UsEXR9GsN6iEzo+2nMkoZI8ulXQ8IrtugPknQ==');
define('SECURE_AUTH_KEY',  '+07PaC6aE1xlWDkJ0ON9XJkZoLdZ/rjK020T9S44fUodLQVgKxhUZ8W1pMdYSnKkUGPk5Mt2J4hwVLgxvcfNAQ==');
define('LOGGED_IN_KEY',    'hKlemogS0BqdLxLfpwC54ETB0g5v9TNh+pJ7GXKIzkUDTj17PF7QqGpmO2OQFujHNc6rcinC7/MsmUQY29meaA==');
define('NONCE_KEY',        'SXySeoyhotEPC7mUS+j3PV7dn6+8YqTTOiGkwljJbmbDyhlPbVw76sUZuBRtzGaI9lROJOWD+M8/ZZ3cLPyJrw==');
define('AUTH_SALT',        'u6XPrBe1on+qGU+Tz3++bJrCIqpYuThB6fi+QdKkD0TqGHyz9wxZigNZ132aoNiDLu/+yXDt6D1EJ4lFK3uAZw==');
define('SECURE_AUTH_SALT', 's6CKsgt85kXjEB5FOfldbYWP+A4azSPzG4Nvix8tId+SRDurIEtdjNixBZcMUULGpIiDOCuRavZLPot0l/wM2g==');
define('LOGGED_IN_SALT',   'WVSaKOUPvCOO6vTw09PzWDKpIj5iTcgIfuHiX19JhxeJrmoRPd9Eikst9mPN5tr+qgvc7HaCLqeRyZma83QU+g==');
define('NONCE_SALT',       '8PYeIVyPvoc7tUTE0wPijBuI327UlBkFhNbtR88etUXDycDhIi1QzkXK3rqsEea18JWsdkGnke4pG5N1xEPqqw==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';





/* Inserted by Local by Flywheel. See: http://codex.wordpress.org/Administration_Over_SSL#Using_a_Reverse_Proxy */
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
	$_SERVER['HTTPS'] = 'on';
}
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
