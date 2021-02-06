<?php

namespace DeepWebSolutions\Framework\Utilities\Services;

use DeepWebSolutions\Framework\Utilities\Factories\LoggerFactory;
use Psr\Log\LogLevel;

defined( 'ABSPATH' ) || exit;

/**
 * Handles the logging of messages. GDPR-appropriate + full logger flexibility.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Utilities
 */
class LoggingService {
	// region FIELDS AND CONSTANTS

	/**
	 * Logger factory for retrieving loggers.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  private
	 * @var     LoggerFactory
	 */
	protected LoggerFactory $logger_factory;

	/**
	 * Whether to include sensitive information in the logs or not.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     bool
	 */
	protected bool $include_sensitive;

	// endregion

	// region INHERITED FUNCTIONS

	/**
	 * LoggingService constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   LoggerFactory   $logger_factory     The logger factory instance.
	 * @param   bool            $include_sensitive  Whether the logs should include sensitive information or not.
	 */
	public function __construct( LoggerFactory $logger_factory, bool $include_sensitive = false ) {
		$this->logger_factory    = $logger_factory;
		$this->include_sensitive = $include_sensitive;
	}

	// endregion

	// region GETTERS

	/**
	 * Gets the logger factory instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  LoggerFactory
	 */
	public function get_logger_factory(): LoggerFactory {
		return $this->logger_factory;
	}

	/**
	 * Gets whether the logs will include any sensitive information or not.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  bool
	 */
	public function includes_sensitive_messages(): bool {
		return $this->include_sensitive;
	}

	// endregion

	// region METHODS

	/**
	 * Logs an event with the given logger.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $log_level      The level of the log message.
	 * @param   string  $message        The log message.
	 * @param   string  $logger         The logger to log the event with.
	 * @param   bool    $is_sensitive   Whether the log may contain any GDPR-sensitive information.
	 * @param   array   $context        The context to pass along to the logger.
	 */
	public function log_event( string $log_level, string $message, string $logger = 'default', bool $is_sensitive = false, array $context = array() ) {
		$logger = $this->get_logger_factory()->get_logger( $logger );
		if ( ! $is_sensitive || $this->includes_sensitive_messages() ) {
			$logger->log( $log_level, $message, $context );
		}
	}

	/**
	 * Logs an event with an appropriate level and returns an exception with the same message.
	 *
	 * @param   string  $log_level      The PSR3 log level.
	 * @param   string  $exception      The exception to instantiate.
	 * @param   string  $message        The message to log/return as exception.
	 * @param   string  $logger         The logger to log the event with.
	 * @param   bool    $is_sensitive   Whether the log may contain any GDPR-sensitive information.
	 * @param   array   $context        The PSR3 context.
	 *
	 * @return  \Exception
	 */
	public function log_event_and_return_exception( string $log_level, string $exception, string $message, string $logger = 'default', bool $is_sensitive = false, array $context = array() ): \Exception {
		$this->log_event( $logger, $log_level, $message, $is_sensitive, $context );
		return new $exception( $message );
	}

	/**
	 * Logs an event with an appropriate level and also runs a '_doing_it_wrong' call with the same message.
	 *
	 * @param   string  $function       The function being used incorrectly.
	 * @param   string  $message        The message to log/return as exception.
	 * @param   string  $since_version  The plugin version that introduced this warning message.
	 * @param   string  $log_level      The PSR3 log level.
	 * @param   string  $logger         The logger to log the event with.
	 * @param   bool    $is_sensitive   Whether the log may contain any GDPR-sensitive information.
	 * @param   array   $context        The PSR3 context.
	 */
	public function log_event_and_doing_it_wrong( string $function, string $message, string $since_version, string $log_level = LogLevel::DEBUG, string $logger = 'default', bool $is_sensitive = false, array $context = array() ): void {
		$this->log_event( $logger, $log_level, $message, $is_sensitive, $context );
		_doing_it_wrong( $function, $message, $since_version ); // phpcs:ignore
	}

	/**
	 * Logs an event with an appropriate level, runs a '_doing_it_wrong' call, and returns an exception with the same message.
	 *
	 * @param   string  $function       The function being used incorrectly.
	 * @param   string  $message        The message to log/return as exception.
	 * @param   string  $since_version  The plugin version that introduced this warning message.
	 * @param   string  $exception      The exception to instantiate.
	 * @param   string  $log_level      The PSR3 log level.
	 * @param   string  $logger         The logger to log the event with.
	 * @param   bool    $is_sensitive   Whether the log may contain any GDPR-sensitive information.
	 * @param   array   $context        The PSR3 context.
	 *
	 * @return  \Exception
	 */
	public function log_event_and_doing_it_wrong_and_return_exception( string $function, string $message, string $since_version, string $exception, string $log_level = LogLevel::DEBUG, string $logger = 'default', bool $is_sensitive = false, array $context = array() ): \Exception {
		$this->log_event( $logger, $log_level, $message, $is_sensitive, $context );
		_doing_it_wrong( $function, $message, $since_version ); // phpcs:ignore
		return new $exception( $message );
	}

	// endregion
}
