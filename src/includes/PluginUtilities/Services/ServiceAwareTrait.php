<?php

namespace DeepWebSolutions\Framework\Foundations\PluginUtilities\Services;

\defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of the service-aware interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\PluginUtilities\Services
 */
trait ServiceAwareTrait {
	// region FIELDS AND CONSTANTS

	/**
	 * Service instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     ServiceInterface
	 */
	protected ServiceInterface $service;

	// endregion

	/**
	 * Gets the current service instance set on the object.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  ServiceInterface
	 */
	public function get_service(): ServiceInterface {
		return $this->service;
	}

	// endregion

	// region SETTERS

	/**
	 * Sets a service instance on the object.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   ServiceInterface    $service    Service instance to use from now on.
	 */
	public function set_service( ServiceInterface $service ) {
		$this->service = $service;
	}

	// endregion
}
