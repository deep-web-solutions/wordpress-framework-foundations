<?php

namespace DeepWebSolutions\Framework\Foundations\PluginUtilities\Services;

use DeepWebSolutions\Framework\Foundations\Logging\LoggingServiceAwareInterface;
use DeepWebSolutions\Framework\Foundations\Plugin\PluginAwareInterface;
use DeepWebSolutions\Framework\Foundations\PluginUtilities\Storage\StoreableInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Describes a service instance. Services are central hubs for performing actions that exist "outside" the plugin tree.
 * Typically the implementation logic should be left to a handler.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\PluginUtilities\Services
 */
interface ServiceInterface extends LoggingServiceAwareInterface, PluginAwareInterface, StoreableInterface {
	/* empty on purpose */
}
