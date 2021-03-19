<?php

namespace DeepWebSolutions\Framework\Foundations\PluginUtilities\Handlers;

\defined( 'ABSPATH' ) || exit;

/**
 * Describes a handler-aware-instance.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\PluginUtilities\Handlers
 */
interface HandlerAwareInterface {
	/**
	 * Gets the current handler instance set on the object.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  HandlerInterface
	 */
	public function get_handler(): HandlerInterface;

	/**
	 * Sets a handler instance on the object.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   HandlerInterface    $handler    Handler instance to use from now on.
	 */
	public function set_hooks_handler( HandlerInterface $handler );
}
