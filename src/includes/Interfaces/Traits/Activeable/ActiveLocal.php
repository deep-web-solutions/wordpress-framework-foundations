<?php

namespace DeepWebSolutions\Framework\Utilities\Interfaces\Traits\Activeable;

defined( 'ABSPATH' ) || exit;

/**
 * Abstract trait that classes should use to denote that they want their own is_active logic called.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Utilities\Handlers\Traits\Activeable
 */
trait ActiveLocal {
	/**
	 * Using classes should define their local is_active logic in here.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	abstract public function is_active_local(): bool;
}
