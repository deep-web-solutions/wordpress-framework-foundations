<?php

namespace DeepWebSolutions\Framework\Foundations\Storage\Stores;

use DeepWebSolutions\Framework\Foundations\Storage\AbstractStore;

\defined( 'ABSPATH' ) || exit;

/**
 * Reusable implementation of a basic options-table store.
 *
 * @since   1.0.0
 * @version 1.3.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Storage\Stores
 */
class OptionsStore extends AbstractStore {
	// region TRAITS

	use OptionsStoreTrait;

	// endregion

	// region FIELDS AND CONSTANTS

	/**
	 * The key used to store the objects in the database.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     string
	 */
	protected string $key;

	// endregion

	// region MAGIC METHODS

	/**
	 * OptionsStore constructor.
	 *
	 * @since   1.0.0
	 * @version 1.3.0
	 *
	 * @param   string  $storable_id    The ID of the store.
	 * @param   string  $key            The key used to store the objects in the database.
	 */
	public function __construct( string $storable_id, string $key ) {
		parent::__construct( $storable_id );
		$this->key = \sanitize_key( $key );
	}

	// endregion

	// region INHERITED METHODS

	/**
	 * {@inheritDoc}
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function get_key(): string {
		return $this->key;
	}

	// endregion
}
