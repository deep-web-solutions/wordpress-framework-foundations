<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\Initializable;

use DeepWebSolutions\Framework\Foundations\Actions\Initializable\InitializationFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Initializable\InitializeLocalTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Initializable\Integrations\SetupablesOnInitializationTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Initializable\Integrations\SetupOnInitializationTrait;
use DeepWebSolutions\Framework\Foundations\Actions\InitializableInterface;
use DeepWebSolutions\Framework\Foundations\Actions\Setupable\SetupFailureException;
use DeepWebSolutions\Framework\Tests\Foundations\Actions\Setupable\SetupableLocalObject;

\defined( 'ABSPATH' ) || exit;

/**
 * Class InitializableIntegrationsObject
 *
 * @since   1.2.0
 * @version 1.2.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\Initializable
 */
class InitializableIntegrationsObject extends SetupableLocalObject implements InitializableInterface {
	// region TRAITS

	use SetupablesOnInitializationTrait;
	use SetupOnInitializationTrait;
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

	// endregion

	// region MAGIC METHODS

	/**
	 * InitializableIntegrationsObject constructor.
	 *
	 * @since   1.2.0
	 * @version 1.2.0
	 *
	 * @param   InitializationFailureException|null     $initialization_result_local    Dummy local initialization result.
	 * @param   SetupFailureException|null              $setup_result_local             Dummy local setup result.
	 */
	public function __construct( ?InitializationFailureException $initialization_result_local, ?SetupFailureException $setup_result_local ) {
		parent::__construct( $setup_result_local );
		$this->initialization_result_local = $initialization_result_local;
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

	// endregion
}
