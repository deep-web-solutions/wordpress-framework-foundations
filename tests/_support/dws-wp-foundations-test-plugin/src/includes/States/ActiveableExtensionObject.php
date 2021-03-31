<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\States;

\defined( 'ABSPATH' ) || exit;

/**
 * Class ActiveableExtensionObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\States
 */
class ActiveableExtensionObject extends ActiveableLocalObject {
	// region TRAITS

	use ActiveExtensionTrait;

	// endregion

	// region FIELDS AND CONSTANTS

	/**
	 * Dummy extension activation state.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @var     bool
	 */
	protected bool $is_active_extension;

	// endregion

	// region MAGIC METHODS

	/**
	 * ActiveableExtensionObject constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   bool    $is_active_local        Dummy local activation state.
	 * @param   bool    $is_active_extension    Dummy extension activation state.
	 */
	public function __construct( bool $is_active_local, bool $is_active_extension ) {
		parent::__construct( $is_active_local );
		$this->is_active_extension = $is_active_extension;
	}

	// endregion

	// region INHERITED METHODS

	/**
	 * Dummy extension activation state.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  bool
	 */
	public function is_active_extension(): bool {
		return $this->is_active_extension;
	}

	// endregion
}
