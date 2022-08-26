<?php
define('WP_AUTO_UPDATE_CORE', 'minor');// This setting is required to make sure that WordPress updates can be properly managed in WordPress Toolkit. Remove this line if this WordPress website is not managed by WordPress Toolkit anymore.
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
define( 'DB_NAME', 'gscacombo_wpcherry' );

/** Tu nombre de usuario de MySQL */
define( 'DB_USER', 'gscacombo_wpche' );

/** Tu contraseña de MySQL */
define( 'DB_PASSWORD', 'gwNZ%V6C[S8F' );

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define( 'DB_HOST', 'localhost' );

/** Codificación de caracteres para la base de datos. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');
define( 'WP_MEMORY_LIMIT', '256M' );
/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY', 'wPvfJ:JUBls]h&HHt:A%f%@_ZAfV+3K,sRQa<IyhrKH7.XE1CJ(r7EO|)D%C>W<O' );
define( 'SECURE_AUTH_KEY', '{Y6>|!A6x&T>w- u-=<.zUfy}Inf$([]$WaUtm;k(YP Vb9lIL]^H%Y<4lD/}l)3' );
define( 'LOGGED_IN_KEY', 'P.fThy#h._SxJVN1`r]l4WZ,S,!Gpx<vZ@2UA.0d#IQ@6%MSLacT,IZl%EbVJ`<N' );
define( 'NONCE_KEY', 'D2xxB5BZVt3V]BB_-Srr*my>F<EDh1*F_w^jP$Z3lm,%EMpc%ru_uy|U*=Khms4.' );
define( 'AUTH_SALT', 'LG?+>OW;URd+w{2Rr#x3z-g^s5jy{}%SeXT5HK8I8ao2eYL kwBW[=e/4-TP{6Q2' );
define( 'SECURE_AUTH_SALT', 'wO8`ATWV>-fJ(CJDQwk#ojA4|8p_3#E[tAf_6nL8*2H^v=4^mj@IV~MYVPG9kC0{' );
define( 'LOGGED_IN_SALT', 'b,A!ScWjTLh$uD*+cdzM<VEu.`[Tk9(L*N>&oQx!+^U$5,,{1Yh-C$kF2>>R(r(1' );
define( 'NONCE_SALT', 'u(JL]$ $~_h375IPQ{>ivBeE+nlg;*sdGYVjPA+GluswOw1V@uJ#T)V%N@6tm!<|' );

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix = 'grt_';


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

