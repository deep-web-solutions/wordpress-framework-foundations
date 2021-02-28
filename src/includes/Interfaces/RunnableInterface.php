<?php

namespace DeepWebSolutions\Framework\Interfaces;

defined( 'ABSPATH' ) || exit;

/**
 * Describes an instance that needs to be configured before it can do anything. Implementing classes need to define the
 * logic of a 'run' method which should be called when the object has been fully configured.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Interfaces
 */
interface RunnableInterface {
	/**
	 * Should be called when the implementing class has been fully configured and should now perform its action.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function run(): ?Runnable\RunFailureException;

	/**
	 * Should be called when the implementing class should be set in a "clean-slate" state. After calling this function,
	 * the whole class should be ready for reuse as if just constructed.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function reset(): ?Runnable\ResetFailureException;
}
