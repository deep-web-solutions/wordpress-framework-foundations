<?php

namespace DeepWebSolutions\Framework\Tests\Foundations;

use DeepWebSolutions\Framework\Foundations\Helpers\AssetsHelpersTrait;
use DeepWebSolutions\Framework\Foundations\Helpers\HooksHelpersTrait;
use DeepWebSolutions\Framework\Foundations\Plugin\PluginInterface;
use DeepWebSolutions\Framework\Foundations\Plugin\PluginTrait;
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
class Plugin implements PluginInterface {
	// region TRAITS

	use PluginTrait;
	use AssetsHelpersTrait;
	use HooksHelpersTrait;

	// endregion

	// region MAGIC METHODS

	/**
	 * Plugin constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function __construct() {
		$this->plugin_name            = 'DWS Foundations Test Plugin';
		$this->plugin_version         = '1.0.0';
		$this->plugin_author_name     = 'Deep Web Solutions';
		$this->plugin_author_uri      = 'https://www.deep-web-solutions.com';
		$this->plugin_description     = 'My Plugin Test Description';
		$this->plugin_language_domain = 'dws-wp-foundations-test-language-domain';
		$this->plugin_slug            = 'dws-wp-foundations-test-slug';
	}

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
