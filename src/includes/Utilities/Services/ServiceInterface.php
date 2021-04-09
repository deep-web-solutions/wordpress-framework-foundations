<?php

namespace DeepWebSolutions\Framework\Foundations\Utilities\Services;

use DeepWebSolutions\Framework\Foundations\Logging\LoggingServiceAwareInterface;
use DeepWebSolutions\Framework\Foundations\Plugin\PluginAwareInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Storage\StorableInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Describes a service instance. Services are central hubs for performing actions that exist "outside" the plugin tree.
 * Typically the implementation logic should be left to a handler.
 *
 * @since   1.0.0
 * @version 1.3.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Utilities\Services
 */
interface ServiceInterface extends LoggingServiceAwareInterface, PluginAwareInterface, StorableInterface {
	/* empty on purpose */
}
