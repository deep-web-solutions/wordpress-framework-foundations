<?php

namespace DeepWebSolutions\Framework\Utilities\Handlers\Traits\Helpers;

use DeepWebSolutions\Framework\Helpers\WordPress\Traits\Assets as AssetsHelpers;
use DeepWebSolutions\Framework\Utilities\Interfaces\Resources\Identifiable;

defined( 'ABSPATH' ) || exit;

/**
 * Extends the helpers' Assets trait.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Utilities\Handlers\Traits\Helpers
 */
trait Assets {
	use AssetsHelpers {
		get_asset_handle as get_asset_handle_helpers;
	}

	/**
	 * Returns a meaningful, hopefully unique, handle for an asset.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @see     AssetsHelpers::get_asset_handle()
	 *
	 * @param   string  $name   The actual descriptor of the asset's purpose. Leave blank for default.
	 * @param   array   $extra  Further descriptor of the asset's purpose.
	 * @param   string  $root   Prepended to all asset handles inside the same class.
	 *
	 * @return  string
	 */
	public function get_asset_handle( string $name = '', array $extra = array(), string $root = '' ): string {
		if ( $this instanceof Identifiable ) {
			return $this->get_asset_handle_helpers(
				$name,
				$extra,
				$this->get_plugin()->get_plugin_slug() . '_' . ( $root ?: $this->get_instance_public_name() ) // phpcs:ignore
			);
		}

		return $this->get_asset_handle_helpers( $name, $extra, $root );
	}
}
