<?php

namespace DeepWebSolutions\Framework\Utilities\Interfaces;

/**
 * If a class implements this interface, then every instance will have its 'run' function called
 * on every plugin initialization.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Utilities\Interfaces
 */
interface Runnable {
	/**
	 * Describes the initialization run logic of the implementing class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function run(): void;
}
