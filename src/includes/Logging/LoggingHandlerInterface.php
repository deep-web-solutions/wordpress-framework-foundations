<?php

namespace DeepWebSolutions\Framework\Foundations\Logging;

use DeepWebSolutions\Framework\Foundations\Services\HandlerInterface;
use Psr\Log\LoggerInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Describes an instance of a logging handler compatible with the logging service.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Logging
 */
interface LoggingHandlerInterface extends HandlerInterface, LoggerInterface {
	/* empty on purpose */
}
