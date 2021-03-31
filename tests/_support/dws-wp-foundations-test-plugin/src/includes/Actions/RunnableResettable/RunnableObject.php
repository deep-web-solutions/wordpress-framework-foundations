<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\RunnableResettable;

use DeepWebSolutions\Framework\Foundations\Actions\Runnable\RunnableTrait;
use DeepWebSolutions\Framework\Foundations\Actions\RunnableInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Class RunnableObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\RunnableResettable
 */
class RunnableObject implements RunnableInterface {
	use RunnableTrait;
}
