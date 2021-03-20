<?php

namespace DeepWebSolutions\Framework\Foundations\Utilities\Services;

use DeepWebSolutions\Framework\Foundations\Logging\LoggingService;
use DeepWebSolutions\Framework\Foundations\Logging\LoggingServiceAwareTrait;
use DeepWebSolutions\Framework\Foundations\Plugin\PluginAwareTrait;
use DeepWebSolutions\Framework\Foundations\Plugin\PluginInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Template for encapsulating some of the most often required abilities of a service.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Utilities\Services
 */
abstract class AbstractService implements ServiceInterface {
	// region TRAITS

	use LoggingServiceAwareTrait;
	use PluginAwareTrait;

	// endregion

	// region MAGIC METHODS

	/**
	 * AbstractService constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   PluginInterface     $plugin             Instance of the plugin.
	 * @param   LoggingService      $logging_service    Instance of the logging service.
	 */
	public function __construct( PluginInterface $plugin, LoggingService $logging_service ) {
		$this->set_plugin( $plugin );
		$this->set_logging_service( $logging_service );
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
