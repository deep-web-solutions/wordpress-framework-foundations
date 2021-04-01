<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Utilities;

use DeepWebSolutions\Framework\Foundations\Actions\OutputtableInterface;
use DeepWebSolutions\Framework\Foundations\Actions\ResettableInterface;
use DeepWebSolutions\Framework\Foundations\Actions\RunnableInterface;
use DeepWebSolutions\Framework\Foundations\Utilities\Handlers\Actions\OutputHandlers;
use DeepWebSolutions\Framework\Foundations\Utilities\Handlers\Actions\ResetHandlers;
use DeepWebSolutions\Framework\Foundations\Utilities\Handlers\Actions\RunHandlers;

\defined( 'ABSPATH' ) || exit;

/**
 * Class EnhancedMultiHandlerServiceObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Utilities
 */
class EnhancedMultiHandlerServiceObject extends MultiHandlerServiceObject implements OutputtableInterface, ResettableInterface, RunnableInterface {
	use OutputHandlers;
	use ResetHandlers;
	use RunHandlers;
}
