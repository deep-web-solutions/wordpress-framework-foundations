<?php

namespace DeepWebSolutions\Framework\Foundations\Utilities\Handlers;

use DeepWebSolutions\Framework\Foundations\Utilities\Storage\StoreAwareTrait;
use Psr\Container\ContainerExceptionInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of the multi-handler-aware interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Utilities\Handlers
 */
trait MultiHandlerAwareTrait {
	// region TRAITS

	use StoreAwareTrait;

	// endregion

	// region GETTERS

	/**
	 * Gets all handler instances set on the object.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  HandlerInterface[]
	 */
	public function get_handlers(): array {
		try {
			return $this->get_store()->get_all();
		} catch ( ContainerExceptionInterface $exception ) {
			return array();
		}
	}

	// endregion

	// region SETTERS

	/**
	 * Replaces all handlers set on the object with new ones.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   HandlerInterface[]      $handlers       Handlers to be used by the service from now on.
	 *
	 * @return  $this
	 */
	public function set_handlers( array $handlers ): self {
		$this->get_store()->empty();

		foreach ( $handlers as $handler ) {
			if ( $handler instanceof HandlerInterface ) {
				$this->register_handler( $handler );
			}
		}

		return $this;
	}

	// endregion

	// region METHODS

	/**
	 * Returns a given handler set on the object by its ID.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handler_id     The ID of the handler.
	 *
	 * @return  HandlerInterface|null
	 */
	public function get_handler( string $handler_id ): ?HandlerInterface {
		/* @noinspection PhpIncompatibleReturnTypeInspection */
		return $this->get_store_entry( $handler_id );
	}

	/**
	 * Registers a new handler with the service.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   HandlerInterface    $handler    The new handler to register with the service.
	 *
	 * @throws  \LogicException     Thrown when the trait is used on a non-multi-handler-aware object.
	 *
	 * @return  MultiHandlerAwareInterface
	 */
	public function register_handler( HandlerInterface $handler ): MultiHandlerAwareInterface {
		if ( ! $this instanceof MultiHandlerAwareInterface ) {
			throw new \LogicException( 'Using classes must be multi-handler aware objects.' );
		}

		$this->update_store_entry( $handler );
		return $this;
	}

	// endregion
}
