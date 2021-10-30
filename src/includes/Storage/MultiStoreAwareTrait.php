<?php

namespace DeepWebSolutions\Framework\Foundations\Storage;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of the multi-store-aware interface.
 *
 * @since   1.0.0
 * @version 1.5.3
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Storage
 */
trait MultiStoreAwareTrait {
	// region FIELDS AND CONSTANTS

	/**
	 * List of stores.
	 *
	 * @since   1.0.0
	 * @version 1.5.3
	 *
	 * @access  protected
	 * @var     StoreInterface[]
	 */
	protected array $stores = array();

	// endregion

	// region GETTERS

	/**
	 * Gets all store instances set on the object.
	 *
	 * @since   1.0.0
	 * @version 1.5.3
	 *
	 * @return  StoreInterface[]
	 */
	public function get_stores(): array {
		return $this->stores;
	}

	/**
	 * Gets an instance of a store by its ID.
	 *
	 * @since   1.5.3
	 * @version 1.5.3
	 *
	 * @param   string  $store_id   The ID of the store to retrieve.
	 *
	 * @return  StoreInterface|null
	 */
	public function get_store( string $store_id ): ?StoreInterface {
		return $this->stores[ $store_id ] ?? null;
	}

	// endregion

	// region SETTERS

	/**
	 * Replaces all stores set on the object with new ones.
	 *
	 * @since   1.0.0
	 * @version 1.5.3
	 *
	 * @param   StoreInterface[]    $stores     Store instances to use from now on.
	 */
	public function set_stores( array $stores ) {
		$this->stores = array();

		foreach ( $stores as $store ) {
			if ( $store instanceof StoreInterface ) {
				$this->register_store( $store );
			}
		}
	}

	/**
	 * Registers a new store with the object.
	 *
	 * @since   1.0.0
	 * @version 1.5.3
	 *
	 * @param   StoreInterface  $store  Store to register with the instance.
	 *
	 * @return  MultiStoreAwareInterface
	 */
	public function register_store( StoreInterface $store ): MultiStoreAwareInterface {
		$this->stores[ $store->get_id() ] = $store;
		return $this;
	}

	// endregion

	// region HELPERS

	/**
	 * Returns an object from the store or null on failure.
	 *
	 * @since   1.0.0
	 * @version 1.5.3
	 *
	 * @param   string  $entry_id   The ID of the entry to retrieve from the store.
	 * @param   string  $store_id   The ID of the store to retrieve the entry from.
	 *
	 * @return  StorableInterface|null
	 */
	public function get_store_entry( string $entry_id, string $store_id ): ?StorableInterface {
		try {
			$store = $this->get_store( $store_id );
			return $store ? $store->get( $entry_id ) : null;
		} catch ( ContainerExceptionInterface | NotFoundExceptionInterface $exception ) {
			return null;
		}
	}

	// endregion
}
