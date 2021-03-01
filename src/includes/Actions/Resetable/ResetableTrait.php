<?php

namespace DeepWebSolutions\Framework\Foundations\Actions\Runnable;

defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of the runnable interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Actions\Runnable
 */
trait RunnableTrait {
	// region FIELDS AND CONSTANTS

	/**
	 * The result of the run operation. Null if successful.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     RunFailureException|null
	 */
	protected ?RunFailureException $run_result;

	/**
	 * Whether the using instance is ran or not. Null if not decided yet.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     bool|null
	 */
	protected ?bool $is_ran = null;

	// endregion

	// region GETTERS

	/**
	 * Returns the result of the run operation.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  RunFailureException|null
	 */
	public function get_run_result(): ?RunFailureException {
		return $this->run_result;
	}

	/**
	 * Returns whether the using instance is ran or not. Null if not decided yet.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  bool|null
	 */
	public function is_ran(): ?bool {
		return $this->is_ran;
	}

	// endregion

	// region METHODS

	/**
	 * Execute the run logic of the implementing class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	abstract public function run(): ?RunFailureException;

	// endregion
}
