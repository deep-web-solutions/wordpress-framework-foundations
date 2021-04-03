<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\Initializable;

use DeepWebSolutions\Framework\Foundations\Actions\Initializable\InitializationFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Initializable\InitializeLocalTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Initializable\Integrations\MaybeSetupOnInitializationTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Initializable\Integrations\SetupablesOnInitializationTrait;
use DeepWebSolutions\Framework\Foundations\Actions\InitializableInterface;
use DeepWebSolutions\Framework\Foundations\Actions\Setupable\SetupFailureException;
use DeepWebSolutions\Framework\Foundations\States\Activeable\ActiveLocalTrait;
use DeepWebSolutions\Framework\Foundations\States\ActiveableInterface;
use DeepWebSolutions\Framework\Foundations\States\Disableable\DisabledLocalTrait;
use DeepWebSolutions\Framework\Foundations\States\DisableableInterface;
use DeepWebSolutions\Framework\Tests\Foundations\Actions\Setupable\SetupableLocalObject;

\defined( 'ABSPATH' ) || exit;

/**
 * Class EnhancedInitializableObject
 *
 * @since   1.2.0
 * @version 1.2.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\Initializable
 */
class EnhancedInitializableObject extends SetupableLocalObject implements InitializableInterface, ActiveableInterface, DisableableInterface {
	// region TRAITS

	use ActiveLocalTrait;
	use DisabledLocalTrait;
	use SetupablesOnInitializationTrait;
	use MaybeSetupOnInitializationTrait;
	use InitializeLocalTrait;

	// endregion

	// region FIELDS AND CONSTANTS

	/**
	 * Dummy local initialization result.
	 *
	 * @since   1.2.0
	 * @version 1.2.0
	 *
	 * @access  protected
	 * @var     InitializationFailureException|null
	 */
	protected ?InitializationFailureException $initialization_result_local;

	/**
	 * Dummy local activation state.
	 *
	 * @since   1.2.0
	 * @version 1.2.0
	 *
	 * @var     bool
	 */
	protected bool $is_active_local;

	/**
	 * Dummy local disablement state.
	 *
	 * @since   1.2.0
	 * @version 1.2.0
	 *
	 * @var     bool
	 */
	protected bool $is_disabled_local;

	// endregion

	// region MAGIC METHODS

	/**
	 * EnhancedInitializableObject constructor.
	 *
	 * @since   1.2.0
	 * @version 1.2.0
	 *
	 * @param   InitializationFailureException|null     $initialization_result_local    Dummy local initialization result.
	 * @param   SetupFailureException|null              $setup_result_local             Dummy local setup result.
	 * @param   bool                                    $is_active_local                Dummy local activation state.
	 * @param   bool                                    $is_disabled_local              Dummy local disablement state.
	 */
	public function __construct( ?InitializationFailureException $initialization_result_local, ?SetupFailureException $setup_result_local, bool $is_active_local, bool $is_disabled_local ) {
		parent::__construct( $setup_result_local );
		$this->initialization_result_local = $initialization_result_local;

		$this->is_active_local   = $is_active_local;
		$this->is_disabled_local = $is_disabled_local;
	}

	// endregion

	// region INHERITED METHODS

	/**
	 * Returns the dummy local initialization result.
	 *
	 * @since   1.2.0
	 * @version 1.2.0
	 *
	 * @return  InitializationFailureException|null
	 */
	protected function initialize_local(): ?InitializationFailureException {
		return $this->initialization_result_local;
	}

	/**
	 * Dummy local activation state.
	 *
	 * @since   1.2.0
	 * @version 1.2.0
	 *
	 * @return  bool
	 */
	public function is_active_local(): bool {
		return $this->is_active_local;
	}

	/**
	 * Dummy local disablement state.
	 *
	 * @since   1.2.0
	 * @version 1.2.0
	 *
	 * @return  bool
	 */
	public function is_disabled_local(): bool {
		return $this->is_disabled_local;
	}

	// endregion
}
