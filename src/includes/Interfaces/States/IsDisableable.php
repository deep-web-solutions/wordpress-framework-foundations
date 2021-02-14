<?php

namespace DeepWebSolutions\Framework\Utilities\Interfaces\States;

defined( 'ABSPATH' ) || exit;

/**
 * Implementing classes need to define the logic of an 'is_disabled' method which determines whether the class is disabled or not.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Utilities\Interfaces\States
 */
interface IsDisableable {
	/**
	 * Should define logic for determining whether the implementing class is disabled or not.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 */
	public function is_disabled(): bool;
}
