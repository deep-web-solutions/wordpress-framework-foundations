<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\RunnableResettable;

use DeepWebSolutions\Framework\Foundations\Actions\Runnable\RunFailureException;

\defined( 'ABSPATH' ) || exit;

/**
 * Class RunnableExtensionObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\RunnableResettable
 */
class RunnableExtensionObject extends RunnableLocalObject {
	// region TRAITS

	use RunExtensionTrait;

	// endregion

	// region FIELDS AND CONSTANTS

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

	// endregion

	// region MAGIC METHODS

	/**
	 * RunnableExtensionObject constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   RunFailureException|null    $run_result_local       Dummy local reset result.
	 * @param   RunFailureException|null    $run_result_exception   Dummy extension run result.
	 */
	public function __construct( ?RunFailureException $run_result_local, ?RunFailureException $run_result_exception ) {
		parent::__construct( $run_result_local );
		$this->run_result_extension = $run_result_exception;
	}

	// endregion

	// region INHERITED METHODS

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

	// endregion
}