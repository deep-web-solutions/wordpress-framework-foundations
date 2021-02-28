<?php

namespace DeepWebSolutions\Framework\Utilities\Handlers\Traits;

use DeepWebSolutions\Framework\Utilities\Handlers\ShortcodesHandler;

defined( 'ABSPATH' ) || exit;

/**
 * Trait for working with the shortcodes handler.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Utilities\Handlers\Traits
 */
trait Shortcodes {
	// region FIELDS AND CONSTANTS

	/**
	 * Shortcodes handler for registering shortcodes.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     ShortcodesHandler
	 */
	protected ShortcodesHandler $shortcodes_handler;

	// endregion

	// region GETTERS

	/**
	 * Gets the shortcodes handler instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  ShortcodesHandler
	 */
	protected function get_shortcodes_handler(): ShortcodesHandler {
		return $this->shortcodes_handler;
	}

	// endregion

	// region SETTERS

	/**
	 * Sets the shortcodes handler.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   ShortcodesHandler     $shortcodes_handler       Instance of the shortcodes handler.
	 */
	public function set_shortcodes_handler( ShortcodesHandler $shortcodes_handler ): void {
		$this->shortcodes_handler = $shortcodes_handler;
	}

	// endregion

	// region METHODS

	/**
	 * Using classes should define their shortcodes in here.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   ShortcodesHandler   $shortcodes_handler     Instance of the shortcodes handler.
	 */
	abstract protected function register_shortcodes( ShortcodesHandler $shortcodes_handler ): void;

	// endregion
}
