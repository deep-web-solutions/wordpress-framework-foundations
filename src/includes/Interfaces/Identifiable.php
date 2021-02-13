<?php

namespace DeepWebSolutions\Framework\Utilities\Interfaces;

defined( 'ABSPATH' ) || exit;

/**
 * Implementing classes need to define methods that let each instance be uniquely and easily identifiable.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Utilities\Interfaces
 */
interface Identifiable {
	/**
	 * Returns the plugin instance that the implementing class instance belongs to.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  Pluginable
	 */
	public function get_plugin(): Pluginable;

	/**
	 * Implementing class should return a hopefully unique ID of the instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_instance_id(): string;

	/**
	 * Implementing class should return a public name of the instance for potential user-friendliness.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_instance_public_name(): string;

	/**
	 * Implementing class must ensure this returns a PHP-friendly version of the instance's public name.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_instance_safe_public_name(): string;
}
