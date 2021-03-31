<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\RunnableResettable;

use DeepWebSolutions\Framework\Foundations\Actions\Resettable\ResetFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Resettable\ResetLocalTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Class ResettableLocalObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\RunnableResettable
 */
class ResettableLocalObject extends ResettableObject {
	// region TRAITS

	use ResetLocalTrait;

	// endregion

	// region FIELDS AND CONSTANTS

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

	// endregion

	// region MAGIC METHODS

	/**
	 * ResettableLocalObject constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   ResetFailureException|null  $reset_result_local     Dummy local reset result.
	 */
	public function __construct( ?ResetFailureException $reset_result_local ) {
		$this->reset_result_local = $reset_result_local;
	}

	// endregion

	// region INHERITED METHODS

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

	// endregion
}
