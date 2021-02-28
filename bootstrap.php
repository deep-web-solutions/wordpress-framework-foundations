<?php
/**
 * The DWS WordPress Framework Foundations bootstrap file.
 *
 * @since               1.0.0
 * @version             1.0.0
 * @package             DeepWebSolutions\WP-Foundations
 * @author              Deep Web Solutions GmbH
 * @copyright           2021 Deep Web Solutions GmbH
 * @license             GPL-3.0-or-later
 *
 * @noinspection PhpMissingReturnTypeInspection
 *
 * @wordpress-plugin
 * Plugin Name:         DWS WordPress Framework Foundations
 * Description:         A set of related foundational classes to kick-start WordPress plugin development.
 * Version:             1.0.0
 * Requires at least:   5.5
 * Requires PHP:        7.4
 * Author:              Deep Web Solutions GmbH
 * Author URI:          https://www.deep-web-solutions.com
 * License:             GPL-3.0+
 * License URI:         http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:         dws-wp-framework-foundations
 * Domain Path:         /src/languages
 */

namespace DeepWebSolutions\Framework;

if ( ! defined( 'ABSPATH' ) ) {
	return; // Since this file is autoloaded by Composer, 'exit' breaks all external dev tools.
}

// Start by autoloading dependencies and defining a few functions for running the bootstrapper.
// The conditional check makes the whole thing compatible with Composer-based WP management.
file_exists( __DIR__ . '/vendor/autoload.php' ) && require_once __DIR__ . '/vendor/autoload.php';

// Define foundations constants.
define( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_FOUNDATIONS_NAME', dws_wp_framework_get_whitelabel_name() . ': Framework Foundations' );
define( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_FOUNDATIONS_VERSION', '1.0.0' );

/**
 * Returns the whitelabel name of the framework's foundations within the context of the current plugin.
 *
 * @since   1.0.0
 * @version 1.0.0
 *
 * @return  string
 */
function dws_wp_framework_get_foundations_name() {
	return constant( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_FOUNDATIONS_NAME' );
}

/**
 * Returns the version of the framework's foundations within the context of the current plugin.
 *
 * @since   1.0.0
 * @version 1.0.0
 *
 * @return  string
 */
function dws_wp_framework_get_foundations_version() {
	return constant( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_FOUNDATIONS_VERSION' );
}

// Define minimum environment requirements.
define( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_FOUNDATIONS_MIN_PHP', '7.4' );
define( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_FOUNDATIONS_MIN_WP', '5.5' );

/**
 * Returns the minimum PHP version required to run the Bootstrapper of the framework's foundations within the context of the current plugin.
 *
 * @since   1.0.0
 * @version 1.0.0
 *
 * @return  string
 */
function dws_wp_framework_get_foundations_min_php() {
	return constant( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_FOUNDATIONS_MIN_PHP' );
}

/**
 * Returns the minimum WP version required to run the Bootstrapper of the framework's foundations within the context of the current plugin.
 *
 * @since   1.0.0
 * @version 1.0.0
 *
 * @return  string
 */
function dws_wp_framework_get_foundations_min_wp(): string {
	return constant( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_FOUNDATIONS_MIN_WP' );
}

/**
 * Registers the language files for the foundations' text domain.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
\add_action(
	'init',
	function() {
		load_plugin_textdomain(
			'dws-wp-framework-foundations',
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/src/languages'
		);
	}
);

// Bootstrap the foundations (maybe)!
if ( dws_wp_framework_check_php_wp_requirements_met( dws_wp_framework_get_foundations_min_php(), dws_wp_framework_get_foundations_min_wp() ) ) {
	$dws_foundations_init_function = function() {
		define(
			__NAMESPACE__ . '\DWS_WP_FRAMEWORK_FOUNDATIONS_INIT',
			apply_filters(
				'dws_wp_framework_foundations_init_status',
				defined( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_BOOTSTRAPPER_INIT' ) && DWS_WP_FRAMEWORK_BOOTSTRAPPER_INIT &&
				defined( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_HELPERS_INIT' ) && DWS_WP_FRAMEWORK_HELPERS_INIT,
				__NAMESPACE__
			)
		);
	};

	if ( did_action( 'plugins_loaded' ) ) {
		call_user_func( $dws_foundations_init_function );
	} else {
		add_action( 'plugins_loaded', $dws_foundations_init_function, PHP_INT_MIN + 200 );
	}
} else {
	define( __NAMESPACE__ . '\DWS_WP_FRAMEWORK_FOUNDATIONS_INIT', false );
	dws_wp_framework_output_requirements_error( dws_wp_framework_get_foundations_name(), dws_wp_framework_get_foundations_version(), dws_wp_framework_get_foundations_min_php(), dws_wp_framework_get_foundations_min_wp() );
}
