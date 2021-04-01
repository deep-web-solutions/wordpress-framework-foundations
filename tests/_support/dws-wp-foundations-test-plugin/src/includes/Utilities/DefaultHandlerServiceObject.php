<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Utilities;

\defined( 'ABSPATH' ) || exit;

/**
 * Class HandlerServiceObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Utilities
 */
class DefaultHandlerServiceObject extends HandlerServiceObject {
	/**
	 * Set a default handler.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	protected function get_default_handler_class(): string {
		return DefaultHandlerObject::class;
	}
}
