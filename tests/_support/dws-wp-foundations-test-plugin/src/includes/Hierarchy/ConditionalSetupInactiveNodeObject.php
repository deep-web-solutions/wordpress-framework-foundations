<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Hierarchy;

use DeepWebSolutions\Framework\Foundations\Actions\Initializable\Integrations\SetupableInactiveTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Class ConditionalSetupInactiveNodeObject
 *
 * @since   1.2.1
 * @version 1.2.1
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Hierarchy
 */
class ConditionalSetupInactiveNodeObject extends ConditionalSetupNodeObject {
	use SetupableInactiveTrait;
}
