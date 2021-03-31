<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\States;

use DeepWebSolutions\Framework\Foundations\States\Disableable\DisableableLocalTrait;
use DeepWebSolutions\Framework\Foundations\States\Disableable\DisableableTrait;
use DeepWebSolutions\Framework\Foundations\States\DisableableInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Class ActiveableObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\States
 */
class DisableableObject implements DisableableInterface {
	// region TRAITS

	use DisableableTrait;
	use DisableableLocalTrait;

	// endregion

	// region FIELDS AND CONSTANTS

	/**
	 * Dummy local disablement state.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @var     bool
	 */
	protected bool $is_disabled_local;

	// endregion

	// region MAGIC METHODS

	/**
	 * DisableableObject constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   bool    $is_disabled_local      Dummy local disablement state.
	 */
	public function __construct( bool $is_disabled_local ) {
		$this->is_disabled_local = $is_disabled_local;
	}

	// endregion

	// region INHERITED METHODS

	/**
	 * Dummy local disablement state.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  bool
	 */
	public function is_disabled_local(): bool {
		return $this->is_disabled_local;
	}

	// endregion
}
