<?php

namespace DeepWebSolutions\Framework\Foundations\PluginUtilities\Storage\Stores;

use DeepWebSolutions\Framework\Foundations\Exceptions\NotFoundException;
use DeepWebSolutions\Framework\Foundations\PluginUtilities\Storage\StoreableInterface;
use DeepWebSolutions\Framework\Foundations\PluginUtilities\Storage\StoreException;

\defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of an options table store.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\PluginUtilities\Storage\Stores
 */
trait OptionsStoreTrait {
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
		return 'options-table';
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
		return \count( $this->get_all() );
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
		return isset( $this->get_all()[ $entry_id ] );
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
		return \get_option( $this->get_id(), array() );
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
			return $this->get_all()[ $entry_id ];
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
		if ( $this->has( $storeable->get_id() ) ) {
			throw new StoreException( \sprintf( 'Entry %1$s already exists in store %2$s of type %3$s', $storeable->get_id(), $this->get_id(), $this->get_storage_type() ) );
		}

		$this->update( $storeable );
	}

	/**
	 * Updates (or adds if it doesn't exist) an entry in the store.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   StoreableInterface  $storeable  Object to add or update.
	 *
	 * @return  bool
	 */
	public function update( StoreableInterface $storeable ): bool {
		return \update_option(
			$this->get_id(),
			\array_merge(
				$this->get_all(),
				array( $storeable->get_id() => $storeable )
			)
		);
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
	 *
	 * @return  bool
	 */
	public function remove( string $entry_id ): bool {
		if ( $this->has( $entry_id ) ) {
			$stored_objects = $this->get_all();

			unset( $stored_objects[ $entry_id ] );

			return empty( $stored_objects )
				? \delete_option( $this->get_id() )
				: \update_option( $this->get_id(), $stored_objects );
		}

		throw new NotFoundException( \sprintf( 'Could not delete entry %1$s. Not found in store %2$s of type %3$s', $entry_id, $this->get_id(), $this->get_storage_type() ) );
	}

	// endregion
}
