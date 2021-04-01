<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\RunnableResettable;

use DeepWebSolutions\Framework\Foundations\Actions\Resettable\ResetFailureException;

\defined( 'ABSPATH' ) || exit;

/**
 * Class ResettableExtensionObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\RunnableResettable
 */
class ResettableExtensionObject extends ResettableLocalObject {
	// region TRAITS

	use ResetExtensionTrait;

	// endregion

	// region FIELDS AND CONSTANTS

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
	 * ResettableExtensionObject constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   ResetFailureException|null      $reset_result_local         Dummy local reset result.
	 * @param   ResetFailureException|null      $reset_result_exception     Dummy extension reset result.
	 */
	public function __construct( ?ResetFailureException $reset_result_local, ?ResetFailureException $reset_result_exception ) {
		parent::__construct( $reset_result_local );
		$this->reset_result_extension = $reset_result_exception;
	}

	// endregion

	// region INHERITED METHODS

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
