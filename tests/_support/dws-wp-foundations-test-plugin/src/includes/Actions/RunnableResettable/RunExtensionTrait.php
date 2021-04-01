<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\RunnableResettable;

use DeepWebSolutions\Framework\Foundations\Actions\Runnable\RunFailureException;
use DeepWebSolutions\Framework\Foundations\Actions\Runnable\RunLocalTrait;
use DeepWebSolutions\Framework\Foundations\Actions\Runnable\RunnableExtensionTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Trait RunExtensionTrait
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\RunnableResettable
 */
trait RunExtensionTrait {
	// region TRAITS

	use RunnableExtensionTrait;
	use RunLocalTrait;

	// endregion

	// region METHODS

	/**
	 * Extension run logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  RunFailureException|null
	 */
	abstract function run_extension(): ?RunFailureException;

	// endregion
}
