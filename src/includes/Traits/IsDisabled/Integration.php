<?php

namespace DeepWebSolutions\Framework\Utilities\Traits\IsDisabled;

use DeepWebSolutions\Framework\Utilities\Interfaces\States\Traits\IsDisableable\Disableable;

/**
 * Functionality trait for dependent disablement of integration classes.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Utilities\Traits\IsDisabled
 */
trait Integration {
	use Disableable {
		is_disabled as is_disabled_integration;
	}
}
