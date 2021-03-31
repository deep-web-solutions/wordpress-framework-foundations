<?php

use DeepWebSolutions\Framework\Foundations\Actions\Initializable\InitializationFailureException;
use DeepWebSolutions\Framework\Tests\Foundations\Plugin;

\defined( 'ABSPATH' ) || exit;

/**
 * Singleton instance function for the plugin.
 *
 * @return  Plugin
 */
function dws_foundations_test_plugin_instance(): Plugin {
	static $instance = null;

	if ( \is_null( $instance ) ) {
		$instance = new Plugin();
	}

	return $instance;
}

/**
 * Initialization function shortcut.
 *
 * @since   1.0.0
 * @version 1.0.0
 *
 * @return  InitializationFailureException|null
 */
function dws_foundations_test_plugin_instance_initialize(): ?InitializationFailureException {
	return dws_foundations_test_plugin_instance()->initialize();
}
