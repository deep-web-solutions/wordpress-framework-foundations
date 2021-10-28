<?php

namespace DeepWebSolutions\Framework\Foundations\Services;

use DeepWebSolutions\Framework\Foundations\DependencyInjection\ContainerAwareInterface;
use DeepWebSolutions\Framework\Foundations\Logging\LoggingService;
use DeepWebSolutions\Framework\Foundations\Logging\LoggingServiceAwareInterface;
use DeepWebSolutions\Framework\Foundations\PluginAwareInterface;
use DeepWebSolutions\Framework\Foundations\PluginInterface;
use DeepWebSolutions\Framework\Foundations\Storage\Stores\MemoryStore;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Template for encapsulating some of the most often required abilities of a multi-handler service.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Services
 */
abstract class AbstractMultiHandlerService extends AbstractService implements ServiceInterface, MultiHandlerAwareInterface {
	// region TRAITS

	use MultiHandlerAwareTrait {
		get_handler as protected get_handler_trait;
		register_handler as protected register_handler_trait;
	}

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

		$this->set_stores_store( new MemoryStore( $this->get_id() ) );
		$this->set_handlers_store( new MemoryStore( 'handlers' ) );

		$this->set_default_handlers( $handlers );
	}

	// endregion

	// region INHERITED METHODS

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
		$entry = $this->get_handler_trait( $handler_id );
		return \is_a( $entry, $this->get_handler_class() ) ? $entry : null;
	}

	/**
	 * Registers a new handler with the service.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   HandlerInterface    $handler    The new handler to register with the service.
	 *
	 * @throws  \LogicException     Thrown if the handler passed on is of the wrong type.
	 *
	 * @return  $this
	 */
	public function register_handler( HandlerInterface $handler ): self {
		if ( ! \is_a( $handler, $this->get_handler_class() ) ) {
			throw new \LogicException( \sprintf( 'The handler registered must be of class %s', $this->get_handler_class() ) );
		}

		if ( $handler instanceof PluginAwareInterface ) {
			$handler->set_plugin( $this->get_plugin() );
		}
		if ( $handler instanceof LoggingServiceAwareInterface ) {
			$handler->set_logging_service( $this->get_logging_service() );
		}

		return $this->register_handler_trait( $handler );
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
		$plugin    = $this->get_plugin();
		$container = ( $plugin instanceof ContainerAwareInterface )
			? $plugin->get_container() : null;

		$default_handlers = \array_filter(
			\array_map(
				function( string $class ) use ( $container ) {
					if ( ! \is_a( $class, $this->get_handler_class(), true ) ) {
						return null;
					}

					return \is_null( $container ) ? new $class() : $container->get( $class );
				},
				$this->get_default_handlers_classes()
			)
		);

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
