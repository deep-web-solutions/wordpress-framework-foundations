<?php

namespace DeepWebSolutions\Framework\Utilities\Interfaces\Traits\Disableable;

use DeepWebSolutions\Framework\Helpers\PHP\Misc;

defined( 'ABSPATH' ) || exit;

/**
 * Trait for working with the Disableable interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Utilities\Handlers\Traits\Disableable
 */
trait Disable {
	// region FIELDS AND CONSTANTS

	/**
	 * Whether the using instance is disabled or not.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     bool|null
	 */
	protected ?bool $disabled = null;

	// endregion

	// region METHODS

	/**
	 * Simple disablement logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return bool
	 */
	public function is_disabled(): bool {
		if ( is_null( $this->disabled ) ) {
			$this->disabled = false;

			$this->disabled = $this->disabled || $this->maybe_check_is_disabled_local();
			$this->disabled = $this->disabled || $this->maybe_check_is_disabled_traits();
		}

		return $this->disabled;
	}

	/**
	 * Check any potential local is_disabled logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @see     DisableLocal::is_disabled_local()
	 *
	 * @return  bool
	 */
	protected function maybe_check_is_disabled_local(): bool {
		if ( in_array( DisableLocal::class, Misc::class_uses_deep_list( $this ), true ) && method_exists( $this, 'is_disabled_local' ) ) {
			return $this->is_disabled_local();
		}

		return true;
	}

	/**
	 * Check any potential trait is_disabled logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  bool
	 */
	protected function maybe_check_is_disabled_traits(): bool {
		foreach ( class_uses( $this ) as $used_trait ) {
			if ( array_search( Disableable::class, Misc::class_uses_deep_list( $used_trait ), true ) !== false ) {
				foreach ( Misc::class_uses_deep( $used_trait ) as $trait_name => $used_traits ) {
					if ( array_search( Disableable::class, $used_traits, true ) !== false ) {
						$trait_boom  = explode( '\\', $trait_name );
						$method_name = 'is_disabled' . strtolower( preg_replace( '/([A-Z]+)/', '_${1}', end( $trait_boom ) ) );

						if ( method_exists( $this, $method_name ) ) {
							$result = $this->{$method_name}();
							if ( false === $result ) {
								return false;
							}
						}

						break;
					}
				}
			}
		}

		return true;
	}

	// endregion
}
