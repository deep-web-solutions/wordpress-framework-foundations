<?php

namespace DeepWebSolutions\Framework\Utilities\Handlers\Traits;

use DeepWebSolutions\Framework\Utilities\Handlers\ShortcodesHandler;

defined( 'ABSPATH' ) || exit;

/**
 * Trait for working with the shortcodes handler.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Utilities\Handlers\Traits
 */
trait Shortcodes {
	/**
	 * Using classes should define their shortcodes in here.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   ShortcodesHandler   $shortcodes_handler     Instance of the shortcodes handler.
	 */
	abstract protected function register_shortcodes( ShortcodesHandler $shortcodes_handler ): void;
}
