<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\Setupable;

use DeepWebSolutions\Framework\Foundations\Actions\Setupable\SetupableExtensionTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Setupable\SetupLocalTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Setupable\SetupFailureException;

\defined( 'ABSPATH' ) || exit;

/**
 * Trait SetupExtensionTrait
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\Setupable
 */
trait SetupExtensionTrait {
	// region TRAITS

	use SetupableExtensionTrait;
	use SetupLocalTrait;

	// endregion

	// region METHODS

	/**
	 * Extension setup logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  SetupFailureException|null
	 */
	abstract function setup_extension(): ?SetupFailureException;

	// endregion
}
