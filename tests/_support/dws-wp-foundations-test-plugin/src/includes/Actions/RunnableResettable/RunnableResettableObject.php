<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\RunnableResettable;

use DeepWebSolutions\Framework\Foundations\Actions\Resettable\ResettableTrait;
use DeepWebSolutions\Framework\Foundations\Actions\ResettableInterface;
use DeepWebSolutions\Framework\Foundations\Actions\Runnable\RunnableTrait;
use DeepWebSolutions\Framework\Foundations\Actions\RunnableInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Class RunnableResettableObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\RunnableResettable
 */
class RunnableResettableObject implements RunnableInterface, ResettableInterface {
	use ResettableTrait;
	use RunnableTrait;
}
