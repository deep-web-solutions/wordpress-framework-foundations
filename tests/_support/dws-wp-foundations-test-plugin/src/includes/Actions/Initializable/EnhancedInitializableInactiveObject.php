<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\Initializable;

use DeepWebSolutions\Framework\Foundations\Actions\Initializable\Integrations\SetupableInactiveTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Class EnhancedInitializableInactiveObject
 *
 * @since   1.2.0
 * @version 1.2.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\Initializable
 */
class EnhancedInitializableInactiveObject extends EnhancedInitializableObject {
	use SetupableInactiveTrait;
}
