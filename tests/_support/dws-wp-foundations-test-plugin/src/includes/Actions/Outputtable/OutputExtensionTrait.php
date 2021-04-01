<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\Outputtable;

use DeepWebSolutions\Framework\Foundations\Actions\Outputtable\OutputFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Outputtable\OutputLocalTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Outputtable\OutputtableExtensionTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Trait OutputtableExtensionTrait
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\Outputtable
 */
trait OutputExtensionTrait {
	// region TRAITS

	use OutputtableExtensionTrait;
	use OutputLocalTrait;

	// endregion

	// region METHODS

	/**
	 * Extension output logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  OutputFailureException|null
	 */
	abstract function output_extension(): ?OutputFailureException;

	// endregion
}
