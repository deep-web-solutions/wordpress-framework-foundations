<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\Initializable;

use DeepWebSolutions\Framework\Foundations\Actions\Initializable\InitializableTrait;
use DeepWebSolutions\Framework\Foundations\Actions\InitializableInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Class InitializableObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\Initializable
 */
class InitializableObject implements InitializableInterface {
	use InitializableTrait;
}