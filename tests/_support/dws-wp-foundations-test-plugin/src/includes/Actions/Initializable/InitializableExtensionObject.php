<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\Initializable;

use DeepWebSolutions\Framework\Foundations\Actions\Initializable\InitializationFailureException;

\defined( 'ABSPATH' ) || exit;

/**
 * Class InitializableExtensionObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\Initializable
 */
class InitializableExtensionObject extends InitializableLocalObject {
	// region TRAITS

	use InitializeExtensionTrait;

	// endregion

	// region FIELDS AND CONSTANTS

	/**
	 * Dummy extension initialization result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     InitializationFailureException|null
	 */
	protected ?InitializationFailureException $initialization_result_extension;

	// endregion

	// region MAGIC METHODS

	/**
	 * InitializableExtensionObject constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   InitializationFailureException|null     $initialization_result_local        Dummy local initialization result.
	 * @param   InitializationFailureException|null     $initialization_result_extension    Dummy extension initialization result.
	 */
	public function __construct( ?InitializationFailureException $initialization_result_local, ?InitializationFailureException $initialization_result_extension ) {
		parent::__construct( $initialization_result_local );
		$this->initialization_result_extension = $initialization_result_extension;
	}

	// endregion

	// region INHERITED METHODS

	/**
	 * Returns the dummy extension initialization result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  InitializationFailureException|null
	 */
	protected function initialize_extension(): ?InitializationFailureException {
		return $this->initialization_result_extension;
	}

	// endregion
}