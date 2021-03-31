<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\Initializable;

use DeepWebSolutions\Framework\Foundations\Actions\Initializable\InitializableExtensionTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Initializable\InitializableLocalTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Initializable\InitializationFailureException;

\defined( 'ABSPATH' ) || exit;

/**
 * Trait InitializeExtensionTrait
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\Initializable
 */
trait InitializeExtensionTrait {
	// region TRAITS

	use InitializableExtensionTrait;
	use InitializableLocalTrait;

	// endregion

	// region METHODS

	/**
	 * Extension initialization logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  InitializationFailureException|null
	 */
	abstract function initialize_extension(): ?InitializationFailureException;

	// endregion
}
