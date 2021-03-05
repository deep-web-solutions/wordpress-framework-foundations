<?php

namespace DeepWebSolutions\Framework\Foundations\Helpers;

use DeepWebSolutions\Framework\Helpers\DataTypes\Objects;
use DeepWebSolutions\Framework\Helpers\DataTypes\Strings;

defined( 'ABSPATH' ) || exit;

/**
 * Provides some useful helpers for working with extension traits.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Helpers
 */
trait ActionExtensionHelpersTrait {
	/**
	 * Execute any potential extension trait action logic.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   string  $extension_trait    The name of the extension trait to look for.
	 * @param   mixed   $success_return     Default return value on success.
	 * @param   string  $prefix             Optional method name prefix.
	 *
	 * @return  mixed
	 */
	protected function maybe_execute_extension_traits( string $extension_trait, $success_return = null, string $prefix = '' ) {
		if ( Objects::has_trait_deep( $extension_trait, $this ) ) {
			foreach ( Objects::class_uses_deep( $this ) as $trait_name => $deep_used_traits ) {
				if ( false === array_search( $extension_trait, $deep_used_traits, true ) ) {
					continue;
				}

				$trait_boom  = explode( '\\', $trait_name );
				$method_name = ltrim( $prefix . strtolower( preg_replace( '/([A-Z]+)/', '_${1}', end( $trait_boom ) ) ), '_' );
				$method_name = Strings::ends_with( $method_name, '_trait' ) ? str_replace( '_trait', '', $method_name ) : $method_name;

				if ( method_exists( $this, $method_name ) ) {
					$result = $this->{$method_name}();

					if ( ! is_null( $result ) ) {
						return $result;
					}
				}
			}
		}

		return $success_return;
	}
}
