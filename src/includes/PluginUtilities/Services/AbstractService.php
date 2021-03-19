<?php

namespace DeepWebSolutions\Framework\Foundations\PluginUtilities\Services;

use DeepWebSolutions\Framework\Foundations\Plugin\PluginAwareTrait;
use DeepWebSolutions\Framework\Foundations\Plugin\PluginInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Template for encapsulating some of the most often required abilities of a service.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\PluginUtilities\Services
 */
abstract class AbstractService implements ServiceInterface {
	// region TRAITS

	use PluginAwareTrait;

	// endregion

	// region MAGIC METHODS

	/**
	 * AbstractService constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   PluginInterface     $plugin     Instance of the plugin.
	 */
	public function __construct( PluginInterface $plugin ) {
		$this->set_plugin( $plugin );
	}

	// endregion

	// region INHERITED METHODS

	/**
	 * Returns the ID of the instance. Since services are supposed to be singletons,
	 * this is a safe default.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_id(): string {
		return static::class;
	}

	// endregion
}
