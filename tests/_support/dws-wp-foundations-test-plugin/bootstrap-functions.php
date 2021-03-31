<?php
/**
 * Defines module-specific getters and functions.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Plugins\Utility
 *
 * @noinspection PhpMissingReturnTypeInspection
 */

namespace DeepWebSolutions\Plugins;

\defined( 'ABSPATH' ) || exit;

/**
 * Returns the base path of the plugin.
 *
 * @since   1.0.0
 * @version 1.0.0
 *
 * @return  string
 */
function dws_foundations_test_base_path() {
	return \constant( __NAMESPACE__ . '\DWS_FOUNDATIONS_TEST_PLUGIN_BASE_PATH' );
}
