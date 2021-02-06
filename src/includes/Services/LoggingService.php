<?php

namespace DeepWebSolutions\Framework\Utilities\Services;

use DeepWebSolutions\Framework\Utilities\Factories\LoggerFactory;

defined( 'ABSPATH' ) || exit;

/**
 * Handles the logging of messages. GDPR-appropriate + full logger flexibility.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Utilities
 */
final class LoggingService {

	// region INHERITED FUNCTIONS

	/**
	 * LoggingService constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   LoggerFactory   $logger_factory
	 */
	public function __construct( LoggerFactory $logger_factory ) {

	}

	// endregion
}
