<?php

namespace DeepWebSolutions\Framework\Utilities\Traits;

use DeepWebSolutions\Framework\Utilities\Interfaces\Resources\Pluginable;

/**
 * Functionality trait for dependent disablement of integration classes.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Utilities\Traits
 */
trait Plugin {
	// region FIELDS AND CONSTANTS

	/**
	 * Instance of the current plugin that the framework is bundled with.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     Pluginable
	 */
	protected Pluginable $plugin;

	// endregion

	// region GETTERS

	/**
	 * Returns the plugin instance that the framework is tied to.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  Pluginable
	 */
	public function get_plugin(): Pluginable {
		return $this->plugin;
	}

	// endregion

	// region SETTERS

	/**
	 * Sets the logger factory instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   Pluginable      $plugin     The plugin instance that the framework is tied to.
	 */
	public function set_plugin( Pluginable $plugin ): void {
		$this->plugin = $plugin;
	}

	// endregion
}
