<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Hierarchy;

use DeepWebSolutions\Framework\Foundations\Actions\Initializable\InitializationFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Initializable\InitializeLocalTrait;
use DeepWebSolutions\Framework\Foundations\Actions\InitializableInterface;
use DeepWebSolutions\Framework\Foundations\Actions\Setupable\SetupLocalTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Setupable\SetupFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\SetupableInterface;
use DeepWebSolutions\Framework\Foundations\Hierarchy\Actions\InitializeChildrenTrait;
use DeepWebSolutions\Framework\Foundations\Hierarchy\Actions\SetupChildrenTrait;
use DeepWebSolutions\Framework\Foundations\Hierarchy\States\ActiveParentTrait;
use DeepWebSolutions\Framework\Foundations\Hierarchy\States\DisabledParentTrait;
use DeepWebSolutions\Framework\Foundations\States\Activeable\ActiveLocalTrait;
use DeepWebSolutions\Framework\Foundations\States\ActiveableInterface;
use DeepWebSolutions\Framework\Foundations\States\Disableable\DisabledLocalTrait;
use DeepWebSolutions\Framework\Foundations\States\DisableableInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Class EnhancedNodeObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Hierarchy
 */
class EnhancedNodeObject extends NodeObject implements ActiveableInterface, DisableableInterface, InitializableInterface, SetupableInterface {
	// region TRAITS

	use ActiveLocalTrait;
	use ActiveParentTrait;

	use DisabledLocalTrait;
	use DisabledParentTrait;

	use InitializeLocalTrait;
	use InitializeChildrenTrait;

	use SetupLocalTrait;
	use SetupChildrenTrait;

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
	 * Dummy local initialization result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     InitializationFailureException|null
	 */
	protected ?InitializationFailureException $initialization_result_local;

	/**
	 * Dummy local setup result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     SetupFailureException|null
	 */
	protected ?SetupFailureException $setup_result_local;

	// endregion

	// region MAGIC METHODS

	/**
	 * EnhancedNodeObject constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   bool                                    $is_active_local                Dummy local activation state.
	 * @param   bool                                    $is_disabled_local              Dummy local disablement state.
	 * @param   InitializationFailureException|null     $initialization_result_local    Dummy local initialization result.
	 * @param   SetupFailureException|null              $setup_result_local             Dummy local setup result.
	 */
	public function __construct( bool $is_active_local, bool $is_disabled_local, ?InitializationFailureException $initialization_result_local, ?SetupFailureException $setup_result_local ) {
		$this->is_active_local   = $is_active_local;
		$this->is_disabled_local = $is_disabled_local;

		$this->initialization_result_local = $initialization_result_local;
		$this->setup_result_local          = $setup_result_local;
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
	 * Returns the dummy local initialization result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  InitializationFailureException|null
	 */
	protected function initialize_local(): ?InitializationFailureException {
		return $this->initialization_result_local;
	}

	/**
	 * Returns the dummy local setup result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  SetupFailureException|null
	 */
	protected function setup_local(): ?SetupFailureException {
		return $this->setup_result_local;
	}

	// endregion
}
