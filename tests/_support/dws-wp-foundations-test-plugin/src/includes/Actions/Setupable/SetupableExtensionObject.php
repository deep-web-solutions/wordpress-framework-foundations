<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\Setupable;

use DeepWebSolutions\Framework\Foundations\Actions\Setupable\SetupFailureException;

\defined( 'ABSPATH' ) || exit;

/**
 * Class SetupableExtensionObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\Setupable
 */
class SetupableExtensionObject extends SetupableLocalObject {
	// region TRAITS

	use SetupExtensionTrait;

	// endregion

	// region FIELDS AND CONSTANTS

	/**
	 * Dummy extension setup result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     SetupFailureException|null
	 */
	protected ?SetupFailureException $setup_result_extension;

	// endregion

	// region MAGIC METHODS

	/**
	 * SetupableExtensionObject constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   SetupFailureException|null  $setup_result_local         Dummy local setup result.
	 * @param   SetupFailureException|null  $setup_result_extension     Dummy extension setup result.
	 */
	public function __construct( ?SetupFailureException $setup_result_local, ?SetupFailureException $setup_result_extension ) {
		parent::__construct( $setup_result_local );
		$this->setup_result_extension = $setup_result_extension;
	}

	// endregion

	// region INHERITED METHODS

	/**
	 * Returns the dummy extension setup result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  SetupFailureException|null
	 */
	protected function setup_extension(): ?SetupFailureException {
		return $this->setup_result_extension;
	}

	// endregion
}
