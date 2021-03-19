<?php

namespace DeepWebSolutions\Framework\Foundations\PluginUtilities\Handlers;

use DeepWebSolutions\Framework\Foundations\PluginUtilities\Storage\StoreableInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Describes a handler instance. Handlers are implementations of specific service actions.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\PluginUtilities\Handlers
 */
interface HandlerInterface extends StoreableInterface {
	/* empty on purpose */
}
