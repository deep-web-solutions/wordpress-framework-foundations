<?php

namespace DeepWebSolutions\Framework\Foundations\DependencyInjection;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of the multi-DI-container-aware interface.
 *
 * @since   1.5.2
 * @version 1.5.2
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\DependencyInjection
 */
trait MultiContainerAwareTrait {
	// region FIELDS AND CONSTANTS

	/**
	 * Dependency injection container.
	 *
	 * @since   1.5.2
	 * @version 1.5.2
	 *
	 * @access  protected
	 * @var     ContainerInterface[]
	 */
	protected array $di_containers = array();

	// endregion

	// region GETTERS

	/**
	 * Gets all container instances set on the object.
	 *
	 * @since   1.5.2
	 * @version 1.5.2
	 *
	 * @return  array
	 */
	public function get_containers(): array {
		return $this->di_containers;
	}

	/**
	 * Gets an instance of a dependency injection container.
	 *
	 * @since   1.5.2
	 * @version 1.5.2
	 *
	 * @param   string  $container_id   The ID of the container.
	 *
	 * @return  ContainerInterface|null
	 */
	public function get_container( string $container_id ): ?ContainerInterface {
		return $this->di_containers[ $container_id ] ?? null;
	}

	// endregion

	// region SETTERS

	/**
	 * Replaces all the containers on the instance with new ones.
	 *
	 * @since   1.5.2
	 * @version 1.5.2
	 *
	 * @param   ContainerInterface[]    $containers     Container instances to use from now on.
	 */
	public function set_containers( array $containers ) {
		$this->di_containers = $containers;
	}

	/**
	 * Registers a new container with the object.
	 *
	 * @since   1.5.2
	 * @version 1.5.2
	 *
	 * @param   string                  $container_id   The ID of the new container.
	 * @param   ContainerInterface      $container      Container to register with the instance.
	 *
	 * @return  MultiContainerAwareInterface
	 */
	public function register_container( string $container_id, ContainerInterface $container ): MultiContainerAwareInterface {
		$this->di_containers[ $container_id ] = $container;
		/* @noinspection PhpIncompatibleReturnTypeInspection */
		return $this;
	}

	// endregion

	// region HELPERS

	/**
	 * Returns an object from the DI container or null on failure.
	 *
	 * @since   1.5.2
	 * @version 1.5.2
	 *
	 * @param   string  $entry_id       The ID of the entry to retrieve from the container.
	 * @param   string  $container_id   The ID of the container to retrieve from.
	 *
	 * @return  mixed|null
	 */
	public function get_container_entry( string $entry_id, string $container_id ) {
		try {
			return $this->get_container( $container_id )->get( $entry_id );
		} catch ( ContainerExceptionInterface | NotFoundExceptionInterface $exception ) {
			return null;
		}
	}

	// endregion
}
