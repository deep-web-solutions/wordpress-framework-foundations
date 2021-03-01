<?php

namespace DeepWebSolutions\Framework\Foundations\Actions\Setupable;

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
	 * Execute the setup logic of the implementing class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	abstract public function setup(): ?SetupFailureException;

	// endregion
}
