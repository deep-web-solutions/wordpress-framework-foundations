<?php

namespace DeepWebSolutions\Framework\Utilities\Interfaces\Traits;

use DeepWebSolutions\Framework\Utilities\Interfaces\Pluginable;

defined( 'ABSPATH' ) || exit;

/**
 * Trait for working with the Identifiable interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Utilities\Handlers\Traits
 */
trait Identity {
	// region FIELDS AND CONSTANTS

	/**
	 * The instance of the plugin to which this object "belongs".
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     Pluginable
	 */
	protected Pluginable $plugin;

	/**
	 * The unique persistent ID of the using class instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     string
	 */
	protected string $instance_id;

	/**
	 * The public name of the using class instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     string
	 */
	protected string $instance_public_name;

	// endregion

	// region GETTERS

	/**
	 * Gets the plugin instance of the framework.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  Pluginable
	 */
	public function get_plugin(): Pluginable {
		return $this->plugin;
	}

	/**
	 * Gets the ID of the using class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_instance_id(): string {
		return $this->instance_id;
	}

	/**
	 * Gets the public name of the using class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_instance_public_name(): string {
		return $this->instance_public_name;
	}

	// endregion
}
