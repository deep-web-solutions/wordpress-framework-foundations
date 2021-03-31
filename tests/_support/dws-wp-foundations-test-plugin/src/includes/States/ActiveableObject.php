<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\States;

use DeepWebSolutions\Framework\Foundations\States\Activeable\ActiveableTrait;
use DeepWebSolutions\Framework\Foundations\States\ActiveableInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Class ActiveableObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\States
 */
class ActiveableObject implements ActiveableInterface {
	use ActiveableTrait;
}
