<?php

namespace DeepWebSolutions\Framework\Utilities\Handlers\Traits;

use DeepWebSolutions\Framework\Utilities\Handlers\AdminNoticesHandler;

defined( 'ABSPATH' ) || exit;

/**
 * Trait for working with the admin notices handler.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Utilities\Handlers\Traits
 */
trait AdminNotices {
	/**
	 * Using classes should define their admin notices in here.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   AdminNoticesHandler     $admin_notices_handler      Instance of the admin notices handler.
	 */
	abstract protected function register_admin_notices( AdminNoticesHandler $admin_notices_handler ): void;
}
