<?php

namespace DeepWebSolutions\Framework\Foundations\Utilities\Services;

use DeepWebSolutions\Framework\Foundations\Logging\LoggingService;
use DeepWebSolutions\Framework\Foundations\Logging\LoggingServiceAwareInterface;
use DeepWebSolutions\Framework\Foundations\Plugin\PluginAwareInterface;
use DeepWebSolutions\Framework\Foundations\Plugin\PluginInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\DependencyInjection\ContainerAwareInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Handlers\HandlerInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Handlers\MultiHandlerAwareInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Storage\StoreAwareTrait;
use DeepWebSolutions\Framework\Foundations\Utilities\Storage\Stores\MemoryStore;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Template for encapsulating some of the most often required abilities of a multi-handler service.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Utilities\Services
 */
abstract class AbstractMultiHandlerService extends AbstractService implements ServiceInterface, MultiHandlerAwareInterface {
	// region TRAITS

	use StoreAwareTrait;

	// endregion

	// region MAGIC METHODS

	/**
	 * AbstractMultiHandlerService constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   PluginInterface     $plugin             Instance of the plugin.
	 * @param   LoggingService      $logging_service    Instance of the logging service.
	 * @param   HandlerInterface[]  $handlers           Collection of handlers to use.
	 */
	public function __construct( PluginInterface $plugin, LoggingService $logging_service, array $handlers = array() ) {
		parent::__construct( $plugin, $logging_service );
		$this->set_default_handlers( $handlers );
	}

	// endregion

	// region INHERITED METHODS

	/**
	 * Returns all registered handlers.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  HandlerInterface[]
	 */
	public function get_handlers(): array {
		try {
			return $this->get_store()->get_all();
		} catch ( ContainerExceptionInterface $exception ) {
			return array();
		}
	}

	/**
	 * Returns a given registered handler.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $handler_id     The ID of the handler.
	 *
	 * @return  HandlerInterface|null
	 */
	public function get_handler( string $handler_id ): ?HandlerInterface {
		$entry = $this->get_store_entry( $handler_id );

		/* @noinspection PhpIncompatibleReturnTypeInspection */
		return \is_a( $entry, $this->get_handler_class() ) ? $entry : null;
	}

	/**
	 * Overwrites all the current handlers available to the service.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   HandlerInterface[]      $handlers       Handlers to be used by the service from now on.
	 *
	 * @return  $this
	 */
	public function set_handlers( array $handlers ): self {
		$this->set_store( new MemoryStore( $this->get_id() ) );

		foreach ( $handlers as $handler ) {
			if ( $handler instanceof HandlerInterface ) {
				$this->register_handler( $handler );
			}
		}

		return $this;
	}

	/**
	 * Registers a new handler with the service.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   HandlerInterface    $handler    The new handler to register with the service.
	 *
	 * @return  $this
	 */
	public function register_handler( HandlerInterface $handler ): self {
		if ( \is_a( $handler, $this->get_handler_class() ) ) {
			if ( $handler instanceof PluginAwareInterface ) {
				$handler->set_plugin( $this->get_plugin() );
			}
			if ( $handler instanceof LoggingServiceAwareInterface ) {
				$handler->set_logging_service( $this->get_logging_service() );
			}

			$this->update_store_entry( $handler );
		}

		return $this;
	}

	// endregion

	// region HELPERS

	/**
	 * Registers the handlers passed on in the constructor together with any default handlers of the service.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   array   $handlers   Handlers passed on in the constructor.
	 *
	 * @throws  NotFoundExceptionInterface      Thrown if the NullLogger is not found in the plugin DI-container.
	 * @throws  ContainerExceptionInterface     Thrown if some other error occurs while retrieving the NullLogger instance.
	 */
	protected function set_default_handlers( array $handlers ): void {
		$plugin = $this->get_plugin();

		if ( $plugin instanceof ContainerAwareInterface ) {
			$container        = $plugin->get_container();
			$default_handlers = \array_map(
				function( string $class ) use ( $container ) {
					return $container->get( $class );
				},
				$this->get_default_handlers_classes()
			);
		} else {
			$default_handlers = \array_filter(
				\array_map(
					function( string $class ) {
						return \is_a( $class, $this->get_handler_class(), true ) ? new $class() : null;
					},
					$this->get_default_handlers_classes()
				)
			);
		}

		$this->set_handlers( \array_merge( $default_handlers, $handlers ) );
	}

	/**
	 * Returns a list of what the default handlers actually are for the inheriting service.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  array
	 */
	protected function get_default_handlers_classes(): array {
		return array();
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
