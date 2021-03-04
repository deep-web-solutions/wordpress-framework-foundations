<?php

namespace DeepWebSolutions\Framework\Foundations\PluginComponent;

use DeepWebSolutions\Framework\Foundations\Plugin\PluginAwareTrait;
use DeepWebSolutions\Framework\Helpers\DataTypes\Strings;

defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of the plugin component interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\PluginComponent
 */
trait PluginComponentTrait {
	// region TRAITS

	use PluginAwareTrait;

	// endregion

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
	protected string $instance_name;

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
	public function get_instance_name(): string {
		return $this->instance_name;
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
	 * @param   string  $instance_name   The value to be set.
	 */
	public function set_instance_name( string $instance_name ): void {
		$this->instance_name = $instance_name;
	}

	// endregion

	// region HELPERS

	/**
	 * Gets a PHP-friendly version of the public name of the using class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_instance_safe_name(): string {
		return Strings::to_safe_string(
			Strings::to_alphanumeric_string( $this->get_instance_name() ),
			array(
				' ' => '-',
				'_' => '_',
			)
		);
	}

	// endregion
}
