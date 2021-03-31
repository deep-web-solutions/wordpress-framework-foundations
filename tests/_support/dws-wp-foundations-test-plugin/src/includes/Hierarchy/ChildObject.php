<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Hierarchy;

use DeepWebSolutions\Framework\Foundations\Hierarchy\ChildInterface;
use DeepWebSolutions\Framework\Foundations\Hierarchy\ChildTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Class ChildObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations
 */
class ChildObject implements ChildInterface {
	use ChildTrait;
}
