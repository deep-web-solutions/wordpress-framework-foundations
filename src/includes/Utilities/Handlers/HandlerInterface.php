<?php

namespace DeepWebSolutions\Framework\Foundations\Utilities\Handlers;

use DeepWebSolutions\Framework\Foundations\Utilities\Storage\StorableInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Describes a handler instance. Handlers are implementations of specific service actions.
 *
 * @since   1.0.0
 * @version 1.3.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Utilities\Handlers
 */
interface HandlerInterface extends StorableInterface {
	/**
	 * Returns the type of the handler.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_type(): string;
}
