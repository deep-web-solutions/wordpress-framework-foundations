<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\RunnableResettable;

use DeepWebSolutions\Framework\Foundations\Actions\Resettable\ResetFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Resettable\ResetLocalTrait;
use DeepWebSolutions\Framework\Foundations\Actions\ResettableInterface;
use DeepWebSolutions\Framework\Foundations\Actions\Runnable\RunFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Runnable\RunLocalTrait;
use DeepWebSolutions\Framework\Foundations\Actions\RunnableInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Class RunnableResettableExtensionObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\RunnableResettable
 */
class RunnableResettableExtensionObject implements RunnableInterface, ResettableInterface {
	// region TRAITS

	use ResetExtensionTrait;
	use RunExtensionTrait;

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

	/**
	 * Dummy local reset result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     ResetFailureException|null
	 */
	protected ?ResetFailureException $reset_result_local;

	/**
	 * Dummy extension run result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     RunFailureException|null
	 */
	protected ?RunFailureException $run_result_extension;

	/**
	 * Dummy extension reset result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     ResetFailureException|null
	 */
	protected ?ResetFailureException $reset_result_extension;

	// endregion

	// region MAGIC METHODS

	/**
	 * RunnableResettableExtensionObject constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   RunFailureException|null    $run_result_local           Dummy local run result.
	 * @param   ResetFailureException|null  $reset_result_local         Dummy local reset result.
	 * @param   RunFailureException|null    $run_result_extension       Dummy extension run result.
	 * @param   ResetFailureException|null  $reset_result_extension     Dummy extension reset result.
	 */
	public function __construct( ?RunFailureException $run_result_local, ?ResetFailureException $reset_result_local, ?RunFailureException $run_result_extension, ?ResetFailureException $reset_result_extension ) {
		$this->run_result_local   = $run_result_local;
		$this->reset_result_local = $reset_result_local;

		$this->run_result_extension   = $run_result_extension;
		$this->reset_result_extension = $reset_result_extension;
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

	/**
	 * Returns the dummy local reset result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  ResetFailureException|null
	 */
	protected function reset_local(): ?ResetFailureException {
		return $this->reset_result_local;
	}

	/**
	 * Returns the dummy extension run result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  RunFailureException|null
	 */
	protected function run_extension(): ?RunFailureException {
		return $this->run_result_extension;
	}

	/**
	 * Returns the dummy extension reset result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  ResetFailureException|null
	 */
	protected function reset_extension(): ?ResetFailureException {
		return $this->reset_result_extension;
	}

	// endregion
}
