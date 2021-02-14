<?php

namespace DeepWebSolutions\Framework\Utilities\Interfaces\States\Traits\IsActiveable;

use DeepWebSolutions\Framework\Helpers\PHP\Misc;

defined( 'ABSPATH' ) || exit;

/**
 * Trait for working with the Activeable interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Utilities\Interfaces\States\Traits\IsActiveable
 */
trait Active {
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

			$this->is_active = $this->is_active && $this->maybe_check_is_active_traits();
			$this->is_active = $this->is_active && $this->maybe_check_is_active_local();
		}

		return $this->is_active;
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
		if ( false !== array_search( Activeable::class, Misc::class_uses_deep_list( $this ), true ) ) {
			foreach ( Misc::class_uses_deep( $this ) as $trait_name => $recursive_used_traits ) {
				if ( false === array_search( Activeable::class, $recursive_used_traits, true ) ) {
					continue;
				}

				$trait_boom  = explode( '\\', $trait_name );
				$method_name = 'is_active' . strtolower( preg_replace( '/([A-Z]+)/', '_${1}', end( $trait_boom ) ) );

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
	 * @see     ActiveLocal::is_active_local()
	 *
	 * @return  bool
	 */
	protected function maybe_check_is_active_local(): bool {
		if ( in_array( ActiveLocal::class, Misc::class_uses_deep_list( $this ), true ) && method_exists( $this, 'is_active_local' ) ) {
			return $this->is_active_local();
		}

		return true;
	}

	// endregion
}
