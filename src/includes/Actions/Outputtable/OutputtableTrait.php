<?php

namespace DeepWebSolutions\Framework\Foundations\Actions\Outputtable;

defined( 'ABSPATH' ) || exit;

/**
 * Basic implementation of the outputtable interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Actions\Outputtable
 */
trait OutputtableTrait {
	// region FIELDS AND CONSTANTS

	/**
	 * The result of the output operation. Null if successful.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     OutputFailureException|null
	 */
	protected ?OutputFailureException $output_result;

	/**
	 * Whether the using instance is outputted or not. Null if not decided yet.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     bool|null
	 */
	protected ?bool $is_outputted = null;

	// endregion

	// region GETTERS

	/**
	 * Returns the result of the output operation.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  OutputFailureException|null
	 */
	public function get_reset_result(): ?OutputFailureException {
		return $this->output_result;
	}

	/**
	 * Returns whether the using instance is outputted or not. Null if not decided yet.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  bool|null
	 */
	public function is_outputted(): ?bool {
		return $this->is_outputted;
	}

	// endregion

	// region METHODS

	/**
	 * Execute the output logic of the implementing class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	abstract public function output(): ?OutputFailureException;

	// endregion
}
