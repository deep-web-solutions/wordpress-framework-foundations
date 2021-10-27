<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Utilities;

use DeepWebSolutions\Framework\FoundationsDependencyInjection\ContainerAwareInterface;
use DeepWebSolutions\Framework\FoundationsDependencyInjection\ContainerAwareTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Class ContainerAwareObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Utilities
 */
class ContainerAwareObject implements ContainerAwareInterface {
	use ContainerAwareTrait;
}