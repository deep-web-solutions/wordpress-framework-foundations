<?php

namespace DeepWebSolutions\Framework\Foundations\PluginUtilities\Services;

use DeepWebSolutions\Framework\Foundations\PluginUtilities\Handlers\HandlerAwareInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Describes a single handler service instance. That is a service that interacts with exactly one handler as opposed
 * to regular services which interact with none.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\PluginUtilities\Services
 */
interface HandlerServiceInterface extends ServiceInterface, HandlerAwareInterface {
	/* empty on purpose */
}
