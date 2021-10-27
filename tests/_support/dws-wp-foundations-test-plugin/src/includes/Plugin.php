<?php

namespace DeepWebSolutions\Framework\Tests\Foundations;

use DeepWebSolutions\Framework\Foundations\Helpers\AssetsHelpersTrait;
use DeepWebSolutions\Framework\Foundations\Helpers\HooksHelpersTrait;
use DeepWebSolutions\Framework\Foundations\AbstractPlugin;
use DeepWebSolutions\Framework\Foundations\PluginTrait;
use function DeepWebSolutions\Plugins\dws_foundations_test_base_path;

\defined( 'ABSPATH' ) || exit;

/**
 * Class Plugin
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations
 */
class Plugin extends AbstractPlugin {
	// region TRAITS

	use PluginTrait;
	use AssetsHelpersTrait;
	use HooksHelpersTrait;

	// endregion

	// region METHODS

	/**
	 * Returns the filesystem path to the plugin entry file.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_plugin_file_path(): string {
		return dws_foundations_test_base_path() . 'bootstrap.php';
	}

	// endregion
}
