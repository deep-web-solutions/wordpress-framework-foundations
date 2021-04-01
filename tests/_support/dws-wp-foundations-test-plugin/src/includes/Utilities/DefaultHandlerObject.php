<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Utilities;

\defined( 'ABSPATH' ) || exit;

/**
 * Class DefaultHandlerObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Utilities
 */
class DefaultHandlerObject extends HandlerObject {
	// region MAGIC METHODS

	/**
	 * DefaultHandlerObject constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string      $handler_id     The ID of the handler instance.
	 */
	public function __construct( string $handler_id = 'default-handler-id' ) { // phpcs:ignore
		parent::__construct( $handler_id );
	}

	// endregion
}
