<?php

namespace DeepWebSolutions\Framework\Foundations\Utilities\Storage\Stores;

use DeepWebSolutions\Framework\Foundations\Utilities\Storage\AbstractStore;

\defined( 'ABSPATH' ) || exit;

/**
 * Reusable implementation of a basic user-meta store.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Utilities\Storage\Stores
 */
class UserMetaStore extends AbstractStore {
	// region METHODS

	use UserMetaStoreTrait;

	// endregion
}
