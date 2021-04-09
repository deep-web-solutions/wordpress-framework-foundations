<?php

namespace DeepWebSolutions\Framework\Foundations\Utilities\Handlers;

use DeepWebSolutions\Framework\Foundations\Utilities\Storage\AbstractStorable;

\defined( 'ABSPATH' ) || exit;

/**
 * Template for encapsulating the most-often needed functionality of a handler.
 *
 * @since   1.0.0
 * @version 1.3.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Utilities\Handlers
 */
abstract class AbstractHandler extends AbstractStorable implements HandlerInterface {
	// region MAGIC METHODS

	/**
	 * AbstractHandler constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string      $handler_id     The ID of the handler instance.
	 */
	public function __construct( string $handler_id ) { // phpcs:ignore
		parent::__construct( $handler_id );
	}

	// endregion
}
