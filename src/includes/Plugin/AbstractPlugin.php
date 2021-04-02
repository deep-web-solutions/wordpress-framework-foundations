<?php

namespace DeepWebSolutions\Framework\Foundations\Plugin;

use DeepWebSolutions\Framework\Foundations\Actions\Initializable\InitializationFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Initializable\InitializeLocalTrait;
use DeepWebSolutions\Framework\Foundations\Actions\InitializableInterface;
use DeepWebSolutions\Framework\Foundations\Logging\LoggingServiceAwareInterface;
use DeepWebSolutions\Framework\Foundations\Logging\LoggingServiceAwareTrait;
use DeepWebSolutions\Framework\Helpers\FileSystem\Objects\PathsTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Template for encapsulating some of the most often required abilities of a plugin instance.
 *
 * @since   1.0.0
 * @version 1.1.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Plugin
 */
abstract class AbstractPlugin implements InitializableInterface, LoggingServiceAwareInterface, PluginInterface {
	// region TRAITS

	use InitializeLocalTrait;
	use LoggingServiceAwareTrait;
	use PathsTrait;
	use PluginTrait;

	// endregion

	// region INHERITED METHODS

	/**
	 * Uses the plugin file path to initialize the plugin data fields.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  InitializationFailureException|null
	 */
	public function initialize_local(): ?InitializationFailureException {
		$plugin_data                  = \get_file_data(
			$this->get_plugin_file_path(),
			array(
				'Name'        => 'Plugin Name',
				'Version'     => 'Version',
				'Description' => 'Description',
				'Author'      => 'Author',
				'AuthorURI'   => 'Author URI',
				'TextDomain'  => 'Text Domain',
			),
			'plugin'
		);
		$this->plugin_name            = $plugin_data['Name'];
		$this->plugin_version         = $plugin_data['Version'];
		$this->plugin_description     = $plugin_data['Description'];
		$this->plugin_author_name     = $plugin_data['Author'];
		$this->plugin_author_uri      = $plugin_data['AuthorURI'];
		$this->plugin_language_domain = $plugin_data['TextDomain'];
		$this->plugin_slug            = $plugin_data['TextDomain'];

		return null;
	}

	// endregion
}
