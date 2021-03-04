<?php

namespace DeepWebSolutions\Framework\Foundations\Actions\Initializable;

use DeepWebSolutions\Framework\Foundations\Helpers\ActionExtensionHelpersTrait;
use DeepWebSolutions\Framework\Helpers\DataTypes\Objects;
use DeepWebSolutions\Framework\Helpers\DataTypes\Strings;

defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of the initializable interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Actions\Initializable
 */
trait InitializableTrait {
	// region TRAITS

	use ActionExtensionHelpersTrait;

	// endregion

	// region FIELDS AND CONSTANTS

	/**
	 * The result of the initialize operation. Null if successful.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     InitializationFailureException|null
	 */
	protected ?InitializationFailureException $initialization_result;

	/**
	 * Whether the using instance is initialized or not. Null if not decided yet.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     bool|null
	 */
	protected ?bool $is_initialized = null;

	// endregion

	// region GETTERS

	/**
	 * Returns the result of the initialization operation.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  InitializationFailureException|null
	 */
	public function get_initialization_result(): ?InitializationFailureException {
		return $this->initialization_result;
	}

	/**
	 * Returns whether the using instance is initialized or not. Null if not decided yet.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  bool|null
	 */
	public function is_initialized(): ?bool {
		return $this->is_initialized;
	}

	// endregion

	// region METHODS

	/**
	 * Simple initialization logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function initialize(): ?InitializationFailureException {
		if ( is_null( $this->is_initialized ) ) {
			if ( ! is_null( $result = $this->maybe_action_extension_traits( InitializableExtensionTrait::class ) ) ) { // phpcs:ignore
				$this->is_initialized        = false;
				$this->initialization_result = $result;
			} elseif ( ! is_null( $result = $this->maybe_initialize_local() ) ) { // phpcs:ignore
				$this->is_initialized        = false;
				$this->initialization_result = $result;
			} else {
				$this->is_initialized        = true;
				$this->initialization_result = null;
			}
		}

		return $this->initialization_result;
	}

	// endregion

	// region HELPERS

	/**
	 * Execute any potential local initialization logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @see     InitializableLocalTrait::initialize_local()
	 *
	 * @return  InitializationFailureException|null
	 */
	protected function maybe_initialize_local(): ?InitializationFailureException {
		if ( in_array( InitializableLocalTrait::class, Objects::class_uses_deep_list( $this ), true ) && method_exists( $this, 'initialize_local' ) ) {
			return $this->initialize_local();
		}

		return null;
	}

	// endregion
}
