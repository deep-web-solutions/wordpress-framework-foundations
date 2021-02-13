<?php

namespace DeepWebSolutions\Framework\Utilities\Traits\Disabled;

use DeepWebSolutions\Framework\Utilities\Interfaces\Traits\Disableable\Disableable;

/**
 * Functionality trait for dependent setup of integration functionalities.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Core\Traits\IsActive
 */
trait Integration {
	use Disableable {
		is_disabled as is_disabled_integration;
	}
}
