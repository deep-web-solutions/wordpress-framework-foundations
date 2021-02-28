<?php

namespace DeepWebSolutions\Framework\Interfaces\IsActive;

use DeepWebSolutions\Framework\Helpers\DataTypes\Objects;
use DeepWebSolutions\Framework\Helpers\DataTypes\Strings;

defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of the is-active interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Interfaces\IsActive
 */
trait IsActiveAwareTrait {
	// region FIELDS AND CONSTANTS

	/**
	 * Whether the using instance is active or not. Null if not decided yet.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     bool|null
	 */
	protected ?bool $is_active = null;

	// endregion

	// region METHODS

	/**
	 * Simple activation logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  bool
	 */
	public function is_active(): bool {
		if ( is_null( $this->is_active ) ) {
			$this->is_active = true;

			$this->is_active = $this->is_active && $this->maybe_check_is_active_local();
			$this->is_active = $this->is_active && $this->maybe_check_is_active_traits();
		}

		return $this->is_active;
	}

	// endregion

	// region HELPERS

	/**
	 * Check any potential trait is_active logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  bool
	 */
	protected function maybe_check_is_active_traits(): bool {
		if ( false !== array_search( IsActiveExtensionTrait::class, Objects::class_uses_deep_list( $this ), true ) ) {
			foreach ( Objects::class_uses_deep( $this ) as $trait_name => $deep_used_traits ) {
				if ( false === array_search( IsActiveExtensionTrait::class, $deep_used_traits, true ) ) {
					continue;
				}

				$trait_boom  = explode( '\\', $trait_name );
				$method_name = 'is_active' . strtolower( preg_replace( '/([A-Z]+)/', '_${1}', end( $trait_boom ) ) );
				$method_name = Strings::ends_with( $method_name, '_trait' ) ? str_replace( '_trait', '', $method_name ) : $method_name;

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

	/**
	 * Check any potential local is_active logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @see     IsActiveLocalTrait::is_active_local()
	 *
	 * @return  bool
	 */
	protected function maybe_check_is_active_local(): bool {
		if ( in_array( IsActiveLocalTrait::class, Objects::class_uses_deep_list( $this ), true ) && method_exists( $this, 'is_active_local' ) ) {
			return $this->is_active_local();
		}

		return true;
	}

	// endregion
}
