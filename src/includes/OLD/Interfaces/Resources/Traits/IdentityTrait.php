<?php

namespace DeepWebSolutions\Framework\Utilities\Interfaces\Resources\Traits;

use DeepWebSolutions\Framework\Helpers\PHP\Strings;
use DeepWebSolutions\Framework\Utilities\Interfaces\Resources\PluginInterface;

defined( 'ABSPATH' ) || exit;

/**
 * Trait for working with the Identifiable interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Utilities\Interfaces\Resources\Traits
 */
trait IdentityTrait {
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

	/**
	 * Gets a PHP-friendly version of the public name of the using class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_instance_safe_public_name(): string {
		return Strings::generate_safe_string(
			Strings::remove_non_alphanumeric_characters( $this->get_instance_public_name() ),
			array(
				' ' => '-',
				'_' => '_',
			)
		);
	}

	// endregion

	// region SETTERS

	/**
	 * Set the ID of the current class instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $instance_id    The value to be set.
	 */
	public function set_instance_id( string $instance_id ): void {
		$this->instance_id = $instance_id;
	}

	/**
	 * Set the public name of the current class instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $instance_public_name   The value to be set.
	 */
	public function set_instance_public_name( string $instance_public_name ): void {
		$this->instance_public_name = $instance_public_name;
	}

	// endregion
}
