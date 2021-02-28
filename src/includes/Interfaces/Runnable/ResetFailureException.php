<?php

namespace DeepWebSolutions\Framework\Interfaces\Runnable;

defined( 'ABSPATH' ) || exit;

/**
 * An exception thrown when a runnable object fails to reset.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Interfaces\Runnable
 */
class ResetFailureException extends \RuntimeException {
	/* empty on purpose */
}
