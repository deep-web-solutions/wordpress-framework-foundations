<?php

namespace DeepWebSolutions\Framework\Utilities\Handlers\Traits;

use DeepWebSolutions\Framework\Helpers\WordPress\Traits\Assets as AssetsHelpers;
use DeepWebSolutions\Framework\Utilities\Handlers\AssetsHandler;

defined( 'ABSPATH' ) || exit;

/**
 * Trait for working with the assets handler.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.de>
 * @package DeepWebSolutions\WP-Framework\Utilities\Handlers\Traits
 */
trait Assets {
	use AssetsHelpers;

	/**
	 * Using classes should define their assets in here.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @param   AssetsHandler   $assets_handler      Instance of the hooks handler.
	 */
	abstract protected function enqueue_assets( AssetsHandler $assets_handler ): void;
}
