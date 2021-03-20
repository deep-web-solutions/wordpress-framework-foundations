<?php

namespace DeepWebSolutions\Framework\Foundations\PluginUtilities\Storage\Stores;

use DeepWebSolutions\Framework\Foundations\PluginUtilities\Storage\AbstractStore;

\defined( 'ABSPATH' ) || exit;

/**
 * Reusable implementation of a basic options-table store.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\PluginUtilities\Storage\Stores
 */
class OptionsStore extends AbstractStore {
	// region METHODS

	use OptionsStoreTrait;

	// endregion
}
