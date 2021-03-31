<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\RunnableResettable;

use DeepWebSolutions\Framework\Foundations\Actions\Resettable\ResettableTrait;
use DeepWebSolutions\Framework\Foundations\Actions\ResettableInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Class ResettableObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\RunnableResettable
 */
class ResettableObject implements ResettableInterface {
	use ResettableTrait;
}
