<?php

namespace DeepWebSolutions\Framework\Utilities\Interfaces\Traits;

defined( 'ABSPATH' ) || exit;

/**
 * Trait for working with the Activeable interface.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Utilities\Handlers\Traits
 */
trait Active {
	// region FIELDS AND CONSTANTS

	/**
	 * Whether the using instance is active or not.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     bool|null
	 */
	protected ?bool $active = null;

	// endregion

	
}
