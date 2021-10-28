<?php

namespace DeepWebSolutions\Framework\Foundations\Services;

use DeepWebSolutions\Framework\Foundations\Storage\MultiStoreAwareTrait;
use DeepWebSolutions\Framework\Foundations\Storage\StoreInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of the multi-handler-aware interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Services
 */
trait MultiHandlerAwareTrait {
	// region TRAITS

	use MultiStoreAwareTrait;

	// endregion

	// region GETTERS

	/**
	 * Gets the handlers store instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  StoreInterface|null
	 */
	public function get_handlers_store(): ?StoreInterface {
		return $this->get_store( 'handlers' );
	}

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
			return $this->get_handlers_store()->get_all();
		} catch ( ContainerExceptionInterface $exception ) {
			return array();
		}
	}

	// endregion

	// region SETTERS

	/**
	 * Sets the handlers store on the instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   StoreInterface      $store      Handlers store to set.
	 *
	 * @throws  \LogicException     Thrown if the handlers store has the wrong ID.
	 */
	public function set_handlers_store( StoreInterface $store ) {
		if ( 'handlers' !== $store->get_id() ) {
			throw new \LogicException( 'The handlers store must have the ID "handlers"' );
		}

		$this->update_stores_store_entry( $store );
	}

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
		$this->get_handlers_store()->empty();

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
		try {
			return $this->get_handlers_store()->get( $handler_id );
		} catch ( ContainerExceptionInterface | NotFoundExceptionInterface $exception ) {
			return null;
		}
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

		$this->get_handlers_store()->update( $handler );
		return $this;
	}

	// endregion
}
