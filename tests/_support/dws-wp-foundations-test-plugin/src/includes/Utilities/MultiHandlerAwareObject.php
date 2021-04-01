<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Utilities;

use DeepWebSolutions\Framework\Foundations\Utilities\Handlers\MultiHandlerAwareInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Handlers\MultiHandlerAwareTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Class MultiHandlerAwareObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Utilities
 */
class MultiHandlerAwareObject implements MultiHandlerAwareInterface {
	use MultiHandlerAwareTrait;
}
