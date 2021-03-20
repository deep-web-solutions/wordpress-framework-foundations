<?php

namespace DeepWebSolutions\Framework\Foundations\Utilities\Storage\Stores;

use DeepWebSolutions\Framework\Foundations\Exceptions\NotFoundException;
use DeepWebSolutions\Framework\Foundations\Utilities\Storage\StoreableInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Storage\StoreException;

\defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of a user-meta store.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Utilities\Storage\Stores
 */
trait UserMetaStoreTrait {
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
	 * Returns the key used to store the objects in the database.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	abstract public function get_key(): string;

	/**
	 * Returns the storage medium of the store.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_storage_type(): string {
		return 'user-meta';
	}

	/**
	 * Returns the total number of entries stored for a given user.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   int|null    $user_id    The ID of the user to count the stored objects for.
	 *
	 * @return  int
	 */
	public function count( ?int $user_id = null ): int {
		$user_id = $this->parse_user_id( $user_id );
		return \count( $this->get_all( $user_id ) );
	}

	/**
	 * Checks whether an entry currently exists or not.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string      $entry_id       The identifier of the entry.
	 * @param   int|null    $user_id        The ID of the user to check the stored objects for.
	 *
	 * @return  bool
	 */
	public function has( string $entry_id, ?int $user_id = null ): bool {
		$user_id = $this->parse_user_id( $user_id );
		return isset( $this->get_all( $user_id )[ $entry_id ] );
	}

	// endregion

	// region CRUD

	/**
	 * Returns all the entries stored.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   int|null    $user_id        The ID of the user to retrieve the stored objects for.
	 *
	 * @return  StoreableInterface[]
	 */
	public function get_all( ?int $user_id = null ): array {
		$user_id = $this->parse_user_id( $user_id );
		return \get_user_meta( $user_id, $this->get_key(), true ) ?: array(); // phpcs:ignore
	}

	/**
	 * Returns an entry from the store.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string      $entry_id       The identifier of the entry.
	 * @param   int|null    $user_id        The ID of the user to retrieve the stored object for.
	 *
	 * @throws  NotFoundException   Thrown when the entry does not exist.
	 *
	 * @return  StoreableInterface
	 */
	public function get( string $entry_id, ?int $user_id = null ): StoreableInterface {
		$user_id = $this->parse_user_id( $user_id );

		if ( $this->has( $entry_id, $user_id ) ) {
			return $this->get_all( $user_id )[ $entry_id ];
		}

		throw new NotFoundException( \sprintf( 'Could not retrieve entry %1$s from user %2$s. Not found in store %3$s of type %4$s', $entry_id, $user_id, $this->get_id(), $this->get_storage_type() ) );
	}

	/**
	 * Adds an entry to the store.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   StoreableInterface  $storeable      Object to store.
	 * @param   int|null            $user_id        The ID of the user to add the object to.
	 *
	 * @throws  StoreException      Error while adding the entry.
	 */
	public function add( StoreableInterface $storeable, ?int $user_id = null ) {
		$user_id = $this->parse_user_id( $user_id );

		if ( $this->has( $storeable->get_id(), $user_id ) ) {
			throw new StoreException( \sprintf( 'Entry %1$s already exists in store %2$s of type %3$s for user %4$s', $storeable->get_id(), $this->get_id(), $this->get_storage_type(), $user_id ) );
		}

		$this->update( $storeable, $user_id );
	}

	/**
	 * Updates (or adds if it doesn't exist) an entry in the store.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   StoreableInterface  $storeable      Object to add or update.
	 * @param   int|null            $user_id        The ID of the user to add or update the object to.
	 *
	 * @return  bool
	 */
	public function update( StoreableInterface $storeable, ?int $user_id = null ): bool {
		$user_id = $this->parse_user_id( $user_id );

		return \update_user_meta(
			$user_id,
			$this->get_key(),
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
	 * @param   string      $entry_id       The identifier of the entry.
	 * @param   int|null    $user_id        The ID of the user to remove the stored object from.
	 *
	 * @throws  NotFoundException   Thrown when the entry does not exist.
	 *
	 * @return  bool
	 */
	public function remove( string $entry_id, ?int $user_id = null ): bool {
		$user_id = $this->parse_user_id( $user_id );

		if ( $this->has( $entry_id, $user_id ) ) {
			$stored_objects = $this->get_all( $user_id );

			unset( $stored_objects[ $entry_id ] );

			return empty( $stored_objects )
				? \delete_user_meta( $user_id, $this->get_key() )
				: \update_user_meta( $user_id, $this->get_key(), $stored_objects );
		}

		throw new NotFoundException( \sprintf( 'Could not delete entry %1$s from user %2$s. Not found in store %3$s of type %4$s', $entry_id, $user_id, $this->get_id(), $this->get_storage_type() ) );
	}

	// endregion

	// region HELPERS

	/**
	 * Ensures the user ID is set.
	 *
	 * @param   int|null    $user_id    The ID to parse.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  int
	 */
	protected function parse_user_id( ?int $user_id ): int {
		return $user_id ?? \get_current_user_id();
	}

	// endregion
}