<?php

namespace DeepWebSolutions\Framework\Foundations\Logging;

use DeepWebSolutions\Framework\Foundations\PluginUtilities\Handlers\AbstractHandler;
use DeepWebSolutions\Framework\Foundations\PluginUtilities\Storage\StoreableTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Template for encapsulating some of the most often needed functionality of a logging handler.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Logging
 */
abstract class AbstractLoggingHandler extends AbstractHandler implements LoggingHandlerInterface {
	// region TRAITS

	use StoreableTrait;

	// endregion

	// region INHERITED METHODS

	/**
	 * Returns the type of the handler.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  string
	 */
	public function get_type(): string {
		return 'logging';
	}

	// endregion
}
