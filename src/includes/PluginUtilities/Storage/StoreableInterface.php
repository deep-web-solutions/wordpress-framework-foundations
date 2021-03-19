<?php

namespace DeepWebSolutions\Framework\Foundations\PluginUtilities\Storage;

\defined( 'ABSPATH' ) || exit;

/**
 * Describes a storeable instance. Storeables are objects that can be passed on to stores to perform operations on.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\PluginUtilities\Storage
 */
interface StoreableInterface {
	/**
	 * Returns the ID of the instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_id(): string;
}
