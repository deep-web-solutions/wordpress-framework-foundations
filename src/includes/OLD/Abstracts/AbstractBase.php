<?php

namespace DeepWebSolutions\Framework\Utilities\Abstracts;

use DeepWebSolutions\Framework\Helpers\PHP\Traits\PathsTrait;
use DeepWebSolutions\Framework\Utilities\Exceptions\Properties\InexistentProperty;
use DeepWebSolutions\Framework\Utilities\Exceptions\Properties\ReadOnlyProperty;
use DeepWebSolutions\Framework\Utilities\Interfaces\Resources\IdentityInterface;
use DeepWebSolutions\Framework\Utilities\Interfaces\Resources\Traits\IdentityTrait;
use DeepWebSolutions\Framework\Utilities\Interfaces\Resources\Traits\Plugin\PluginAwareTrait;
use DeepWebSolutions\Framework\Utilities\Services\Traits\LoggingServiceAwareTrait;
use Psr\Log\LogLevel;

/**
 * Template for encapsulating some of the most often required abilities of a class.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Utilities\Abstracts
 */
abstract class AbstractBase implements IdentityInterface {
	// region TRAITS

	use IdentityTrait;
	use LoggingServiceAwareTrait;
	use PathsTrait;
	use PluginAwareTrait;

	// endregion

	// region MAGIC METHODS

	/**
	 * Base constructor.
	 *
	 * @param   string|null     $base_id            Unique ID of the class instance. Must be persistent across requests.
	 * @param   string|null     $base_public_name   The public name of the using class instance. Must be persistent across requests. Mustn't be unique.
	 */
	public function __construct( ?string $base_id = null, ?string $base_public_name = null ) {
		$this->set_instance_id( $base_id ?: hash( 'md5', static::class ) ); // phpcs:ignore
		$this->set_instance_public_name( $base_public_name ?: static::class ); // phpcs:ignore
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
	 * @return  InexistentProperty|mixed
	 */
	public function __get( string $name ) {
		if ( method_exists( $this, ( $function = "get_{$name}" ) ) || method_exists( $this, ( $function = 'get' . ucfirst( $name ) ) ) ) { // phpcs:ignore
			return $this->{$function}();
		}

		if ( method_exists( $this, ( $function = "is_{$name}" ) ) || method_exists( $this, ( $function = 'is' . ucfirst( $name ) ) ) ) { // phpcs:ignore
			return $this->{$function}();
		}

		return $this->log_event_and_return_exception(
			LogLevel::DEBUG,
			sprintf( 'Inexistent property: %s', $name ),
			InexistentProperty::class,
			null,
			'framework'
		);
	}

	/**
	 * Used for writing data to existent properties that have a setter defined.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $name   The name of the property that should be reassigned.
	 * @param   mixed   $value  The value that should be assigned to the property.
	 *
	 * @noinspection PhpDocRedundantThrowsInspection
	 * @noinspection PhpDocMissingThrowsInspection
	 * @throws  InexistentProperty  Thrown if there are no getters and no setter for the property, and a global variable also doesn't exist already.
	 * @throws  ReadOnlyProperty    Thrown if there is a getter for the property, but no setter.
	 *
	 * @return  mixed
	 */
	public function __set( string $name, $value ) {
		if ( method_exists( $this, ( $function = "set_{$name}" ) ) || method_exists( $this, ( $function = 'set' . ucfirst( $name ) ) ) ) { // phpcs:ignore
			return $this->{$function}( $value );
		}

		$has_get_getter = method_exists( $this, "get_{$name}" ) || method_exists( $this, 'get' . ucfirst( $name ) );
		$has_is_getter  = method_exists( $this, "is_{$name}" ) || method_exists( $this, 'is' . ucfirst( $name ) );
		if ( $has_get_getter || $has_is_getter ) {
			/* @noinspection PhpUnhandledExceptionInspection */
			throw $this->log_event_and_return_exception(
				LogLevel::DEBUG,
				sprintf( 'Property %s is ready-only', $name ),
				ReadOnlyProperty::class,
				null,
				'framework'
			);
		}

		/* @noinspection PhpUnhandledExceptionInspection */
		throw $this->log_event_and_return_exception(
			LogLevel::DEBUG,
			sprintf( 'Inexistent property: %s', $name ),
			InexistentProperty::class,
			null,
			'framework'
		);
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
		if ( method_exists( $this, "get_{$name}" ) || method_exists( $this, 'get' . ucfirst($name) ) ) { // phpcs:ignore
			return true;
		}

		if ( method_exists( $this, "is_{$name}" ) || method_exists( $this, 'is' . ucfirst($name) ) ) { // phpcs:ignore
			return true;
		}

		return false;
	}

	// endregion
}
