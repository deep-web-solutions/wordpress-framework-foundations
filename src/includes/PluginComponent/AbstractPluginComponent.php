<?php

namespace DeepWebSolutions\Framework\Foundations\PluginComponent;

use DeepWebSolutions\Framework\Foundations\Exceptions\InexistentPropertyException;
use DeepWebSolutions\Framework\Foundations\Exceptions\ReadOnlyPropertyException;
use DeepWebSolutions\Framework\Foundations\Logging\LoggingService;
use DeepWebSolutions\Framework\Foundations\Logging\LoggingServiceAwareInterface;
use DeepWebSolutions\Framework\Foundations\Logging\LoggingServiceAwareTrait;
use DeepWebSolutions\Framework\Helpers\FileSystem\Objects\PathsTrait;
use Psr\Log\LogLevel;

\defined( 'ABSPATH' ) || exit;

/**
 * Template for encapsulating some of the most often required abilities of a plugin component.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\PluginComponent
 */
abstract class AbstractPluginComponent implements LoggingServiceAwareInterface, PluginComponentInterface {
	// region TRAITS

	use LoggingServiceAwareTrait;
	use PathsTrait;
	use PluginComponentTrait;

	// endregion

	// region MAGIC METHODS

	/**
	 * AbstractPluginComponent constructor.
	 *
	 * @param   LoggingService  $logging_service    Instance of the logging service.
	 * @param   string|null     $component_id       Unique ID of the class instance. Must be persistent across requests.
	 * @param   string|null     $component_name     The public name of the using class instance. Must be persistent across requests. Mustn't be unique.
	 */
	public function __construct( LoggingService $logging_service, ?string $component_id = null, ?string $component_name = null ) {
		$this->set_logging_service( $logging_service );
		$this->set_component_id( $component_id ?: \hash( 'md5', static::class ) ); // phpcs:ignore
		$this->set_component_name( $component_name ?: static::class ); // phpcs:ignore
	}

	/**
	 * Shortcut for auto-magically accessing existing getters.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $name   Name of the property that should be retrieved.
	 *
	 * @noinspection PhpMissingReturnTypeInspection
	 * @return  InexistentPropertyException|mixed
	 */
	public function __get( string $name ) {
		if ( \method_exists( $this, ( $function = "get_{$name}" ) ) || \method_exists( $this, ( $function = 'get' . \ucfirst( $name ) ) ) ) { // phpcs:ignore
			return $this->{$function}();
		}

		if ( \method_exists( $this, ( $function = "is_{$name}" ) ) || \method_exists( $this, ( $function = 'is' . \ucfirst( $name ) ) ) ) { // phpcs:ignore
			return $this->{$function}();
		}

		return $this->log_event( \sprintf( 'Inexistent property: %s', $name ), array(), 'framework' )
			->set_log_level( LogLevel::ERROR )
			->doing_it_wrong( __FUNCTION__, '1.0.0' )
			->return_exception( InexistentPropertyException::class )
			->finalize();
	}

	/**
	 * Used for writing data to existent properties that have a setter \defined.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $name   The name of the property that should be reassigned.
	 * @param   mixed   $value  The value that should be assigned to the property.
	 *
	 * @noinspection PhpDocMissingThrowsInspection
	 * @throws  InexistentPropertyException  Thrown if there are no getters and no setter for the property, and a global variable also doesn't exist already.
	 * @throws  ReadOnlyPropertyException    Thrown if there is a getter for the property, but no setter.
	 *
	 * @return  mixed
	 */
	public function __set( string $name, $value ) {
		if ( \method_exists( $this, ( $function = "set_{$name}" ) ) || \method_exists( $this, ( $function = 'set' . \ucfirst( $name ) ) ) ) { // phpcs:ignore
			return $this->{$function}( $value );
		}

		$has_get_getter = \method_exists( $this, "get_{$name}" ) || \method_exists( $this, 'get' . \ucfirst( $name ) );
		$has_is_getter  = \method_exists( $this, "is_{$name}" ) || \method_exists( $this, 'is' . \ucfirst( $name ) );
		if ( $has_get_getter || $has_is_getter ) {
			/* @noinspection PhpUnhandledExceptionInspection */
			throw $this->log_event( \sprintf( 'Property %s is ready-only', $name ), array(), 'framework' )->set_log_level( LogLevel::ERROR )
				->doing_it_wrong( __FUNCTION__, '1.0.0' )->return_exception( ReadOnlyPropertyException::class )
				->finalize();
		}

		/* @noinspection PhpUnhandledExceptionInspection */
		throw $this->log_event( \sprintf( 'Inexistent property: %s', $name ), array(), 'framework' )
			->set_log_level( LogLevel::ERROR )
			->doing_it_wrong( __FUNCTION__, '1.0.0' )
			->return_exception( InexistentPropertyException::class )
			->finalize();
	}

	/**
	 * Used for checking whether a getter for a given property exists.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $name   The name of the property that existence is being checked.
	 *
	 * @return  bool
	 */
	public function __isset( string $name ): bool {
		if ( \method_exists( $this, "get_{$name}" ) || \method_exists( $this, 'get' . \ucfirst($name) ) ) { // phpcs:ignore
			return true;
		}

		if ( \method_exists( $this, "is_{$name}" ) || \method_exists( $this, 'is' . \ucfirst($name) ) ) { // phpcs:ignore
			return true;
		}

		return false;
	}

	// endregion
}
