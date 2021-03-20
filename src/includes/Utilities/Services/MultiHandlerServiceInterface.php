<?php

namespace DeepWebSolutions\Framework\Foundations\Utilities\Services;

use DeepWebSolutions\Framework\Foundations\Utilities\Handlers\HandlerInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Describes a multi-handler service instance. That is a service that interacts with at least one handler as opposed
 * to regular services which interact with a maximum of one handler.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Utilities\Services
 */
interface MultiHandlerServiceInterface extends ServiceInterface {
	/**
	 * Returns all handlers registered with the service.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  HandlerInterface[]
	 */
	public function get_handlers(): array;

	/**
	 * Replaces all handlers registered with the service.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   HandlerInterface[]      $handlers       Handlers to be used by the service from now on.
	 */
	public function set_handlers( array $handlers );

	/**
	 * Registers a new handler with the service.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   HandlerInterface    $handler    The new handler to register with the service.
	 *
	 * @return  $this
	 */
	public function register_handler( HandlerInterface $handler ): self;
}
