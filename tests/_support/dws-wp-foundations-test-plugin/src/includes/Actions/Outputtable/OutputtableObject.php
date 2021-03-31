<?php

namespace DeepWebSolutions\Framework\Tests\Foundations\Actions\Outputtable;

use DeepWebSolutions\Framework\Foundations\Actions\Outputtable\OutputtableTrait;
use DeepWebSolutions\Framework\Foundations\Actions\OutputtableInterface;

\defined( 'ABSPATH' ) || exit;

/**
 * Class OutputtableObject
 *
 * @since   1.0.0
 * @version 1.0.0
 * @author  Antonius Hegyes <a.hegyes@deep-web-solutions.com>
 * @package DeepWebSolutions\WP-Framework\Tests\Foundations\Actions\Outputtable
 */
class OutputtableObject implements OutputtableInterface {
	use OutputtableTrait;
}
