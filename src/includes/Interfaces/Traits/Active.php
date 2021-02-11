<?php

namespace DeepWebSolutions\Framework\Utilities\Interfaces\Traits;

use DeepWebSolutions\Framework\Helpers\PHP\Misc;
use DeepWebSolutions\Framework\Utilities\Handlers\AdminNoticesHandler;
use DeepWebSolutions\Framework\Utilities\Services\DependenciesService;
use DeepWebSolutions\Framework\Utilities\Services\Traits\Dependencies;

defined( 'ABSPATH' ) || exit;

/**
 * Trait for working with the Activeable interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Utilities\Handlers\Traits
 */
trait Active {
	// region FIELDS AND CONSTANTS

	/**
	 * Whether the using instance is active or not.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     bool|null
	 */
	protected ?bool $active = null;

	// endregion

	// region METHODS

	/**
	 * Simple activation logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   AdminNoticesHandler     $admin_notices_handler      Instance of the admin notices handler.
	 *
	 * @return bool
	 */
	public function is_active( AdminNoticesHandler $admin_notices_handler ): bool {
		if ( is_null( $this->active ) ) {
			$this->active = $this->maybe_check_dependencies( $admin_notices_handler );
		}

		return $this->active;
	}

	/**
	 * Checks any potential dependencies.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   AdminNoticesHandler     $admin_notices_handler      Instance of the admin notices handler.
	 *
	 * @return  bool
	 */
	public function maybe_check_dependencies( AdminNoticesHandler $admin_notices_handler ): bool {
		if ( in_array( Dependencies::class, Misc::class_uses_deep( $this ), true ) && method_exists( $this, 'get_dependencies_service' ) ) {
			/** @var DependenciesService $dependencies_service */ // phpcs:ignore
			$dependencies_service = $this->get_dependencies_service();
			return $dependencies_service->are_dependencies_fulfilled( $admin_notices_handler );
		}

		return true;
	}

	// endregion
}
