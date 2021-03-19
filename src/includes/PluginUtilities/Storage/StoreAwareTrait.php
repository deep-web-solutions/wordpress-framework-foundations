<?php

namespace DeepWebSolutions\Framework\Foundations\PluginUtilities\Storage;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of the store-container-aware interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\PluginUtilities\Storage
 */
trait StoreAwareTrait {
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
	protected StoreInterface $store;

	// endregion

	// region GETTERS

	/**
	 * Gets an instance of a store.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  StoreInterface
	 */
	public function get_store(): StoreInterface {
		return $this->store;
	}

	// endregion

	// region SETTERS

	/**
	 * Sets a store on the instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   StoreInterface      $store      Store to use from now on.
	 */
	public function set_store( StoreInterface $store ) {
		$this->store = $store;
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
	public function get_store_entry( string $entry_id ): ?StoreableInterface {
		try {
			return $this->get_store()->get( $entry_id );
		} catch ( ContainerExceptionInterface | NotFoundExceptionInterface $exception ) {
			return null;
		}
	}

	/**
	 * Adds an object to the store. Returns false on failure.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   StoreableInterface  $storeable  Object to store.
	 *
	 * @return  bool
	 */
	public function add_store_entry( StoreableInterface $storeable ): bool {
		try {
			$this->get_store()->add( $storeable );
			return true;
		} catch ( ContainerExceptionInterface $exception ) {
			return false;
		}
	}

	/**
	 * Updates (or adds if it doesn't exist) an object to the store. Returns false on failure.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   StoreableInterface  $storeable  Object to update/add.
	 *
	 * @return  bool
	 */
	public function update_store_entry( StoreableInterface $storeable ): bool {
		try {
			$this->get_store()->update( $storeable );
			return true;
		} catch ( ContainerExceptionInterface $exception ) {
			return false;
		}
	}

	/**
	 * Removes an object to the store. Returns false on failure.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   StoreableInterface  $storeable  Object to remove.
	 *
	 * @return  bool
	 */
	public function remove_store_entry( StoreableInterface $storeable ): bool {
		try {
			$this->get_store()->remove( $storeable );
			return true;
		} catch ( ContainerExceptionInterface $exception ) {
			return false;
		}
	}

	// endregion
}
