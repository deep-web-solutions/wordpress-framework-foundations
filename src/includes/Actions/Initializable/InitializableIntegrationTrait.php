<?php

namespace DeepWebSolutions\Framework\Foundations\Actions\Initializable;

\defined( 'ABSPATH' ) || exit;

/**
 * Abstract trait that other traits should use to denote that they want their initialization integration logic called
 * after a successful initialization.
 *
 * @since   1.2.0
 * @version 1.2.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Actions\Initializable
 */
trait InitializableIntegrationTrait {
	// region TRAITS

	use InitializableTrait;

	// endregion
}
