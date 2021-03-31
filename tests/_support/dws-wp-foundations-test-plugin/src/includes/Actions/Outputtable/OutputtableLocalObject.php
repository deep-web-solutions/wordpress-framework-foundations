<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\Outputtable;

use DeepWebSolutions\Framework\Foundations\Actions\Outputtable\OutputFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Outputtable\OutputLocalTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Class OutputtableLocalObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\Outputtable
 */
class OutputtableLocalObject extends OutputtableObject {
	// region TRAITS

	use OutputLocalTrait;

	// endregion

	// region FIELDS AND CONSTANTS

	/**
	 * Dummy local output result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     OutputFailureException|null
	 */
	protected ?OutputFailureException $output_result_local;

	// endregion

	// region MAGIC METHODS

	/**
	 * OutputtableLocalObject constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   OutputFailureException|null     $output_result_local    Dummy local output result.
	 */
	public function __construct( ?OutputFailureException $output_result_local ) {
		$this->output_result_local = $output_result_local;
	}

	// endregion

	// region INHERITED METHODS

	/**
	 * Returns the dummy local output result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  OutputFailureException|null
	 */
	protected function output_local(): ?OutputFailureException {
		return $this->output_result_local;
	}

	// endregion
}
