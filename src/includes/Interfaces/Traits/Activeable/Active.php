<?php

namespace DeepWebSolutions\Framework\Utilities\Interfaces\Traits\Activeable;

use DeepWebSolutions\Framework\Helpers\PHP\Misc;

defined( 'ABSPATH' ) || exit;

/**
 * Trait for working with the Activationable interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Utilities\Handlers\Traits\Activeable
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
	 * @return bool
	 */
	public function is_active(): bool {
		if ( is_null( $this->active ) ) {
			$this->active = true;

			$this->active = $this->active && $this->maybe_check_is_active_local();
			$this->active = $this->active && $this->maybe_check_is_active_traits();
		}

		return $this->active;
	}

	/**
	 * Check any potential local is_active logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @see     ActiveLocal::is_active_local()
	 *
	 * @return  bool
	 */
	protected function maybe_check_is_active_local(): bool {
		if ( in_array( ActiveLocal::class, Misc::class_uses_deep( $this ), true ) && method_exists( $this, 'is_active_local' ) ) {
			return $this->is_active_local();
		}

		return true;
	}

	/**
	 * Check any potential trait is_active logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  bool
	 */
	protected function maybe_check_is_active_traits(): bool {
		foreach ( class_uses( $this ) as $used_trait ) {
			if ( array_search( Activeable::class, Misc::class_uses_deep( $used_trait ), true ) !== false ) {
				$trait_boom  = explode( '\\', $used_trait );
				$method_name = 'is_active_' . strtolower( preg_replace( '/([A-Z]+)/', '_${1}', end( $trait_boom ) ) );

				if ( method_exists( $this, $method_name ) ) {
					$result = $this->{$method_name}();
					if ( false === $result ) {
						return false;
					}
				}
			}
		}

		return true;
	}

	// endregion
}
