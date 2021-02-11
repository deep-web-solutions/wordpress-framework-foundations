<?php

namespace DeepWebSolutions\Framework\Utilities\Handlers\Traits;

use DeepWebSolutions\Framework\Helpers\WordPress\Traits\Hooks as HooksHelpers;
use DeepWebSolutions\Framework\Utilities\Handlers\HooksHandler;

defined( 'ABSPATH' ) || exit;

/**
 * Trait for working with the hooks handler.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Utilities\Handlers\Traits
 */
trait Hooks {
	use HooksHelpers;

	/**
	 * Using classes should define their hooks in here.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   HooksHandler    $hooks_handler      Instance of the hooks handler.
	 */
	abstract protected function register_hooks( HooksHandler $hooks_handler ): void;
}
