<?php

namespace DeepWebSolutions\Framework\Foundations\Exceptions;

use Psr\Container\NotFoundExceptionInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * An exception thrown when something is not found.
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Foundations\Exceptions
 */
class NotFoundException extends \RuntimeException implements NotFoundExceptionInterface {
	/* empty on purpose */
}
