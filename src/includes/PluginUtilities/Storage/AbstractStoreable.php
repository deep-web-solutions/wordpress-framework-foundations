<?php

namespace DeepWebSolutions\Framework\Foundations\PluginUtilities\Storage;

\defined( 'ABSPATH' ) || exit;

/**
 * Template for encapsulating some of the most often needed required abilities of a storeable object.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\PluginUtilities\Storage
 */
abstract class AbstractStoreable implements StoreableInterface {
	// region TRAITS

	use StoreableTrait;

	// endregion

	// region MAGIC METHODS

	/**
	 * AbstractStoreable constructor.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $storeable_id   The ID of the instance.
	 */
	public function __construct( string $storeable_id ) {
		$this->storeable_id = $storeable_id;
	}

	// endregion
}
