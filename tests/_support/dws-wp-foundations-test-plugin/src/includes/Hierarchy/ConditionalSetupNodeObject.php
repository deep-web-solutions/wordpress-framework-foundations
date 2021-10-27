<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Hierarchy;

use DeepWebSolutions\Framework\Foundations\Actions\Setupable\SetupLocalTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Setupable\SetupFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\SetupableInterface;
use DeepWebSolutions\Framework\Foundations\Hierarchy\Actions\MaybeSetupChildrenTrait;
use DeepWebSolutions\Framework\Foundations\Hierarchy\States\ActiveParentTrait;
use DeepWebSolutions\Framework\Foundations\Hierarchy\States\DisabledParentTrait;
use DeepWebSolutions\Framework\Foundations\States\Activeable\ActiveLocalTrait;
use DeepWebSolutions\Framework\Foundations\States\ActiveableInterface;
use DeepWebSolutions\Framework\Foundations\States\Disableable\DisabledLocalTrait;
use DeepWebSolutions\Framework\Foundations\States\DisableableInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Class ConditionalSetupNodeObject
 *
 * @since   1.2.1
 * @version 1.2.1
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Hierarchy
 */
class ConditionalSetupNodeObject extends NodeObject implements ActiveableInterface, DisableableInterface, SetupableInterface {
	// region TRAITS

	use ActiveLocalTrait;
	use ActiveParentTrait;

	use DisabledLocalTrait;
	use DisabledParentTrait;

	use SetupLocalTrait;
	use MaybeSetupChildrenTrait;

	// endregion

	// region FIELDS AND CONSTANTS

	/**
	 * Dummy local activation state.
	 *
	 * @since   1.2.1
	 * @version 1.2.1
	 *
	 * @var     bool
	 */
	protected bool $is_active_local;

	/**
	 * Dummy local disablement state.
	 *
	 * @since   1.2.1
	 * @version 1.2.1
	 *
	 * @var     bool
	 */
	protected bool $is_disabled_local;

	/**
	 * Dummy local setup result.
	 *
	 * @since   1.2.1
	 * @version 1.2.1
	 *
	 * @access  protected
	 * @var     SetupFailureException|null
	 */
	protected ?SetupFailureException $setup_result_local;

	// endregion

	// region MAGIC METHODS

	/**
	 * ConditionalSetupNodeObject constructor.
	 *
	 * @since   1.2.1
	 * @version 1.2.1
	 *
	 * @param   bool                                    $is_active_local                Dummy local activation state.
	 * @param   bool                                    $is_disabled_local              Dummy local disablement state.
	 * @param   SetupFailureException|null              $setup_result_local             Dummy local setup result.
	 */
	public function __construct( bool $is_active_local, bool $is_disabled_local, ?SetupFailureException $setup_result_local ) {
		$this->is_active_local    = $is_active_local;
		$this->is_disabled_local  = $is_disabled_local;
		$this->setup_result_local = $setup_result_local;
	}

	// endregion

	// region INHERITED METHODS

	/**
	 * Dummy local activation state.
	 *
	 * @since   1.2.1
	 * @version 1.2.1
	 *
	 * @return  bool
	 */
	public function is_active_local(): bool {
		return $this->is_active_local;
	}

	/**
	 * Dummy local disablement state.
	 *
	 * @since   1.2.1
	 * @version 1.2.1
	 *
	 * @return  bool
	 */
	public function is_disabled_local(): bool {
		return $this->is_disabled_local;
	}

	/**
	 * Returns the dummy local setup result.
	 *
	 * @since   1.2.1
	 * @version 1.2.1
	 *
	 * @return  SetupFailureException|null
	 */
	protected function setup_local(): ?SetupFailureException {
		return $this->setup_result_local;
	}

	// endregion
}
