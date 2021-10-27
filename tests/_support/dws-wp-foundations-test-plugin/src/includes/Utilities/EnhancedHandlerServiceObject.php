<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Utilities;

use DeepWebSolutions\Framework\Foundations\Actions\OutputtableInterface;
use DeepWebSolutions\Framework\Foundations\Actions\ResettableInterface;
use DeepWebSolutions\Framework\Foundations\Actions\RunnableInterface;
use DeepWebSolutions\Framework\Foundations\Services\Actions\OutputHandlersTrait;
use DeepWebSolutions\Framework\Foundations\Services\Actions\ResetHandlersTrait;
use DeepWebSolutions\Framework\Foundations\Services\Actions\RunHandlersTrait;

\defined( 'ABSPATH' ) || exit;

/**
 * Class HandlerServiceObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Utilities
 */
class EnhancedHandlerServiceObject extends HandlerServiceObject implements OutputtableInterface, ResettableInterface, RunnableInterface {
	use OutputHandlersTrait;
	use ResetHandlersTrait;
	use RunHandlersTrait;
}
