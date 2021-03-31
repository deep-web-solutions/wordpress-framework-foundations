<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Hierarchy;

use DeepWebSolutions\Framework\Foundations\Hierarchy\ParentInterface;
use DeepWebSolutions\Framework\Foundations\Hierarchy\ParentTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Class ParentObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations
 */
class ParentObject implements ParentInterface {
	use ParentTrait;
}
