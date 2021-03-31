<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions;

use DeepWebSolutions\Framework\Foundations\Actions\Setupable\SetupableTrait;
use DeepWebSolutions\Framework\Foundations\Actions\SetupableInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Class SetupableObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions
 */
class SetupableObject implements SetupableInterface {
	use SetupableTrait;

}