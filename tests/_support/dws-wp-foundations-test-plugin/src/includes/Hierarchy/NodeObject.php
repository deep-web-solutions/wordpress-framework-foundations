<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Hierarchy;

use DeepWebSolutions\Framework\Foundations\Hierarchy\NodeInterface;
use DeepWebSolutions\Framework\Foundations\Hierarchy\NodeTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Class NodeObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations
 */
class NodeObject implements NodeInterface {
	use NodeTrait;
}
