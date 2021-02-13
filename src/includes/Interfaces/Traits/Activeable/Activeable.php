<?php

namespace DeepWebSolutions\Framework\Utilities\Interfaces\Traits\Activeable;

defined( 'ABSPATH' ) || exit;

/**
 * Abstract trait that other traits should use to denote that they want their own is_active logic called.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Utilities\Handlers\Traits\Activeable
 */
trait Activeable {
	/**
	 * Executed in the 'is_active' function of classes that use an inheriting trait.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	abstract public function is_active(): bool;
}
