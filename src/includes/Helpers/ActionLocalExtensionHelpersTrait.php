<?php

namespace DeepWebSolutions\Framework\Foundations\Helpers;

use DeepWebSolutions\Framework\Helpers\DataTypes\Objects;
use DeepWebSolutions\Framework\Helpers\DataTypes\Strings;

\defined( 'ABSPATH' ) || exit;

/**
 * Provides some useful helpers for working with local extension traits.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Helpers
 */
trait ActionLocalExtensionHelpersTrait {
	/**
	 * Execute the local extension trait action logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $extension_trait    The name of the extension trait to look for.
	 * @param   string  $method_prefix      The prefix of the local action method.
	 * @param   mixed   $success_return     Default return value on success.
	 *
	 * @return  mixed
	 */
	protected function maybe_execute_local_trait( string $extension_trait, string $method_prefix, $success_return = null ) {
		$method_name = "{$method_prefix}_local";
		if ( Objects::has_trait_deep( $extension_trait, $this ) && \method_exists( $this, $method_name ) ) {
			return $this->{$method_name}();
		}

		return $success_return;
	}
}
