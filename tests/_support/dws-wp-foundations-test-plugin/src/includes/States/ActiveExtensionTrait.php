<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\States;

use DeepWebSolutions\Framework\Foundations\States\Activeable\ActiveableExtensionTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Trait ActiveExtensionTrait.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\States
 */
trait ActiveExtensionTrait {
	// region TRAITS

	use ActiveableExtensionTrait;

	// endregion

	// region METHODS

	/**
	 * Dummy active state extension method.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  bool
	 */
	abstract public function is_active_extension(): bool;

	// endregion

}