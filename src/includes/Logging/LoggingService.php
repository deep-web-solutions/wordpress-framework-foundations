<?php

namespace DeepWebSolutions\Framework\Foundations\Logging;

use DeepWebSolutions\Framework\Foundations\Plugin\PluginInterface;
use DeepWebSolutions\Framework\Foundations\PluginUtilities\DependencyInjection\ContainerAwareInterface;
use DeepWebSolutions\Framework\Foundations\PluginUtilities\Services\AbstractMultiHandlerService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
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
	protected bool $log_sensitive;

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
		$this->log_sensitive = $include_sensitive;
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
	 * @return  LoggingHandlerInterface
	 */
	public function get_handler( string $handler_id ): LoggingHandlerInterface {
		$handler = parent::get_handler( $handler_id );

		/* @noinspection PhpIncompatibleReturnTypeInspection */
		return $handler ?? parent::get_handler( 'null' );
	}

	// endregion

	// region GETTERS

	/**
	 * Returns whether the logs will include messages marked sensitive or not.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  bool
	 */
	public function log_sensitive_messages(): bool {
		return $this->log_sensitive;
	}

	// endregion

	// region METHODS

	/**
	 * Returns a configurable log message object that needs to be finalized.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $message    The log message.
	 * @param   array   $context    The context to pass along to the logger.
	 * @param   string  $handler    The logging handler to log the event with.
	 *
	 * @return  LogMessageBuilder
	 */
	public function log_event( string $message, array $context = array(), string $handler = 'plugin' ): LogMessageBuilder {
		return new LogMessageBuilder(
			$this->get_handler( $handler ),
			$this->log_sensitive_messages(),
			$message,
			$context
		);
	}

	/**
	 * Logs an event immediately using the given handler.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $message    The log message.
	 * @param   array   $context    The context to pass along to the logger.
	 * @param   string  $log_level  The log level of the message.
	 * @param   string  $handler    The logging handler to log the event with.
	 */
	public function log_event_and_finalize( string $message, array $context = array(), string $log_level = LogLevel::DEBUG, string $handler = 'plugin' ): void {
		$this->log_event( $message, $context, $handler )->set_log_level( $log_level )->finalize();
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
		return LoggingHandlerInterface::class;
	}

	// endregion
}
