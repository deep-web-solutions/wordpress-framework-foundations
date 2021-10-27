<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Utilities;

use DeepWebSolutions\Framework\Foundations\Services\ServiceAwareInterface;
use DeepWebSolutions\Framework\Foundations\Services\ServiceAwareTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Class ServiceAwareObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Utilities
 */
class ServiceAwareObject implements ServiceAwareInterface {
	use ServiceAwareTrait;
}
