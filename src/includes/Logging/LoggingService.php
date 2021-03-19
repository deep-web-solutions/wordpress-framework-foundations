<?php

namespace DeepWebSolutions\Framework\Foundations\Logging;

use DeepWebSolutions\Framework\Foundations\Plugin\PluginAwareInterface;
use DeepWebSolutions\Framework\Foundations\Plugin\PluginInterface;
use DeepWebSolutions\Framework\Foundations\PluginUtilities\DependencyInjection\ContainerAwareInterface;
use DeepWebSolutions\Framework\Foundations\PluginUtilities\Handlers\HandlerInterface;
use DeepWebSolutions\Framework\Foundations\PluginUtilities\Services\AbstractMultiHandlerService;
use DeepWebSolutions\Framework\Foundations\PluginUtilities\Services\AbstractService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
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
class LoggingService extends AbstractMultiHandlerService {
	// region FIELDS AND CONSTANTS

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

	// region MAGIC FUNCTIONS

	/**
	 * LoggingService constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
	 *
	 * @param   PluginInterface     $plugin             Instance of the plugin.
	 * @param   LoggingHandler[]    $handlers           Collection of logging handlers to use.
	 * @param   bool                $include_sensitive  Whether the logs should include sensitive information or not.
	 */
	public function __construct( PluginInterface $plugin, array $handlers = array(), bool $include_sensitive = false ) {
		parent::__construct( $plugin, $this, $handlers );
		$this->include_sensitive = $include_sensitive;
	}

	// endregion

	// region INHERITED FUNCTIONS

	/**
	 * Returns a given logging handler from the list of registered ones.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string      $handler_id         Unique name of the logging handler to retrieve.
	 *
	 * @return  LoggingHandler
	 */
	public function get_handler( string $handler_id ): LoggingHandler {
		$handler = parent::get_handler( $handler_id );

		/* @noinspection PhpIncompatibleReturnTypeInspection */
		return $handler ?? parent::get_handler( 'null' );
	}

	// endregion

	// region GETTERS

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
	 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
	 *
	 * @param   string  $log_level      The level of the log message.
	 * @param   string  $message        The log message.
	 * @param   string  $logger         The logger to log the event with.
	 * @param   bool    $is_sensitive   Whether the log may contain any GDPR-sensitive information.
	 * @param   array   $context        The context to pass along to the logger.
	 */
	public function log_event( string $log_level, string $message, string $logger = 'plugin', bool $is_sensitive = false, array $context = array() ): void {
		$logger = $this->get_handler( $logger );
		if ( ! $is_sensitive || $this->includes_sensitive_messages() ) {
			$logger->log( $log_level, $message, $context );
		}
	}

	/**
	 * Logs an event with an appropriate level and also runs a '_doing_it_wrong' call with the same message.
	 *
	 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
	 *
	 * @param   string  $function       The function being used incorrectly.
	 * @param   string  $message        The message to log/return as exception.
	 * @param   string  $since_version  The plugin version that introduced this warning message.
	 * @param   string  $log_level      The PSR3 log level.
	 * @param   string  $logger         The logger to log the event with.
	 * @param   bool    $is_sensitive   Whether the log may contain any GDPR-sensitive information.
	 * @param   array   $context        The PSR3 context.
	 */
	public function log_event_and_doing_it_wrong( string $function, string $message, string $since_version, string $log_level = LogLevel::DEBUG, string $logger = 'plugin', bool $is_sensitive = false, array $context = array() ): void {
		$this->log_event( $log_level, $message, $logger, $is_sensitive, $context );
		\_doing_it_wrong( wp_kses_post( $function ), wp_kses_post( $message ), wp_kses_post( $since_version ) );
	}

	/**
	 * Logs an event with an appropriate level and returns an exception with the same message.
	 *
	 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
	 *
	 * @param   string              $log_level              The PSR3 log level.
	 * @param   string              $message                The message to log/return as exception.
	 * @param   string              $exception              The exception to instantiate.
	 * @param   \Exception|null     $original_exception     The original exception that was thrown. If not applicable, null.
	 * @param   string              $logger                 The logger to log the event with.
	 * @param   bool                $is_sensitive           Whether the log may contain any GDPR-sensitive information.
	 * @param   array               $context                The PSR3 context.
	 *
	 * @return  \Exception
	 */
	public function log_event_and_return_exception( string $log_level, string $message, string $exception, \Exception $original_exception = null, string $logger = 'plugin', bool $is_sensitive = false, array $context = array() ): \Exception {
		$this->log_event( $log_level, $message, $logger, $is_sensitive, $context );
		return new $exception( $message, $original_exception ? $original_exception->getCode() : 0, $original_exception );
	}

	/**
	 * Logs an event with an appropriate level, runs a '_doing_it_wrong' call, and returns an exception with the same message.
	 *
	 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
	 *
	 * @param   string              $function               The function being used incorrectly.
	 * @param   string              $message                The message to log/return as exception.
	 * @param   string              $since_version          The plugin version that introduced this warning message.
	 * @param   string              $exception              The exception to instantiate.
	 * @param   \Exception|null     $original_exception     The original exception that was thrown. If not applicable, null.
	 * @param   string              $log_level              The PSR3 log level.
	 * @param   string              $logger                 The logger to log the event with.
	 * @param   bool                $is_sensitive           Whether the log may contain any GDPR-sensitive information.
	 * @param   array               $context                The PSR3 context.
	 *
	 * @return  \Exception
	 */
	public function log_event_and_doing_it_wrong_and_return_exception( string $function, string $message, string $since_version, string $exception, \Exception $original_exception = null, string $log_level = LogLevel::DEBUG, string $logger = 'plugin', bool $is_sensitive = false, array $context = array() ): \Exception {
		$this->log_event_and_doing_it_wrong( $function, $message, $since_version, $log_level, $logger, $is_sensitive, $context );
		return new $exception( $message, $original_exception ? $original_exception->getCode() : 0, $original_exception );
	}

	// endregion

	// region HELPERS

	/**
	 * Register the logging handlers passed on in the constructor together with the default handlers.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param array $handlers Logging handlers passed on in the constructor.
	 *
	 * @throws  NotFoundExceptionInterface      Thrown if the NullLogger is not found in the plugin DI-container.
	 * @throws  ContainerExceptionInterface     Thrown if some other error occurs while retrieving the NullLogger instance.
	 */
	protected function set_default_handlers( array $handlers ): void {
		$plugin = $this->get_plugin();

		$null_logger = ( $plugin instanceof ContainerAwareInterface )
			? $plugin->get_container()->get( NullLogger::class )
			: new NullLogger();

		$handlers = array_merge( array( new LoggingHandler( 'null', $null_logger ) ), $handlers );

		parent::set_default_handlers( $handlers );
	}

	/**
	 * Returns the class name of the used handler for better type-checking.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	protected function get_handler_class(): string {
		return LoggingHandler::class;
	}

	// endregion
}
