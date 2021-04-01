<?php

namespace DeepWebSolutions\Framework\Foundations\Helpers;

use DeepWebSolutions\Framework\Foundations\Plugin\PluginAwareInterface;
use DeepWebSolutions\Framework\Foundations\Plugin\PluginInterface;
use DeepWebSolutions\Framework\Foundations\PluginComponent\PluginComponentInterface;
use DeepWebSolutions\Framework\Helpers\WordPress\Hooks\HooksHelpersTrait as HelpersModuleTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Enhances the helpers' module Hooks trait.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Helpers
 */
trait HooksHelpersTrait {
	use HelpersModuleTrait {
		get_hook_tag as protected get_hook_tag_helpers;
	}

	/**
	 * Returns a meaningful, hopefully unique, name for an internal hook.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @see     HelpersModuleTrait::get_hook_tag()
	 *
	 * @param   string  $name       The actual descriptor of the hook's purpose.
	 * @param   array   $extra      Further descriptor of the hook's purpose.
	 * @param   string  $root       Prepended to all hooks inside the same class.
	 *
	 * @return  string
	 */
	public function get_hook_tag( string $name, array $extra = array(), string $root = 'dws_framework_foundations' ): string {
		if ( $this instanceof PluginComponentInterface ) {
			$root = ( 'dws_framework_foundations' === $root ) ? '' : $root;
			$root = \join( '-', array( $this->get_plugin()->get_plugin_safe_slug(), $root ?: $this->get_safe_name() ) ); // phpcs:ignore
		} elseif ( 'dws_framework_foundations' === $root ) {
			if ( $this instanceof PluginAwareInterface ) {
				$root = $this->get_plugin()->get_plugin_safe_slug();
			} elseif ( $this instanceof PluginInterface ) {
				$root = $this->get_plugin_safe_slug();
			}
		}

		return $this->get_hook_tag_helpers( $name, $extra, $root );
	}
}
