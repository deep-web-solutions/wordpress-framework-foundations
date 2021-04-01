<?php

namespace DeepWebSolutions\Framework\Foundations\Utilities\Storage;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of the multi-store-aware interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Utilities\Storage
 */
trait MultiStoreAwareTrait {
	// region FIELDS AND CONSTANTS

	/**
	 * Store instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     StoreInterface
	 */
	protected StoreInterface $stores_store;

	// endregion

	// region GETTERS

	/**
	 * Gets the stores store instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  StoreInterface
	 */
	public function get_stores_store(): StoreInterface {
		return $this->stores_store;
	}

	/**
	 * Gets all store instances set on the object.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  StoreInterface[]
	 */
	public function get_stores(): array {
		try {
			return $this->get_stores_store()->get_all();
		} catch ( ContainerExceptionInterface $exception ) {
			return array();
		}
	}

	// endregion

	// region SETTERS

	/**
	 * Sets a stores store on the instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   StoreInterface      $store      Store to use from now on.
	 */
	public function set_stores_store( StoreInterface $store ) {
		$this->stores_store = $store;
	}

	/**
	 * Replaces all stores set on the object with new ones.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   StoreInterface[]    $stores     Store instances to use from now on.
	 *
	 * @return  $this
	 */
	public function set_stores( array $stores ): self {
		$this->get_stores_store()->empty();

		foreach ( $stores as $store ) {
			if ( $store instanceof StoreInterface ) {
				$this->register_store( $store );
			}
		}

		return $this;
	}

	// endregion

	// region METHODS

	/**
	 * Returns a given store set on the object by its ID.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $store_id   The ID of the store.
	 *
	 * @return  StoreInterface|null
	 */
	public function get_store( string $store_id ): ?StoreInterface {
		return $this->get_stores_store_entry( $store_id );
	}

	/**
	 * Registers a new store with the object.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   StoreInterface  $store  Store to register with the instance.
	 *
	 * @throws  \LogicException     Thrown if the trait is used in a non-compatible object.
	 *
	 * @return  MultiStoreAwareInterface    Should return itself to enqueue multiple calls in one line.
	 */
	public function register_store( StoreInterface $store ): MultiStoreAwareInterface {
		if ( ! $this instanceof MultiStoreAwareInterface ) {
			throw new \LogicException( 'Using classes must be multi-store aware objects.' );
		}

		$this->update_stores_store_entry( $store );
		return $this;
	}

	// endregion

	// region HELPERS

	/**
	 * Returns an object from the store or null on failure.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $entry_id   The ID of the entry to retrieve from the store.
	 *
	 * @return  StoreableInterface|null
	 */
	public function get_stores_store_entry( string $entry_id ): ?StoreInterface {
		try {
			return $this->get_stores_store()->get( $entry_id );
		} catch ( ContainerExceptionInterface | NotFoundExceptionInterface $exception ) {
			return null;
		}
	}

	/**
	 * Adds a store to the stores store. Returns false on failure.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   StoreInterface      $store      Store to store.
	 *
	 * @return  bool
	 */
	public function add_stores_store_entry( StoreInterface $store ): bool {
		try {
			$this->get_stores_store()->add( $store );
			return true;
		} catch ( ContainerExceptionInterface $exception ) {
			return false;
		}
	}

	/**
	 * Updates (or adds if it doesn't exist) a store to the stores store. Returns false on failure.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   StoreInterface      $store      Store to add/update.
	 *
	 * @return  bool
	 */
	public function update_stores_store_entry( StoreInterface $store ): bool {
		try {
			$this->get_stores_store()->update( $store );
			return true;
		} catch ( ContainerExceptionInterface $exception ) {
			return false;
		}
	}

	/**
	 * Removes a store from the stores store. Returns false on failure.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $entry_id   The ID of the entry to remove from the store.
	 *
	 * @return  bool
	 */
	public function remove_stores_store_entry( string $entry_id ): bool {
		try {
			$this->get_stores_store()->remove( $entry_id );
			return true;
		} catch ( ContainerExceptionInterface $exception ) {
			return false;
		}
	}

	// endregion
}
