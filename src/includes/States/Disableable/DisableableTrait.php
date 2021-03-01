<?php

namespace DeepWebSolutions\Framework\Foundations\States\Disableable;

use DeepWebSolutions\Framework\Helpers\DataTypes\Objects;
use DeepWebSolutions\Framework\Helpers\DataTypes\Strings;

defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of the disableable interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\States\Disableable
 */
trait DisableableTrait {
	// region FIELDS AND CONSTANTS

	/**
	 * Whether the using instance is disabled or not. Null if not decided yet.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     bool|null
	 */
	protected ?bool $is_disabled = null;

	// endregion

	// region METHODS

	/**
	 * Simple disablement logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  bool
	 */
	public function is_disabled(): bool {
		if ( is_null( $this->is_disabled ) ) {
			$this->is_disabled = false;

			$this->is_disabled = $this->is_disabled || $this->maybe_check_is_disabled_local();
			$this->is_disabled = $this->is_disabled || $this->maybe_check_is_disabled_traits();
		}

		return $this->is_disabled;
	}

	// endregion

	// region HELPERS

	/**
	 * Check any potential trait is_disabled logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  bool
	 */
	protected function maybe_check_is_disabled_traits(): bool {
		if ( false !== array_search( DisableableExtensionTrait::class, Objects::class_uses_deep_list( $this ), true ) ) {
			foreach ( Objects::class_uses_deep( $this ) as $trait_name => $deep_used_traits ) {
				if ( false === array_search( DisableableExtensionTrait::class, $deep_used_traits, true ) ) {
					continue;
				}

				$trait_boom  = explode( '\\', $trait_name );
				$method_name = 'is_disabled' . strtolower( preg_replace( '/([A-Z]+)/', '_${1}', end( $trait_boom ) ) );
				$method_name = Strings::ends_with( $method_name, '_trait' ) ? str_replace( '_trait', '', $method_name ) : $method_name;

				if ( method_exists( $this, $method_name ) ) {
					$result = $this->{$method_name}();
					if ( true === $result ) {
						return true;
					}
				}
			}
		}

		return false;
	}

	/**
	 * Check any potential local is_disabled logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @see     DisableableLocalTrait::is_disabled_local()
	 *
	 * @return  bool
	 */
	protected function maybe_check_is_disabled_local(): bool {
		if ( in_array( DisableableLocalTrait::class, Objects::class_uses_deep_list( $this ), true ) && method_exists( $this, 'is_disabled_local' ) ) {
			return $this->is_disabled_local();
		}

		return false;
	}

	// endregion
}
