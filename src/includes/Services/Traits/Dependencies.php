<?php

namespace DeepWebSolutions\Framework\Utilities\Services\Traits;

use DeepWebSolutions\Framework\Utilities\Interfaces\Identifiable;
use DeepWebSolutions\Framework\Utilities\Services\DependenciesService;

defined( 'ABSPATH' ) || exit;

/**
 * Trait for working with the dependencies service.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Utilities\Services\Traits
 */
trait Dependencies {
	// region FIELDS AND CONSTANTS

	/**
	 * Instance of the dependencies checker service.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     DependenciesService|null
	 */
	protected ?DependenciesService $dependencies_service = null;

	// endregion

	// region GETTERS

	/**
	 * Gets the logging service instance. If not set, returns a service that does nothing.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  DependenciesService
	 */
	public function get_dependencies_service(): DependenciesService {
		if ( $this instanceof Identifiable && is_null( $this->dependencies_service ) ) {
			$this->dependencies_service = new DependenciesService( $this, $this->get_dependencies() );
		}

		return $this->dependencies_service;
	}

	// endregion

	// region METHODS

	/**
	 * The using class needs to return a valid configuration for the DependenciesService.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @see     DependenciesService::__construct()
	 *
	 * @return  array
	 */
	abstract protected function get_dependencies(): array;

	// endregion
}
