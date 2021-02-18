<?php

namespace DeepWebSolutions\Framework\Utilities\Handlers\Traits;

use DeepWebSolutions\Framework\Helpers\WordPress\Traits\Assets as AssetsHelpers;
use DeepWebSolutions\Framework\Utilities\Handlers\AssetsHandler;
use DeepWebSolutions\Framework\Utilities\Interfaces\Resources\Identifiable;

defined( 'ABSPATH' ) || exit;

/**
 * Trait for working with the assets handler.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Utilities\Handlers\Traits
 */
trait Assets {
	use AssetsHelpers {
		get_asset_handle as get_asset_handle_helpers;
	}

	// region FIELDS AND CONSTANTS

	/**
	 * Assets handler for registering CSS and JS assets.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @access  protected
	 * @var     AssetsHandler
	 */
	protected AssetsHandler $assets_handler;

	// endregion

	// region GETTERS

	/**
	 * Gets the assets handler instance.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  AssetsHandler
	 */
	protected function get_assets_handler(): AssetsHandler {
		return $this->assets_handler;
	}

	// endregion

	// region SETTERS

	/**
	 * Sets the assets handler.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   AssetsHandler     $assets_handler   Instance of the assets handler.
	 */
	public function set_assets_handler( AssetsHandler $assets_handler ): void {
		$this->assets_handler = $assets_handler;
	}

	// endregion

	// region METHODS

	/**
	 * Using classes should define their assets in here.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   AssetsHandler   $assets_handler      Instance of the hooks handler.
	 */
	abstract protected function enqueue_assets( AssetsHandler $assets_handler ): void;

	// endregion

	// region HELPERS

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

	// endregion
}
