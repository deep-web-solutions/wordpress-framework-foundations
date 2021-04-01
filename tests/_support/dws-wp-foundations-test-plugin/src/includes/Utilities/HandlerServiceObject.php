<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Utilities;

use DeepWebSolutions\Framework\Foundations\Utilities\Services\AbstractHandlerService;

\defined( 'ABSPATH' ) || exit;

/**
 * Class HandlerServiceObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Utilities
 */
class HandlerServiceObject extends AbstractHandlerService {
	/**
	 * Allow using only test handlers.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	protected function get_handler_class(): string {
		return HandlerObject::class;
	}
}
