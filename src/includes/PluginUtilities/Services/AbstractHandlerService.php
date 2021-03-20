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
		$this->set_default_handler( $handler );
	}

	// endregion

	// region INHERITED METHODS

	/**
	 * Sets a handler instance on the object.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   HandlerInterface    $handler    Handler instance to use from now on.
	 */
	public function set_handler( HandlerInterface $handler ) {
		if ( \is_a( $handler, $this->get_handler_class() ) ) {
			$this->handler = $handler;
		}
	}

	// endregion

	// region HELPERS

	/**
	 * Registers a default handler if one has not been set through the container.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   HandlerInterface|null       $handler    Handler passed on in the constructor.
	 */
	protected function set_default_handler( ?HandlerInterface $handler ): void {
		if ( ! \is_null( $handler ) ) {
			$this->set_handler( $handler );
		}
	}

	/**
	 * Returns the class name of the used handler for better type-checking.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	abstract protected function get_handler_class(): string;

	// endregion
}