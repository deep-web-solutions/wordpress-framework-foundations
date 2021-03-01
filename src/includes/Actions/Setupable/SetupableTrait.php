<?php

namespace DeepWebSolutions\Framework\Foundations\Actions\Setupable;

use DeepWebSolutions\Framework\Helpers\DataTypes\Objects;
use DeepWebSolutions\Framework\Helpers\DataTypes\Strings;

defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of the setupable interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Actions\Setupable
 */
trait SetupableTrait {
	// region FIELDS AND CONSTANTS

	/**
	 * The result of the setup operation. Null if successful.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     SetupFailureException|null
	 */
	protected ?SetupFailureException $setup_result;

	/**
	 * Whether the using instance is setup or not. Null if not decided yet.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     bool|null
	 */
	protected ?bool $is_setup = null;

	// endregion

	// region GETTERS

	/**
	 * Returns the result of the setup operation.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  SetupFailureException|null
	 */
	public function get_setup_result(): ?SetupFailureException {
		return $this->setup_result;
	}

	/**
	 * Returns whether the using instance is setup or not. Null if not decided yet.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  bool|null
	 */
	public function is_setup(): ?bool {
		return $this->is_setup;
	}

	// endregion

	// region METHODS

	/**
	 * Simple setup logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function setup(): ?SetupFailureException {
		if ( is_null( $this->is_setup ) ) {
			if ( ! is_null( $result = $this->maybe_setup_traits() ) ) { // phpcs:ignore
				$this->is_setup     = false;
				$this->setup_result = $result;
			} elseif ( ! is_null( $result = $this->maybe_setup_local() ) ) { // phpcs:ignore
				$this->is_setup     = false;
				$this->setup_result = $result;
			} else {
				$this->is_setup     = true;
				$this->setup_result = null;
			}
		}

		return $this->setup_result;
	}

	// endregion

	// region HELPERS

	/**
	 * Execute any potential trait setup logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  SetupFailureException|null
	 */
	protected function maybe_setup_traits(): ?SetupFailureException {
		if ( false !== array_search( SetupableExtensionTrait::class, Objects::class_uses_deep_list( $this ), true ) ) {
			foreach ( Objects::class_uses_deep( $this ) as $trait_name => $deep_used_traits ) {
				if ( false === array_search( SetupableExtensionTrait::class, $deep_used_traits, true ) ) {
					continue;
				}

				$trait_boom  = explode( '\\', $trait_name );
				$method_name = 'setup' . strtolower( preg_replace( '/([A-Z]+)/', '_${1}', end( $trait_boom ) ) );
				$method_name = Strings::ends_with( $method_name, '_trait' ) ? str_replace( '_trait', '', $method_name ) : $method_name;

				if ( method_exists( $this, $method_name ) ) {
					$result = $this->{$method_name}();

					if ( ! is_null( $result ) ) {
						return $result;
					}
				}
			}
		}

		return null;
	}

	/**
	 * Execute any potential local setup logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @see     SetupLocal::setup_local()
	 *
	 * @return  SetupFailureException|null
	 */
	protected function maybe_setup_local(): ?SetupFailureException {
		if ( in_array( SetupableLocalTrait::class, Objects::class_uses_deep_list( $this ), true ) && method_exists( $this, 'setup_local' ) ) {
			return $this->setup_local();
		}

		return null;
	}

	// endregion
}
