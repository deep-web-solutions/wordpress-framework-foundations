<?php

namespace DeepWebSolutions\Framework\Utilities\Handlers\Traits;

use DeepWebSolutions\Framework\Helpers\WordPress\Traits\Hooks as HooksHelpers;
use DeepWebSolutions\Framework\Utilities\Handlers\HooksHandler;
use DeepWebSolutions\Framework\Utilities\Interfaces\Resources\Identifiable;

defined( 'ABSPATH' ) || exit;

/**
 * Trait for working with the hooks handler.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Utilities\Handlers\Traits
 */
trait Hooks {
	use HooksHelpers {
		get_hook_name as get_hook_name_helpers;
	}

	// region FIELDS AND CONSTANTS

	/**
	 * Hooks handler for registering filters and actions.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     HooksHandler
	 */
	protected HooksHandler $hooks_handler;

	// endregion

	// region GETTERS

	/**
	 * Gets the hooks handler instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  HooksHandler
	 */
	protected function get_hooks_handler(): HooksHandler {
		return $this->hooks_handler;
	}

	// endregion

	// region SETTERS

	/**
	 * Sets the hooks handler.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   HooksHandler     $hooks_handler     Instance of the hooks handler.
	 */
	public function set_hooks_handler( HooksHandler $hooks_handler ): void {
		$this->hooks_handler = $hooks_handler;
	}

	// endregion

	// region METHODS

	/**
	 * Using classes should define their hooks in here.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   HooksHandler    $hooks_handler      Instance of the hooks handler.
	 */
	abstract protected function register_hooks( HooksHandler $hooks_handler ): void;

	// endregion

	// region HELPERS

	/**
	 * Returns a meaningful, hopefully unique, name for an internal hook.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @see     HooksHelpers::get_hook_name()
	 *
	 * @param   string  $name       The actual descriptor of the hook's purpose.
	 * @param   array   $extra      Further descriptor of the hook's purpose.
	 * @param   string  $root       Prepended to all hooks inside the same class.
	 *
	 * @return  string
	 */
	public function get_hook_name( string $name, array $extra = array(), string $root = '' ): string {
		if ( $this instanceof Identifiable ) {
			return $this->get_hook_name_helpers(
				$name,
				$extra,
				$this->get_plugin()->get_plugin_slug() . '_' . ( $root ?: $this->get_instance_public_name() ) // phpcs:ignore
			);
		}

		return $this->get_hook_name_helpers( $name, $extra, $root );
	}

	// endregion
}
