<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\Initializable;

use DeepWebSolutions\Framework\Foundations\Actions\Initializable\InitializeLocalTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Initializable\InitializationFailureException;

\defined( 'ABSPATH' ) || exit;

/**
 * Class InitializableLocalObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\Initializable
 */
class InitializableLocalObject extends InitializableObject {
	// region TRAITS

	use InitializeLocalTrait;

	// endregion

	// region FIELDS AND CONSTANTS

	/**
	 * Dummy local initialization result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     InitializationFailureException|null
	 */
	protected ?InitializationFailureException $initialization_result_local;

	// endregion

	// region MAGIC METHODS

	/**
	 * InitializableLocalObject constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   InitializationFailureException|null     $initialization_result_local    Dummy local initialization result.
	 */
	public function __construct( ?InitializationFailureException $initialization_result_local ) {
		$this->initialization_result_local = $initialization_result_local;
	}

	// endregion

	// region INHERITED METHODS

	/**
	 * Returns the dummy local initialization result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  InitializationFailureException|null
	 */
	protected function initialize_local(): ?InitializationFailureException {
		return $this->initialization_result_local;
	}

	// endregion
}