<?php

namespace DeepWebSolutions\Framework\Foundations\Logging;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

\defined( 'ABSPATH' ) || exit;

/**
 * Logs messages at all PSR-3 levels. GDPR-appropriate + full logger choice flexibility.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Logging
 */
class LoggingHandler extends AbstractLoggingHandler {
	// region FIELDS AND CONSTANTS

	/**
	 * Instance of a PSR-3 conform logger.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     LoggerInterface
	 */
	protected LoggerInterface $logger;

	// endregion

	// region MAGIC METHODS

	/**
	 * LoggingHandler constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string                  $handler_id     Unique name for the logging handler / logger itself.
	 * @param   LoggerInterface|null    $logger         Instance of a PSR-3 conform logger.
	 */
	public function __construct( string $handler_id = 'null', ?LoggerInterface $logger = null ) {
		parent::__construct( $handler_id );
		$this->logger = $logger ?? new NullLogger();
	}

	// endregion

	// region INHERITED METHODS

	/**
	 * Logs an emergency with the provided logger.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $message    Message to log.
	 * @param   array   $context    Additional context to pass along.
	 */
	public function emergency( $message, array $context = array() ) {
		$this->logger->emergency( $message, $context );
	}

	/**
	 * Logs an alert with the provided logger.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $message    Message to log.
	 * @param   array   $context    Additional context to pass along.
	 */
	public function alert( $message, array $context = array() ) {
		$this->logger->alert( $message, $context );
	}

	/**
	 * Logs a critical message with the provided logger.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $message    Message to log.
	 * @param   array   $context    Additional context to pass along.
	 */
	public function critical( $message, array $context = array() ) {
		$this->logger->critical( $message, $context );
	}

	/**
	 * Logs an error with the provided logger.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $message    Message to log.
	 * @param   array   $context    Additional context to pass along.
	 */
	public function error( $message, array $context = array() ) {
		$this->logger->error( $message, $context );
	}

	/**
	 * Logs a warning with the provided logger.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $message    Message to log.
	 * @param   array   $context    Additional context to pass along.
	 */
	public function warning( $message, array $context = array() ) {
		$this->logger->warning( $message, $context );
	}

	/**
	 * Logs a notice with the provided logger.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $message    Message to log.
	 * @param   array   $context    Additional context to pass along.
	 */
	public function notice( $message, array $context = array() ) {
		$this->logger->notice( $message, $context );
	}

	/**
	 * Logs an informational message with the provided logger.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $message    Message to log.
	 * @param   array   $context    Additional context to pass along.
	 */
	public function info( $message, array $context = array() ) {
		$this->logger->info( $message, $context );
	}

	/**
	 * Logs a debug message with the provided logger.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $message    Message to log.
	 * @param   array   $context    Additional context to pass along.
	 */
	public function debug( $message, array $context = array() ) {
		$this->logger->debug( $message, $context );
	}

	/**
	 * Performs a logging operation with the provided logger.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   int     $level      Level of the message.
	 * @param   string  $message    Message to log.
	 * @param   array   $context    Additional context to pass along.
	 */
	public function log( $level, $message, array $context = array() ) {
		$this->logger->log( $level, $message, $context );
	}

	// endregion
}
