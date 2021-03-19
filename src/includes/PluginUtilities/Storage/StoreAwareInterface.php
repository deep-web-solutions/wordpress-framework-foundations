<?php

namespace DeepWebSolutions\Framework\Foundations\PluginUtilities\Storage;

\defined( 'ABSPATH' ) || exit;

/**
 * Describes an instance aware of a store.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\PluginUtilities\Storage
 */
interface StoreAwareInterface {
	/**
	 * Gets an instance of a store.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  StoreInterface
	 */
	public function get_store(): StoreInterface;

	/**
	 * Sets a store on the instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   StoreInterface      $store      Store to use from now on.
	 */
	public function set_store( StoreInterface $store );
}
