<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\Outputtable;

use DeepWebSolutions\Framework\Foundations\Actions\Outputtable\OutputFailureException;

\defined( 'ABSPATH' ) || exit;

/**
 * Class OutputtableExtensionObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\Outputtable
 */
class OutputtableExtensionObject extends OutputtableLocalObject {
	// region TRAITS

	use OutputExtensionTrait;

	// endregion

	// region FIELDS AND CONSTANTS

	/**
	 * Dummy extension output result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     OutputFailureException|null
	 */
	protected ?OutputFailureException $output_result_extension;

	// endregion

	// region MAGIC METHODS

	/**
	 * OutputtableExtensionObject constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   OutputFailureException|null     $output_result_local        Dummy local output result.
	 * @param   OutputFailureException|null     $output_result_exception    Dummy extension output result.
	 */
	public function __construct( ?OutputFailureException $output_result_local, ?OutputFailureException $output_result_exception ) {
		parent::__construct( $output_result_local );
		$this->output_result_extension = $output_result_exception;
	}

	// endregion

	// region INHERITED METHODS

	/**
	 * Returns the dummy extension output result.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  OutputFailureException|null
	 */
	protected function output_extension(): ?OutputFailureException {
		return $this->output_result_extension;
	}

	// endregion
}