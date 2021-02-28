<?php

namespace DeepWebSolutions\Framework\Utilities\Traits\IsDisabled;

use DeepWebSolutions\Framework\Utilities\Interfaces\States\Traits\IsDisabled\IsDisabledExtensionTrait;

/**
 * Functionality trait for dependent disablement of integration classes.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Utilities\Traits\IsDisabled
 */
trait Integration {
	use IsDisabledExtensionTrait;

	/**
	 * Using class should define the logic for determining whether the integration is applicable or not in here.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  bool    True if NOT applicable, for otherwise.
	 */
	abstract public function is_disabled_integration(): bool;
}
