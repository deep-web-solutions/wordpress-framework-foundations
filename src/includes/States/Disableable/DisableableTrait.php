<?php

namespace DeepWebSolutions\Framework\Foundations\States\Disableable;

use DeepWebSolutions\Framework\Foundations\Helpers\ActionExtensionHelpersTrait;
use DeepWebSolutions\Framework\Helpers\DataTypes\Objects;

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
	// region TRAITS

	use ActionExtensionHelpersTrait;

	// endregion

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

			$this->is_disabled = $this->is_disabled || $this->maybe_execute_extension_traits( DisableableExtensionTrait::class, false, 'is' );
			$this->is_disabled = $this->is_disabled || $this->maybe_check_is_disabled_local();
		}

		return $this->is_disabled;
	}

	// endregion

	// region HELPERS

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
		if ( Objects::has_trait_deep( DisableableLocalTrait::class, $this ) && method_exists( $this, 'is_disabled_local' ) ) {
			return $this->is_disabled_local();
		}

		return false;
	}

	// endregion
}
