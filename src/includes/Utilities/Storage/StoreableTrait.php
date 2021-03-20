<?php

namespace DeepWebSolutions\Framework\Foundations\Utilities\Storage;

\defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of the storeable interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Utilities\Storage
 */
trait StoreableTrait {
	// region FIELDS AND CONSTANTS

	/**
	 * Type ID of the storeable instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     string
	 */
	protected string $storeable_id;

	// endregion

	// region GETTERS

	/**
	 * Returns the ID of the instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_id(): string {
		return $this->storeable_id;
	}

	// endregion
}
