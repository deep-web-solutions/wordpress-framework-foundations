<?php

namespace DeepWebSolutions\Framework\Foundations\PluginUtilities\Handlers;

\defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of the handler-aware interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\PluginUtilities\Handlers
 */
trait HandlerAwareTrait {
	// region FIELDS AND CONSTANTS

	/**
	 * Handler instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     HandlerInterface
	 */
	protected HandlerInterface $handler;

	// endregion

	// region GETTERS

	/**
	 * Gets the current handler instance set on the object.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  HandlerInterface
	 */
	public function get_handler(): HandlerInterface {
		return $this->handler;
	}

	// endregion

	// region SETTERS

	/**
	 * Sets a handler instance on the object.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   HandlerInterface    $handler    Handler instance to use from now on.
	 */
	public function set_handler( HandlerInterface $handler ) {
		$this->handler = $handler;
	}

	// endregion
}
