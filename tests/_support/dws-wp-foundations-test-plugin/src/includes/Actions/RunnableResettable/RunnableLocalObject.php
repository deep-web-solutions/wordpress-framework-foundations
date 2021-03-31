<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\RunnableResettable;

use DeepWebSolutions\Framework\Foundations\Actions\Runnable\RunFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Runnable\RunnableLocalTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Class RunnableLocalObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\RunnableResettable
 */
class RunnableLocalObject extends RunnableObject {
	// region TRAITS

	use RunnableLocalTrait;

	// endregion

	// region FIELDS AND CONSTANTS

	/**
	 * Dummy local run result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     RunFailureException|null
	 */
	protected ?RunFailureException $run_result_local;

	// endregion

	// region MAGIC METHODS

	/**
	 * RunnableLocalObject constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   RunFailureException|null    $run_result_local   Dummy local run result.
	 */
	public function __construct( ?RunFailureException $run_result_local ) {
		$this->run_result_local = $run_result_local;
	}

	// endregion

	// region INHERITED METHODS

	/**
	 * Returns the dummy local run result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  RunFailureException|null
	 */
	protected function run_local(): ?RunFailureException {
		return $this->run_result_local;
	}

	// endregion
}
