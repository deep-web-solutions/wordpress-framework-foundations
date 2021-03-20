<?php

namespace DeepWebSolutions\Framework\Foundations\PluginUtilities\Services;

use DeepWebSolutions\Framework\Foundations\Logging\LoggingService;
use DeepWebSolutions\Framework\Foundations\Plugin\PluginInterface;
use DeepWebSolutions\Framework\Foundations\PluginUtilities\Handlers\HandlerAwareTrait;
use DeepWebSolutions\Framework\Foundations\PluginUtilities\Handlers\HandlerInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Template for encapsulating some of the most often required abilities of a handler service.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\PluginUtilities\Services
 */
abstract class AbstractHandlerService extends AbstractService implements HandlerServiceInterface {
	// region TRAITS

	use HandlerAwareTrait;

	// endregion

	// region MAGIC METHODS

	/**
	 * AbstractHandlerService constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   PluginInterface         $plugin             Instance of the plugin.
	 * @param   LoggingService          $logging_service    Instance of the logging service.
	 * @param   HandlerInterface|null   $handler            Instance of the handler used.
	 */
	public function __construct( PluginInterface $plugin, LoggingService $logging_service, ?HandlerInterface $handler = null ) {
		parent::__construct( $plugin, $logging_service );

		if ( ! \is_null( $handler ) ) {
			$this->set_handler( $handler );
		}
	}

	// endregion
}
