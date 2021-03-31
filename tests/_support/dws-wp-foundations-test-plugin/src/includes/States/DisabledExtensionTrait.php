<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\States;

use DeepWebSolutions\Framework\Foundations\States\Disableable\DisableableExtensionTrait;
use DeepWebSolutions\Framework\Foundations\States\Disableable\DisableableLocalTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Trait DisabledExtensionTrait.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\States
 */
trait DisabledExtensionTrait {
	// region TRAITS

	use DisableableExtensionTrait;
	use DisableableLocalTrait;

	// endregion

	// region METHODS

	/**
	 * Dummy disabled state extension method.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  bool
	 */
	abstract public function is_disabled_extension(): bool;

	// endregion
}