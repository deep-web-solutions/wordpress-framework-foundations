<?php

namespace DeepWebSolutions\Framework\Foundations\States\Activeable;

use DeepWebSolutions\Framework\Foundations\Helpers\ActionExtensionHelpersTrait;
use DeepWebSolutions\Framework\Helpers\DataTypes\Objects;
use DeepWebSolutions\Framework\Helpers\DataTypes\Strings;

defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of the activeable interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\States\Activeable
 */
trait ActiveableTrait {
	// region TRAITS

	use ActionExtensionHelpersTrait;

	// endregion

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

			$this->is_active = $this->is_active && $this->maybe_execute_extension_traits( ActiveableExtensionTrait::class, true, 'is' );
			$this->is_active = $this->is_active && $this->maybe_check_is_active_local();
		}

		return $this->is_active;
	}

	// endregion

	// region HELPERS

	/**
	 * Check any potential local is_active logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @see     ActiveableLocalTrait::is_active_local()
	 *
	 * @return  bool
	 */
	protected function maybe_check_is_active_local(): bool {
		if ( in_array( ActiveableLocalTrait::class, Objects::class_uses_deep_list( $this ), true ) && method_exists( $this, 'is_active_local' ) ) {
			return $this->is_active_local();
		}

		return true;
	}

	// endregion
}
