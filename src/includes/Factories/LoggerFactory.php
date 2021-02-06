<?php

namespace DeepWebSolutions\Framework\Utilities\Factories;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

defined( 'ABSPATH' ) || exit;

/**
 * Logger factory to facilitate clean dependency injection inspired by Java's SLF4 library.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Utilities\Factories
 */
final class LoggerFactory {
	// region PROPERTIES

	/**
	 * Collection of instantiated loggers.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  private
	 * @var     LoggerInterface[]
	 */
	private array $loggers;

	/**
	 * Collection of logger-instantiating callables.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  private
	 * @var     callable[]
	 */
	private array $callables;

	// endregion

	// region MAGIC METHODS

	/**
	 * LoggerFactory constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function __construct() {
		$this->loggers['NullLogger'] = new NullLogger();
	}

	// endregion

	// region METHODS

	/**
	 * Registers a new callback with the logger factory for instantiating a new PSR-3 logger.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string      $name       The name of the logger.
	 * @param   callable    $callable   The PHP callback required to instantiate it.
	 */
	public function register_factory_callable( string $name, callable $callable ): void {
		$this->callables[ $name ] = $callable;
	}

	/**
	 * Returns a PSR-3 logger.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $name       The name of the logger. Must match with the name used when registering the callback.
	 * @param   array   $arguments  The arguments that should be passed on to the callback, encapsulated in an array.
	 *
	 * @return  LoggerInterface
	 */
	public function get_logger( string $name, array $arguments = array() ): LoggerInterface {
		$key = hash( 'md5', wp_json_encode( array_merge( array( 'name' => $name ), $arguments ) ) );

		if ( ! isset( $this->loggers[ $key ] ) ) {
			$this->loggers[ $key ] = $this->loggers['NullLogger'];
			if ( is_callable( $this->callables[ $name ] ?? '' ) ) {
				$logger = call_user_func( $this->callables[ $name ], ...$arguments );
				if ( $logger instanceof LoggerInterface ) {
					$this->loggers[ $key ] = $logger;
				} elseif ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
					// Throwing an exception seems rather extreme.
					error_log( "Failed to instantiate logger $name!!!" ); // @phpcs:ignore
				}
			}
		}

		return $this->loggers[ $key ];
	}

	// endregion
}
