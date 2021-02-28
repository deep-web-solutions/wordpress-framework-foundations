<?php

namespace DeepWebSolutions\Framework\Plugin;

defined( 'ABSPATH' ) || exit;

/**
 * Describes a plugin-aware instance.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Plugin
 */
interface PluginAwareInterface {
	/**
	 * Gets the current plugin instance set on the object.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  PluginInterface
	 */
	public function get_plugin(): PluginInterface;

	/**
	 * Sets a plugin instance on the object.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   PluginInterface     $plugin     Plugin instance to use from now on.
	 */
	public function set_plugin( PluginInterface $plugin ): void;
}
