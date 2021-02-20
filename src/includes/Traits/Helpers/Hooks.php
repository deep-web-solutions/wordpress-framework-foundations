<?php

namespace DeepWebSolutions\Framework\Utilities\Traits\Helpers;

use DeepWebSolutions\Framework\Helpers\WordPress\Traits\Hooks as HooksHelpers;
use DeepWebSolutions\Framework\Utilities\Interfaces\Resources\Identifiable;

defined( 'ABSPATH' ) || exit;

/**
 * Extends the helpers' Hooks trait.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Utilities\Traits\Helpers
 */
trait Hooks {
	use HooksHelpers {
		get_hook_name as get_hook_name_helpers;
	}

	/**
	 * Returns a meaningful, hopefully unique, name for an internal hook.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @see     HooksHelpers::get_hook_name()
	 *
	 * @param   string  $name       The actual descriptor of the hook's purpose.
	 * @param   array   $extra      Further descriptor of the hook's purpose.
	 * @param   string  $root       Prepended to all hooks inside the same class.
	 *
	 * @return  string
	 */
	public function get_hook_name( string $name, array $extra = array(), string $root = '' ): string {
		if ( $this instanceof Identifiable ) {
			return $this->get_hook_name_helpers(
				$name,
				$extra,
				$this->get_plugin()->get_plugin_slug() . '_' . ( $root ?: $this->get_instance_public_name() ) // phpcs:ignore
			);
		}

		return $this->get_hook_name_helpers( $name, $extra, $root );
	}
}
