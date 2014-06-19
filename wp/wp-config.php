<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'media_ad_wp');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'root');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', 'root');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'Fg;oiY4bv4_;WvqHi/8fLUnmC(]5+eRE+g)RtZN5p&}8@T5|XimZ0CtKhn?4.D3?'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_KEY', 'Zl-+#VX,>5rjo,( $q )#W(g@xsfLAbFQu!%aM.~g-((`h$SdNmNO#a,:eOf)i.}'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_KEY', '|-%0tGDd-sb^ TtX)R(7D{J)w2r6-?8H=)t}C<O1KD6B$Aco6Q[|TI?(~do?Mn;/'); // Cambia esto por tu frase aleatoria.
define('NONCE_KEY', 'iW8<a~Mg44o&AzAeqQIe`7VJ+5f!r]}5VTsh9-I_>D<l}-6aSJL7u-uYj4|$}vC '); // Cambia esto por tu frase aleatoria.
define('AUTH_SALT', ',_Vd1?8WDE|QqgcU*UhAaEuDgyi4KF+Z(hMX{4m:hCq[BARbFyvf9:NeE|zJJ0lq'); // Cambia esto por tu frase aleatoria.
define('SECURE_AUTH_SALT', ':K(;:*@}dX}<^vFt}g^mT}I[zySr*e9t+ZJX3bgIKnCX5.||C79V~H*+,uDw^0ZZ'); // Cambia esto por tu frase aleatoria.
define('LOGGED_IN_SALT', ';%qi916zcJ?Ph0)^+ELwXXpd|&qQC*KR&Wp&`ibQh@aAf^D!x|6UQ0jKK^?^Vt#a'); // Cambia esto por tu frase aleatoria.
define('NONCE_SALT', '7Xj}$G7(-FsR]W|35#^Nfbt+]]Wp-3`|#Mk*r| U(zIS-E-zxS96<qGuB`1{cOSF'); // Cambia esto por tu frase aleatoria.

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';

/**
 * Idioma de WordPress.
 *
 * Cambia lo siguiente para tener WordPress en tu idioma. El correspondiente archivo MO
 * del lenguaje elegido debe encontrarse en wp-content/languages.
 * Por ejemplo, instala ca_ES.mo copiándolo a wp-content/languages y define WPLANG como 'ca_ES'
 * para traducir WordPress al catalán.
 */
define('WPLANG', 'es_ES');

/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

