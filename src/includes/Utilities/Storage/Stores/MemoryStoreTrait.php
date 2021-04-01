<?php

namespace DeepWebSolutions\Framework\Foundations\Utilities\Storage\Stores;

use DeepWebSolutions\Framework\Foundations\Exceptions\NotFoundException;
use DeepWebSolutions\Framework\Foundations\Utilities\Storage\StoreableInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Storage\StoreException;

\defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of an in-memory store.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Utilities\Storage\Stores
 */
trait MemoryStoreTrait {
	// region FIELDS AND CONSTANTS

	/**
	 * Objects stored in-memory.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @var     StoreableInterface[]
	 */
	protected array $stored_objects = array();

	// endregion

	// region METHODS

	/**
	 * Returns the identifier of the store.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	abstract public function get_id(): string;

	/**
	 * Returns the storage medium of the store.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_storage_type(): string {
		return 'memory';
	}

	/**
	 * Returns the total number of entries stored.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  int
	 */
	public function count(): int {
		return \count( $this->stored_objects );
	}

	/**
	 * Checks whether an entry currently exists or not.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $entry_id     The identifier of the entry.
	 *
	 * @return  bool
	 */
	public function has( string $entry_id ): bool {
		return isset( $this->stored_objects[ $entry_id ] ) || \array_key_exists( $entry_id, $this->stored_objects );
	}

	// endregion

	// region CRUD

	/**
	 * Returns all the entries stored.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  StoreableInterface[]
	 */
	public function get_all(): array {
		return $this->stored_objects;
	}

	/**
	 * Returns an entry from the store.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $entry_id   The identifier of the entry.
	 *
	 * @throws  NotFoundException   Thrown when the entry does not exist.
	 *
	 * @return  StoreableInterface
	 */
	public function get( string $entry_id ): StoreableInterface {
		if ( $this->has( $entry_id ) ) {
			return $this->stored_objects[ $entry_id ];
		}

		throw new NotFoundException( \sprintf( 'Could not retrieve entry %1$s. Not found in store %2$s of type %3$s', $entry_id, $this->get_id(), $this->get_storage_type() ) );
	}

	/**
	 * Adds an entry to the store.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   StoreableInterface  $storeable  Object to store.
	 *
	 * @throws  StoreException      Error while adding the entry.
	 */
	public function add( StoreableInterface $storeable ) {
		$entry_id = $storeable->get_id();

		if ( $this->has( $entry_id ) ) {
			throw new StoreException( \sprintf( 'Entry %1$s already exists in store %2$s of type %3$s', $entry_id, $this->get_id(), $this->get_storage_type() ) );
		}

		$this->stored_objects[ $entry_id ] = $storeable;
	}

	/**
	 * Updates (or adds if it doesn't exist) an entry in the store.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   StoreableInterface  $storeable  Object to add or update.
	 */
	public function update( StoreableInterface $storeable ) {
		$this->stored_objects[ $storeable->get_id() ] = $storeable;
	}

	/**
	 * Removes an entry from the store.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $entry_id   The identifier of the entry.
	 *
	 * @throws  NotFoundException   Thrown when the entry does not exist.
	 */
	public function remove( string $entry_id ) {
		if ( ! $this->has( $entry_id ) ) {
			throw new NotFoundException( \sprintf( 'Could not delete entry %1$s. Not found in store %2$s of type %3$s', $entry_id, $this->get_id(), $this->get_storage_type() ) );
		}

		unset( $this->stored_objects[ $entry_id ] );
	}

	// endregion
}
