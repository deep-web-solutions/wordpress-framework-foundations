<?php

namespace DeepWebSolutions\Framework\Utilities\Interfaces\States\Traits\IsDisableable;

defined( 'ABSPATH' ) || exit;

/**
 * Abstract trait that classes should use to denote that they want their own is_disabled logic called.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Utilities\Interfaces\States\Traits\IsDisableable
 */
trait DisableLocal {
	/**
	 * Using classes should define their local is_disabled logic in here.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	abstract public function is_disabled_local(): bool;
}
