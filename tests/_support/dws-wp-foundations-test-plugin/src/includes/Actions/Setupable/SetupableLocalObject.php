<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\Setupable;

use DeepWebSolutions\Framework\Foundations\Actions\Setupable\SetupableLocalTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Setupable\SetupFailureException;

\defined( 'ABSPATH' ) || exit;

/**
 * Class SetupableLocalObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\Setupable
 */
class SetupableLocalObject extends SetupableObject {
	// region TRAITS

	use SetupableLocalTrait;

	// endregion

	// region FIELDS AND CONSTANTS

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
	 * SetupableLocalObject constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   SetupFailureException|null  $setup_result_local     Dummy local setup result.
	 */
	public function __construct( ?SetupFailureException $setup_result_local ) {
		$this->setup_result_local = $setup_result_local;
	}

	// endregion

	// region INHERITED METHODS

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