<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Utilities;

use DeepWebSolutions\Framework\Foundations\Utilities\Handlers\HandlerAwareInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Handlers\HandlerAwareTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Class HandlerAwareObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Utilities
 */
class HandlerAwareObject implements HandlerAwareInterface {
	use HandlerAwareTrait;
}
