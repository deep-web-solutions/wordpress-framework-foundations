<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Utilities;

use DeepWebSolutions\Framework\Foundations\Utilities\Handlers\AbstractHandler;

\defined( 'ABSPATH' ) || exit;

/**
 * Class HandlerObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Utilities
 */
class HandlerObject extends AbstractHandler {
	/**
	 * Returns the type of the handler.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_type(): string {
		return 'test-handler';
	}
}
