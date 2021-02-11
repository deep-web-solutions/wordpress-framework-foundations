<?php

namespace DeepWebSolutions\Framework\Utilities\Interfaces\Traits;

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

	// region SETTERS

	/**
	 * Using classes should use this to set a unique persistent ID of the using class instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $instance_id    The value to be set.
	 */
	abstract public function set_instance_id( string $instance_id ): void;

	/**
	 * Using classes should use this to set the public name of the using class instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $instance_public_name   The value to be set.
	 */
	abstract public function set_instance_public_name( string $instance_public_name ): void;

	// endregion
}
