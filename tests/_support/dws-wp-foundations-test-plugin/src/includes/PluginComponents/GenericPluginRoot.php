<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\PluginComponents;

use DeepWebSolutions\Framework\Foundations\Hierarchy\Plugin\AbstractPluginRoot;

\defined( 'ABSPATH' ) || exit;

/**
 * Class GenericPluginRoot
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\PluginComponents
 */
class GenericPluginRoot extends AbstractPluginRoot {
	/**
	 * Defaults to the regular plugin instance's file path.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_plugin_file_path(): string {
		return dws_foundations_test_plugin_instance()->get_plugin_file_path();
	}
}
