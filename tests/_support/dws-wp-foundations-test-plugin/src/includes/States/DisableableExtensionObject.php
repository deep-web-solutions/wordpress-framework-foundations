<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\States;

\defined( 'ABSPATH' ) || exit;

/**
 * Class DisableableExtensionObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\States
 */
class DisableableExtensionObject extends DisableableLocalObject {
	// region TRAITS

	use DisabledExtensionTrait;

	// endregion

	// region FIELDS AND CONSTANTS

	/**
	 * Dummy extension disablement state.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @var     bool
	 */
	protected bool $is_disabled_extension;

	// endregion

	// region MAGIC METHODS

	/**
	 * DisableableExtensionObject constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   bool    $is_disabled_local      Dummy local disablement state.
	 * @param   bool    $is_disabled_extension  Dummy extension disablement state.
	 */
	public function __construct( bool $is_disabled_local, bool $is_disabled_extension ) {
		parent::__construct( $is_disabled_local );
		$this->is_disabled_extension = $is_disabled_extension;
	}

	// endregion

	// region INHERITED METHODS

	/**
	 * Dummy extension disablement state.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  bool
	 */
	public function is_disabled_extension(): bool {
		return $this->is_disabled_extension;
	}

	// endregion
}
