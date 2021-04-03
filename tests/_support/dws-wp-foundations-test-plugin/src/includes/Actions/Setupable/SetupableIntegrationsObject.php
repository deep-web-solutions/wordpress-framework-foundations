<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\Setupable;

use DeepWebSolutions\Framework\Foundations\Actions\Runnable\RunFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Setupable\Integrations\RunnablesOnSetupTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Setupable\Integrations\RunOnSetupTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Setupable\SetupFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Setupable\SetupLocalTrait;
use DeepWebSolutions\Framework\Foundations\Actions\SetupableInterface;
use DeepWebSolutions\Framework\Tests\Foundations\Actions\RunnableResettable\RunnableLocalObject;

\defined( 'ABSPATH' ) || exit;

/**
 * Class SetupableIntegrationsObject
 *
 * @since   1.2.0
 * @version 1.2.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\Setupable
 */
class SetupableIntegrationsObject extends RunnableLocalObject implements SetupableInterface {
	// region TRAITS

	use RunnablesOnSetupTrait;
	use RunOnSetupTrait;
	use SetupLocalTrait;

	// endregion

	// region FIELDS AND CONSTANTS

	/**
	 * Dummy local setup result.
	 *
	 * @since   1.2.0
	 * @version 1.2.0
	 *
	 * @access  protected
	 * @var     SetupFailureException|null
	 */
	protected ?SetupFailureException $setup_result_local;

	// endregion

	// region MAGIC METHODS

	/**
	 * SetupableIntegrationsObject constructor.
	 *
	 * @since   1.2.0
	 * @version 1.2.0
	 *
	 * @param   SetupFailureException|null  $setup_result_local     Dummy local setup result.
	 * @param   RunFailureException|null    $run_result_local       Dummy local run result.
	 */
	public function __construct( ?SetupFailureException $setup_result_local, ?RunFailureException $run_result_local ) {
		parent::__construct( $run_result_local );
		$this->setup_result_local = $setup_result_local;
	}

	// endregion

	// region INHERITED METHODS

	/**
	 * Returns the dummy local setup result.
	 *
	 * @since   1.2.0
	 * @version 1.2.0
	 *
	 * @return  SetupFailureException|null
	 */
	protected function setup_local(): ?SetupFailureException {
		return $this->setup_result_local;
	}

	// endregion
}
