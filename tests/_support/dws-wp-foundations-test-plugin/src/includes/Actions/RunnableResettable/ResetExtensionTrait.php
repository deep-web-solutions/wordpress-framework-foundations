<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\RunnableResettable;

use DeepWebSolutions\Framework\Foundations\Actions\Resettable\ResetFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Resettable\ResetLocalTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Resettable\ResettableExtensionTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Trait ResetExtensionTrait
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\RunnableResettable
 */
trait ResetExtensionTrait {
	// region TRAITS

	use ResettableExtensionTrait;
	use ResetLocalTrait;

	// endregion

	// region METHODS

	/**
	 * Extension reset logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  ResetFailureException|null
	 */
	abstract function reset_extension(): ?ResetFailureException;

	// endregion
}
