<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\States;

use DeepWebSolutions\Framework\Foundations\States\Activeable\ActiveableLocalTrait;
use DeepWebSolutions\Framework\Foundations\States\Activeable\ActiveableTrait;
use DeepWebSolutions\Framework\Foundations\States\ActiveableInterface;
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
class FullStateObject implements ActiveableInterface, DisableableInterface {
	// region TRAITS

	use ActiveableTrait;
	use ActiveableLocalTrait;
	use ActiveExtensionTrait;

	use DisableableTrait;
	use DisableableLocalTrait;
	use DisabledExtensionTrait;

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

	/**
	 * Dummy local disablement state.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @var     bool
	 */
	protected bool $is_disabled_local;

	/**
	 * Dummy extension activation state.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @var     bool
	 */
	protected bool $is_active_extension;

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
	 * FullStateObject constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   bool    $is_active_local            Dummy local activation state.
	 * @param   bool    $is_disabled_local          Dummy local disablement state.
	 * @param   bool    $is_active_extension        Dummy extension activation state.
	 * @param   bool    $is_disabled_extension      Dummy extension disablement state.
	 */
	public function __construct( bool $is_active_local, bool $is_disabled_local, bool $is_active_extension, bool $is_disabled_extension ) {
		$this->is_active_local       = $is_active_local;
		$this->is_disabled_local     = $is_disabled_local;
		$this->is_active_extension   = $is_active_extension;
		$this->is_disabled_extension = $is_disabled_extension;
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
