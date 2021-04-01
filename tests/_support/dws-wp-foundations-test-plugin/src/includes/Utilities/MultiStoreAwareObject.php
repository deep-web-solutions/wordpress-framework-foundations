<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Utilities;

use DeepWebSolutions\Framework\Foundations\Utilities\Storage\MultiStoreAwareInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Storage\MultiStoreAwareTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Class StoreAwareObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Utilities
 */
class MultiStoreAwareObject implements MultiStoreAwareInterface {
	use MultiStoreAwareTrait;
}
