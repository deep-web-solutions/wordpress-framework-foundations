<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\States;

use DeepWebSolutions\Framework\Foundations\States\Activeable\ActiveableLocalTrait;
use DeepWebSolutions\Framework\Foundations\States\Activeable\ActiveableTrait;
use DeepWebSolutions\Framework\Foundations\States\ActiveableInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Class ActiveableObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\States
 */
class ActiveableObject implements ActiveableInterface {
	// region TRAITS

	use ActiveableTrait;
	use ActiveableLocalTrait;

	// endregion

	// region FIELDS AND CONSTANTS

	/**
	 * Dummy local activation state.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @var     bool
	 */
	protected bool $is_active_local;

	// endregion

	// region MAGIC METHODS

	/**
	 * ActiveableObject constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   bool    $is_active_local    Dummy local activation state.
	 */
	public function __construct( bool $is_active_local ) {
		$this->is_active_local = $is_active_local;
	}

	// endregion

	// region INHERITED METHODS

	/**
	 * Dummy local activation state.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  bool
	 */
	public function is_active_local(): bool {
		return $this->is_active_local;
	}

	// endregion
}
