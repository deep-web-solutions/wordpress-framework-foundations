<?php

namespace DeepWebSolutions\Framework\Foundations\Actions\Resetable;

defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of the resetable interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Actions\Resetable
 */
trait ResetableTrait {
	// region FIELDS AND CONSTANTS

	/**
	 * The result of the reset operation. Null if successful.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     ResetFailureException|null
	 */
	protected ?ResetFailureException $reset_result;

	/**
	 * Whether the using instance is reset or not. Null if not decided yet.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     bool|null
	 */
	protected ?bool $is_reset = null;

	// endregion

	// region GETTERS

	/**
	 * Returns the result of the reset operation.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  ResetFailureException|null
	 */
	public function get_reset_result(): ?ResetFailureException {
		return $this->reset_result;
	}

	/**
	 * Returns whether the using instance is reset or not. Null if not decided yet.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  bool|null
	 */
	public function is_reset(): ?bool {
		return $this->is_reset;
	}

	// endregion

	// region METHODS

	/**
	 * Execute the reset logic of the implementing class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	abstract public function reset(): ?ResetFailureException;

	// endregion
}
