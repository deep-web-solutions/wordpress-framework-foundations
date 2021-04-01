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
class DefaultMultiHandlerServiceObject extends MultiHandlerServiceObject {
	/**
	 * Set a default handler.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array
	 */
	protected function get_default_handlers_classes(): array {
		return array ( DefaultHandlerObject::class );
	}
}
