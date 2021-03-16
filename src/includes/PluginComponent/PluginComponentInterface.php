<?php

namespace DeepWebSolutions\Framework\Foundations\PluginComponent;

use DeepWebSolutions\Framework\Foundations\Plugin\PluginAwareInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Describes a plugin component instance. Implementing classes need to define methods that let each instance be uniquely
 * and easily identifiable.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\PluginComponent
 */
interface PluginComponentInterface extends PluginAwareInterface {
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
	 * Implementing class should return a name of the instance for potential user-friendliness.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_instance_name(): string;

	/**
	 * Implementing class must ensure this returns a PHP-friendly version of the instance's public name.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_instance_safe_name(): string;
}
