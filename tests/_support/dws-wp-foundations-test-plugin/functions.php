<?php

use DeepWebSolutions\Framework\Tests\Foundations\Plugin;

\defined( 'ABSPATH' ) || exit;

/**
 * Singleton instance function for the plugin.
 *
 * @return  Plugin
 */
function dws_foundations_test_plugin(): Plugin {
	static $instance = null;

	if ( \is_null( $instance ) ) {
		$instance = new Plugin();
	}

	return $instance;
}
