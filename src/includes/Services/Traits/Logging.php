<?php

namespace DeepWebSolutions\Framework\Utilities\Services\Traits;

use DeepWebSolutions\Framework\Utilities\Services\LoggingService;

defined( 'ABSPATH' ) || exit;

/**
 * Trait for working with the logging service.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Utilities\Services\Traits
 */
trait Logging {
	// region FIELDS AND CONSTANTS

	/**
	 * Logging service for handling logging.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     LoggingService
	 */
	protected LoggingService $logging_service;

	// endregion

	// region GETTERS

	/**
	 * Gets the logging service instance. If not set, returns a service that does nothing.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  LoggingService
	 */
	public function get_logging_service(): LoggingService {
		return $this->logging_service ?? new LoggingService();
	}

	// endregion

	// region SETTERS

	/**
	 * Sets the logging service instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   LoggingService      $logging_service     The logging service instance to use from now on.
	 */
	public function set_logger_factory( LoggingService $logging_service ): void {
		$this->logging_service = $logging_service;
	}

	// endregion
}
