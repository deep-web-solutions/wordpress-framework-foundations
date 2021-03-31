<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\States;

use DeepWebSolutions\Framework\Foundations\States\Disableable\DisableableTrait;
use DeepWebSolutions\Framework\Foundations\States\DisableableInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Class ActiveableObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\States
 */
class DisableableObject implements DisableableInterface {
	use DisableableTrait;
}
